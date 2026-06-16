<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $isRecruiter = $request->account_type === 'recruiter';

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'account_type' => $isRecruiter ? 'recruiter' : 'student',
        ];

        if ($isRecruiter) {
            $data['company_name']     = $request->company_name;
            $data['recruiter_status'] = 'pending';
            // Work badges contain personal data — keep them on the private disk
            $data['badge_path']       = $request->file('badge')->store('badges', 'local');
        }

        $user = User::create($data);

        // Sends the email verification link (MAIL_MAILER=log → storage/logs/laravel.log)
        event(new Registered($user));

        // Auto-login after registration
        Auth::login($user);

        if ($isRecruiter) {
            return redirect('/')->with('success',
                'Votre compte recruteur a été créé. Votre badge est en cours de vérification par un administrateur — vous pourrez consulter les CV une fois votre compte approuvé.');
        }

        return redirect('/')->with('success', 'Votre compte étudiant a été créé avec succès !');
    }

    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        // The uit.ac.ma restriction applies to student accounts only.
        // Recruiters authenticate with their external company email.
        $existing = User::where('email', $credentials['email'])->first();
        $isStudentAccount = !$existing || $existing->account_type === 'student';

        if ($isStudentAccount && !preg_match('/^.+@([a-zA-Z0-9\-]+\.)*uit\.ac\.ma$/i', $credentials['email'])) {
            return back()->withErrors([
                'email' => 'Accès refusé. Les comptes étudiants doivent utiliser une adresse @uit.ac.ma.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Connexion réussie. Bon retour, ' . Auth::user()->name . ' !');
        }

        return back()->withErrors([
            'email' => 'Les identifiants saisis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Show the "forgot password" form.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send the password reset link email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show the password reset form for a given token.
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Handle the password reset submission.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.')
            : back()->withErrors(['email' => __($status)]);
    }
}
