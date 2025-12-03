<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // OrganizersSeeder::class,
            // CategoriesSeeder::class,
            // DivisionSeeder::class,
            // RolesSeeder::class,
            // ThemesSeeder::class,
            // LevelsSeeder::class,
            // TagsSeeder::class,
            // AnnouncementTypesSeeder::class,
            // UsersSeeder::class,
            // CourseTypesSeeder::class,
            // CoursesSeeder::class,
            // CourseUserSeeder::class,

        ]);
    }
}
