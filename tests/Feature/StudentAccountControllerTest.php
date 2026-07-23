<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentAccountControllerTest extends TestCase
{
    use RefreshDatabase;

    private function student(): User
    {
        return User::factory()->create([
            'name' => 'Mahasiswa Skriptif',
            'email' => 'mahasiswa@example.test',
            'role' => 'mahasiswa',
            'password' => Hash::make('password-lama'),
        ]);
    }

    public function test_student_can_view_profile_page(): void
    {
        $student = $this->student();

        $this->actingAs($student)
            ->get(route('student.profile.show'))
            ->assertOk()
            ->assertViewIs('auth.student-profile')
            ->assertSee('Mahasiswa Skriptif');
    }

    public function test_student_can_update_profile(): void
    {
        $student = $this->student();

        $this->actingAs($student)
            ->put(route('student.profile.update'), [
                'name' => 'Mahasiswa Baru',
                'email' => 'baru@example.test',
            ])
            ->assertRedirect(route('student.profile.show'));

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'name' => 'Mahasiswa Baru',
            'email' => 'baru@example.test',
        ]);
    }

    public function test_student_can_view_change_password_page(): void
    {
        $student = $this->student();

        $this->actingAs($student)
            ->get(route('student.password.edit'))
            ->assertOk()
            ->assertViewIs('auth.student-change-password');
    }

    public function test_student_can_change_password_with_correct_current_password(): void
    {
        $student = $this->student();

        $this->actingAs($student)
            ->put(route('student.password.update'), [
                'current_password' => 'password-lama',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ])
            ->assertRedirect(route('student.password.edit'));

        $this->assertTrue(Hash::check('password-baru', $student->fresh()->password));
    }
}
