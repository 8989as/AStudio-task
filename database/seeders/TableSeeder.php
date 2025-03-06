<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TableSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Seeding database with test data...');

        DB::transaction(function () {
            $user1 = User::create([
                'first_name' => 'user',
                'last_name' => 'One',
                'email' => 'user1@mail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
            ]);

            $user2 = User::create([
                'first_name' => 'user',
                'last_name' => 'Two',
                'email' => 'user2@mail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456789'),
            ]);

            
            $project1 = Project::create([
                'name' => 'AStudio Project',
                'description' => 'AStudio Project',
                'department' => 'IT',
                'status' => 'in_progress',
                'start_date' => Carbon::now()->subMonth(),
                'end_date' => Carbon::now()->addMonth()
            ]);

            $project2 = Project::create([
                'name' => 'Beta Development',
                'description' => 'Beta Development',
                'department' => 'IT',
                'status' => 'pending',
                'start_date' => Carbon::now()->subMonth(),
                'end_date' => Carbon::now()->addMonth()
            ]);

            $user1->projects()->attach($project1->id);
            $user1->projects()->attach($project2->id);
            $user2->projects()->attach($project1->id);

            Timesheet::create([
                'user_id' => $user1->id,
                'project_id' => $project1->id,
                'task_name' => 'UI Design',
                'date' => Carbon::now()->subDays(3),
                'hours' => 5,
            ]);

            Timesheet::create([
                'user_id' => $user1->id,
                'project_id' => $project2->id,
                'task_name' => 'Database Optimization',
                'date' => Carbon::now()->subDays(5),
                'hours' => 3,
            ]);

            Timesheet::create([
                'user_id' => $user2->id,
                'project_id' => $project1->id,
                'task_name' => 'Frontend Development',
                'date' => Carbon::now()->subDay(),
                'hours' => 8,
            ]);

            
            $departmentAttr = Attribute::create(['name' => 'department', 'type' => 'text']);
            $startDateAttr = Attribute::create(['name' => 'Start Date', 'type' => 'date']);
            $endDateAttr = Attribute::create(['name' => 'End Date', 'type' => 'date']);
            $budgetAttr = Attribute::create(['name' => 'Budget', 'type' => 'number']);

            
            AttributeValue::create([
                'attribute_id' => $departmentAttr->id,
                'entity_id' => $project1->id,
                'value' => 'IT Department',
            ]);

            AttributeValue::create([
                'attribute_id' => $departmentAttr->id,
                'entity_id' => $project2->id,
                'value' => 'Marketing',
            ]);

            AttributeValue::create([
                'attribute_id' => $startDateAttr->id,
                'entity_id' => $project1->id,
                'value' => Carbon::now()->subMonth()->toDateString(),
            ]);

            AttributeValue::create([
                'attribute_id' => $endDateAttr->id,
                'entity_id' => $project1->id,
                'value' => Carbon::now()->addMonth()->toDateString(),
            ]);

            AttributeValue::create([
                'attribute_id' => $budgetAttr->id,
                'entity_id' => $project2->id,
                'value' => '50000',
            ]);

            $this->command->info('Database seeding completed successfully!');
        });
    }
}
