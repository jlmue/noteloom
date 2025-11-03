<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 20 example notes for testing purposes.
     */
    public function run(): void
    {
        // Get the first user
        $user = User::query()
            ->first();

        // Create exactly 20 notes for the user
        // The factory will randomly select from the predefined examples
        Note::factory()
            ->count(100)
            ->for($user)
            ->create();

        $this->command->info('✅ Successfully created 20 example notes for user: '.$user->name);
    }
}
