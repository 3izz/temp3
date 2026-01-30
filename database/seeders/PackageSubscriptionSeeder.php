<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingPlan;
use App\Models\Course;
use App\Models\User;

class PackageSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Create sample pricing plans and link them to existing courses
     */
    public function run(): void
    {
        // Get or create a coach user for course assignment
        $coach = User::where('role', 'coach')->first();
        if (!$coach) {
            $coach = User::create([
                'name' => 'Sample Coach',
                'email' => 'coach@sample.com',
                'password' => bcrypt('password'),
                'role' => 'coach',
            ]);
        }

        // Create sample courses if they don't exist
        $courses = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript',
                'level' => 'beginner',
                'duration' => '8 weeks',
                'category' => 'Web Development',
                'language' => 'English',
                'status' => 'active',
                'instructor_id' => $coach->id,
            ],
            [
                'title' => 'Advanced React Development',
                'description' => 'Master React.js with advanced concepts and best practices',
                'level' => 'advanced',
                'duration' => '12 weeks',
                'category' => 'Web Development',
                'language' => 'English',
                'status' => 'active',
                'instructor_id' => $coach->id,
            ],
            [
                'title' => 'Python for Data Science',
                'description' => 'Learn Python programming for data analysis and machine learning',
                'level' => 'intermediate',
                'duration' => '10 weeks',
                'category' => 'Data Science',
                'language' => 'English',
                'status' => 'active',
                'instructor_id' => $coach->id,
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Build native mobile applications for iOS and Android',
                'level' => 'intermediate',
                'duration' => '14 weeks',
                'category' => 'Mobile Development',
                'language' => 'English',
                'status' => 'active',
                'instructor_id' => $coach->id,
            ],
            [
                'title' => 'Database Design & SQL',
                'description' => 'Master database design principles and SQL programming',
                'level' => 'beginner',
                'duration' => '6 weeks',
                'category' => 'Database',
                'language' => 'English',
                'status' => 'active',
                'instructor_id' => $coach->id,
            ],
        ];

        $createdCourses = [];
        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(
                ['title' => $courseData['title']],
                $courseData
            );
            $createdCourses[] = $course;
        }

        // Create pricing plans
        $pricingPlans = [
            [
                'name' => 'Individual Starter',
                'description' => 'Perfect for individuals looking to start their learning journey',
                'price' => 99.99,
                'max_courses' => 2, // Allow 2 course selection
                'target_type' => 'individual',
                'delivery_mode' => 'one_on_one',
                'schedule_type' => 'flexible',
                'is_popular' => false,
                'course_indices' => [0, 1], // Link to first 2 courses
            ],
            [
                'name' => 'Professional Plus',
                'description' => 'Comprehensive package for professionals seeking career advancement',
                'price' => 299.99,
                'max_courses' => 5, // Allow 5 course selection
                'target_type' => 'individual',
                'delivery_mode' => 'one_on_one',
                'schedule_type' => 'choose',
                'is_popular' => true,
                'course_indices' => [1, 2, 3], // Link to courses 2, 3, 4
            ],
            [
                'name' => 'College Program',
                'description' => 'Specialized package for college students and academic institutions',
                'price' => 199.99,
                'max_courses' => 8, // Allow 8 course selection
                'target_type' => 'group',
                'delivery_mode' => 'one_to_many',
                'schedule_type' => 'fixed',
                'is_popular' => true,
                'course_indices' => [0, 2, 4], // Link to courses 1, 3, 5
            ],
            [
                'name' => 'Enterprise Training',
                'description' => 'Complete training solution for corporate teams and organizations',
                'price' => 999.99,
                'max_courses' => 15, // Allow 15 course selection (unlimited for admin)
                'target_type' => 'group',
                'delivery_mode' => 'one_to_many',
                'schedule_type' => 'flexible',
                'is_popular' => false,
                'course_indices' => [0, 1, 2, 3, 4], // Link to all courses
            ],
        ];

        foreach ($pricingPlans as $planData) {
            $courseIndices = $planData['course_indices'];
            unset($planData['course_indices']);

            $plan = PricingPlan::firstOrCreate(
                ['name' => $planData['name']],
                $planData
            );

            // Attach courses to the plan
            foreach ($courseIndices as $index) {
                if (isset($createdCourses[$index])) {
                    $plan->courses()->syncWithoutDetaching([$createdCourses[$index]->id]);
                }
            }
        }

        $this->command->info('Package subscription system seeded successfully!');
        $this->command->info('Created ' . count($createdCourses) . ' courses');
        $this->command->info('Created pricing plans with course associations');
    }
}
