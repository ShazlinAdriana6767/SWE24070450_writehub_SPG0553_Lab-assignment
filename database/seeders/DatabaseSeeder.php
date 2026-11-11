<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $alice = $this->makeUser('Alice Admin', 'admin@example.com', true);
        $bob   = $this->makeUser('Bob Writer', 'bob@example.com');
        $carol = $this->makeUser('Carol Writer', 'carol@example.com');

        $bob->articles()->create([
            'title' => 'Getting Started with Laravel',
            'category' => 'tutorial',
            'reading_time' => 8,
            'body' => 'A friendly walkthrough of installing Laravel and building your first page.',
            'status' => 'published',
        ]);

        $bob->articles()->create([
            'title' => 'Why Policies Beat Inline Checks',
            'category' => 'opinion',
            'reading_time' => 5,
            'body' => 'Keeping authorization rules in one policy class makes them easier to test.',
            'status' => 'draft',
        ]);

        $carol->articles()->create([
            'title' => 'Campus Hackathon Recap',
            'category' => 'news',
            'reading_time' => 4,
            'body' => 'Forty students built twelve projects during the weekend hackathon.',
            'status' => 'published',
        ]);

        $carol->articles()->create([
            'title' => 'Understanding Form Requests',
            'category' => 'tutorial',
            'reading_time' => 10,
            'body' => 'Form requests move validation and authorization out of your controllers.',
            'status' => 'draft',
        ]);

        $alice->articles()->create([
            'title' => 'Admin Notes on Moderation',
            'category' => 'opinion',
            'reading_time' => 3,
            'body' => 'How the editorial team reviews and publishes submitted articles.',
            'status' => 'published',
        ]);
    }

    private function makeUser(string $name, string $email, bool $isAdmin = false): User
    {
        return User::factory()->create([
            'name' => $name,
            'email' => $email,
            'is_admin' => $isAdmin,
            // plain email + password login: switch two-factor off for seeded accounts
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }
}