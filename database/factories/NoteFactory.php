<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Predefined realistic note examples
     */
    private array $noteExamples = [
        [
            'title' => 'Meeting Notes - Q4 Planning',
            'content' => 'Discussed Q4 goals and objectives. Key action items: review budget, finalize team assignments, and schedule follow-up meeting for next week.',
            'is_important' => true,
        ],
        [
            'title' => 'Grocery List',
            'content' => 'Milk, eggs, bread, coffee, vegetables, fruits, chicken, pasta, olive oil, and cheese. Don\'t forget the organic tomatoes!',
            'is_important' => false,
        ],
        [
            'title' => 'Project Ideas',
            'content' => 'Build a task management app with real-time collaboration. Consider using WebSockets and a modern frontend framework.',
            'is_important' => true,
        ],
        [
            'title' => 'Book Recommendations',
            'content' => 'Clean Code by Robert Martin, The Pragmatic Programmer, Design Patterns, and Refactoring by Martin Fowler.',
            'is_important' => false,
        ],
        [
            'title' => 'Password Reset Reminder',
            'content' => 'Need to update passwords for email, cloud storage, and development accounts by end of month. Use strong unique passwords!',
            'is_important' => true,
        ],
        [
            'title' => 'Travel Plans - Summer Vacation',
            'content' => 'Destinations to consider: Barcelona, Tokyo, or Iceland. Check flight prices and hotel availability. Book at least 2 months in advance.',
            'is_important' => false,
        ],
        [
            'title' => 'Workout Routine',
            'content' => 'Monday: Upper body, Tuesday: Cardio, Wednesday: Lower body, Thursday: Rest, Friday: Full body, Weekend: Yoga or hiking.',
            'is_important' => false,
        ],
        [
            'title' => 'Bug Fix - Login Issue',
            'content' => 'Users reported unable to login with special characters in password. Issue: password encoding on frontend. Fix: update validation regex.',
            'is_important' => true,
        ],
        [
            'title' => 'Gift Ideas',
            'content' => 'For Mom: gardening tools, For Dad: biography book, For sister: art supplies, For brother: tech gadget.',
            'is_important' => false,
        ],
        [
            'title' => 'Code Review Checklist',
            'content' => 'Check for: proper error handling, security vulnerabilities, test coverage, documentation, naming conventions, and performance issues.',
            'is_important' => true,
        ],
        [
            'title' => 'Recipe - Pasta Carbonara',
            'content' => 'Ingredients: spaghetti, eggs, parmesan, pancetta, black pepper. Cook pasta al dente, mix eggs with cheese, combine with hot pasta and crispy pancetta.',
            'is_important' => false,
        ],
        [
            'title' => 'Learning Goals 2025',
            'content' => 'Master Docker and Kubernetes, learn GraphQL, improve TypeScript skills, contribute to open source, and read 12 technical books.',
            'is_important' => true,
        ],
        [
            'title' => 'Home Maintenance',
            'content' => 'Schedule HVAC service, clean gutters, check smoke detectors, replace air filters, and organize garage.',
            'is_important' => false,
        ],
        [
            'title' => 'Client Feedback',
            'content' => 'Client loves the new dashboard design. Requested: add export to PDF feature, improve mobile responsiveness, and add dark mode option.',
            'is_important' => true,
        ],
        [
            'title' => 'Podcast Recommendations',
            'content' => 'Syntax.fm for web development, ShopTalk Show, The Changelog, CodeNewbie, and Darknet Diaries for security stories.',
            'is_important' => false,
        ],
        [
            'title' => 'Database Migration Plan',
            'content' => 'Migrate from MySQL to PostgreSQL. Steps: backup data, test migration script on staging, schedule downtime, execute migration, verify data integrity.',
            'is_important' => true,
        ],
        [
            'title' => 'Birthday Party Planning',
            'content' => 'Date: Next Saturday. Venue: Community center. Guest list: 25 people. Food: Pizza and cake. Entertainment: DJ and games.',
            'is_important' => false,
        ],
        [
            'title' => 'API Documentation',
            'content' => 'Update API docs for new endpoints. Include authentication examples, error codes, rate limiting info, and usage examples for each endpoint.',
            'is_important' => true,
        ],
        [
            'title' => 'Morning Routine Ideas',
            'content' => 'Wake up at 6 AM, meditation for 10 minutes, exercise for 30 minutes, healthy breakfast, review daily goals, and plan the day ahead.',
            'is_important' => false,
        ],
        [
            'title' => 'Security Audit Findings',
            'content' => 'CRITICAL: Update outdated dependencies, implement rate limiting on API, add CSRF protection, enable 2FA for admin accounts, and review access logs.',
            'is_important' => true,
        ],
    ];

    /**
     * Define the model's default state.
     * Randomly selects from predefined examples or generates random content.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random note example
        $noteExample = fake()->randomElement($this->noteExamples);

        return [
            'user_id' => User::factory(),
            'title' => $noteExample['title'],
            'content' => $noteExample['content'],
            'is_important' => $noteExample['is_important'],
            'created_at' => fake()->dateTimeBetween('-3 months'),
            'updated_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }

    /**
     * Mark note as important
     */
    public function important(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_important' => true,
        ]);
    }

    /**
     * Mark note as not important
     */
    public function notImportant(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_important' => false,
        ]);
    }
}
