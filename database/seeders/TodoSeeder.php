<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $categories = \App\Models\Category::all();

        $todos = [
            ['name' => 'Complete project proposal', 'desc' => 'Finish the Q4 project proposal document', 'priority' => 'high', 'category_id' => 1, 'due_date' => now()->addDays(3), 'tags' => json_encode(['urgent', 'project']), 'completed' => false],
            ['name' => 'Team meeting', 'desc' => 'Weekly sync with the development team', 'priority' => 'medium', 'category_id' => 1, 'due_date' => now()->addDays(1), 'tags' => json_encode(['meeting', 'weekly']), 'completed' => false],
            ['name' => 'Buy groceries', 'desc' => 'Milk, bread, eggs, vegetables', 'priority' => 'medium', 'category_id' => 3, 'due_date' => now()->addDays(2), 'tags' => json_encode(['shopping', 'food']), 'completed' => false],
            ['name' => 'Gym session', 'desc' => 'Cardio and weight training', 'priority' => 'low', 'category_id' => 4, 'due_date' => now()->addDays(1), 'tags' => json_encode(['fitness', 'health']), 'completed' => false],
            ['name' => 'Study Vue.js', 'desc' => 'Complete the advanced Vue.js course module 5', 'priority' => 'high', 'category_id' => 5, 'due_date' => now()->addDays(7), 'tags' => json_encode(['learning', 'programming']), 'completed' => false],
            ['name' => 'Doctor appointment', 'desc' => 'Annual checkup with Dr. Smith', 'priority' => 'high', 'category_id' => 4, 'due_date' => now()->addDays(5), 'tags' => json_encode(['health', 'appointment']), 'completed' => false],
            ['name' => 'Clean garage', 'desc' => 'Organize and clean the garage', 'priority' => 'low', 'category_id' => 6, 'due_date' => now()->addDays(10), 'tags' => json_encode(['cleaning', 'home']), 'completed' => false],
            ['name' => 'Pay electricity bill', 'desc' => 'Monthly electricity bill payment', 'priority' => 'high', 'category_id' => 8, 'due_date' => now()->addDays(2), 'tags' => json_encode(['bills', 'urgent']), 'completed' => false],
            ['name' => 'Call mom', 'desc' => 'Weekly call with mom', 'priority' => 'medium', 'category_id' => 7, 'due_date' => now()->addDays(1), 'tags' => json_encode(['family', 'call']), 'completed' => true],
            ['name' => 'Review code', 'desc' => 'Review pull requests for the new feature', 'priority' => 'medium', 'category_id' => 1, 'due_date' => now()->addDays(1), 'tags' => json_encode(['code', 'review']), 'completed' => true],
            ['name' => 'Birthday party planning', 'desc' => 'Plan birthday party for Sarah', 'priority' => 'medium', 'category_id' => 7, 'due_date' => now()->addDays(15), 'tags' => json_encode(['party', 'celebration']), 'completed' => false],
            ['name' => 'Fix kitchen sink', 'desc' => 'Leaking faucet needs repair', 'priority' => 'high', 'category_id' => 6, 'due_date' => now()->addDays(3), 'tags' => json_encode(['repair', 'urgent']), 'completed' => false],
        ];

        // Distribute todos among users
        foreach ($users as $userIndex => $user) {
            // Each user gets 4 todos
            $userTodos = array_slice($todos, $userIndex * 4, 4);

            foreach ($userTodos as $todoData) {
                $todoData['user_id'] = $user->id;
                \App\Models\Todo::create($todoData);
            }
        }
    }
}
