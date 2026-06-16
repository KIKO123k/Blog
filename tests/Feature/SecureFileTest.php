<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * The CV access rule is the most sensitive rule of the platform:
 * a CV must be reachable ONLY by its owner or a verified recruiter,
 * and only through the authorized /files/cv route (private disk).
 */
class SecureFileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Students must carry a uit.ac.ma address, otherwise the
     * EnsureUitDomain middleware logs them out mid-test.
     */
    private function student(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'account_type' => 'student',
            'email'        => fake()->unique()->userName() . '@uit.ac.ma',
        ], $attributes));
    }

    private function studentWithCv(): User
    {
        Storage::fake('local');

        $owner = $this->student();
        $path  = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf')
            ->store('cvs', 'local');
        $owner->update(['cv_path' => $path]);

        return $owner;
    }

    public function test_guest_cannot_download_cv(): void
    {
        $owner = $this->studentWithCv();

        $this->get(route('files.cv', $owner))->assertRedirect(route('login'));
    }

    public function test_other_student_cannot_download_cv(): void
    {
        $owner = $this->studentWithCv();
        $otherStudent = $this->student();

        $this->actingAs($otherStudent)
            ->get(route('files.cv', $owner))
            ->assertForbidden();
    }

    public function test_pending_recruiter_cannot_download_cv(): void
    {
        $owner = $this->studentWithCv();
        $pendingRecruiter = User::factory()->create([
            'account_type'     => 'recruiter',
            'company_name'     => 'Acme Corp',
            'recruiter_status' => 'pending',
        ]);

        $this->actingAs($pendingRecruiter)
            ->get(route('files.cv', $owner))
            ->assertForbidden();
    }

    public function test_owner_can_download_own_cv(): void
    {
        $owner = $this->studentWithCv();

        $this->actingAs($owner)
            ->get(route('files.cv', $owner))
            ->assertOk();
    }

    public function test_approved_recruiter_can_download_cv(): void
    {
        $owner = $this->studentWithCv();
        $approvedRecruiter = User::factory()->create([
            'account_type'     => 'recruiter',
            'company_name'     => 'Acme Corp',
            'recruiter_status' => 'approved',
        ]);

        $this->actingAs($approvedRecruiter)
            ->get(route('files.cv', $owner))
            ->assertOk();
    }

    public function test_cv_route_returns_404_when_user_has_no_cv(): void
    {
        $owner  = $this->student();
        $viewer = User::factory()->create([
            'account_type'     => 'recruiter',
            'recruiter_status' => 'approved',
        ]);

        $this->actingAs($viewer)
            ->get(route('files.cv', $owner))
            ->assertNotFound();
    }

    public function test_guest_cannot_download_internship_report(): void
    {
        $owner = $this->student();
        $internship = $owner->internships()->create([
            'company'     => 'Test SARL',
            'position'    => 'Stagiaire',
            'period'      => 'Juin 2026',
            'type'        => 'observation',
            'report_path' => 'reports/r.pdf',
        ]);

        $this->get(route('files.report', $internship))->assertRedirect(route('login'));
    }
}
