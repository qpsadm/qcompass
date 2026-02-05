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

        $this->call([
            CategoriesSeeder::class,
            AnnouncementTypesSeeder::class,
            CoursesSeeder::class,
            UsersSeeder::class,
            CourseTypesSeeder::class,
            CourseUserSeeder::class,
            DivisionSeeder::class,
            LevelsSeeder::class,
            OrganizersSeeder::class,
            RolesSeeder::class,
            TagsSeeder::class,
            ThemesSeeder::class,


        ]);
    }
}
