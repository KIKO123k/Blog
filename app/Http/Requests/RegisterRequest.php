<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize input before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'account_type' => in_array($this->account_type, ['student', 'recruiter'], true)
                ? $this->account_type
                : 'student',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $isRecruiter = $this->account_type === 'recruiter';

        return [
            'account_type' => ['required', 'in:student,recruiter'],
            'name'         => ['required', 'string', 'max:255'],
            'email'        => [
                'required', 'string', 'email', 'max:255', 'unique:users',
                // Students must use an institutional uit.ac.ma address.
                // Recruiters register with their company email (any domain).
                Rule::when(!$isRecruiter, ['regex:/^.+@([a-zA-Z0-9\-]+\.)*uit\.ac\.ma$/i']),
            ],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],

            // Recruiter-only verification fields
            'company_name' => [Rule::requiredIf($isRecruiter), 'nullable', 'string', 'max:255'],
            'badge'        => [Rule::requiredIf($isRecruiter), 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required'         => 'Le nom est obligatoire.',
            'name.max'              => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.email'           => 'Veuillez entrer une adresse e-mail valide.',
            'email.max'             => 'L\'adresse e-mail ne peut pas dépasser 255 caractères.',
            'email.unique'          => 'Cette adresse e-mail est déjà utilisée.',
            'email.regex'           => 'En tant qu\'étudiant, vous devez utiliser une adresse @uit.ac.ma (ex: nom@uit.ac.ma).',
            'password.required'     => 'Le mot de passe est obligatoire.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'    => 'La confirmation du mot de passe ne correspond pas.',
            'company_name.required' => 'Le nom de l\'entreprise est obligatoire pour les recruteurs.',
            'badge.required'        => 'Veuillez téléverser une photo de votre badge professionnel.',
            'badge.image'           => 'Le badge doit être une image (JPG, PNG ou WEBP).',
            'badge.max'             => 'L\'image du badge ne doit pas dépasser 4 Mo.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name'         => 'nom',
            'email'        => 'adresse e-mail',
            'password'     => 'mot de passe',
            'company_name' => 'nom de l\'entreprise',
            'badge'        => 'badge professionnel',
        ];
    }
}
