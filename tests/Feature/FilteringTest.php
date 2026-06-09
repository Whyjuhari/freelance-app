<?php

use App\Models\Clients;
use App\Models\Projects;
use App\Models\Task;
use App\Models\TimeLogs;
use App\Models\User;

test('projects can be searched by name', function () {
    $user = User::factory()->create();
    $client = Clients::create([
        'user_id' => $user->id,
        'company_name' => 'Acme',
        'name' => 'Acme Contact',
        'phone' => '081234567890',
        'status' => 'active',
    ]);

    Projects::create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'name' => 'Mobile App',
        'status' => 'active',
        'progress' => 10,
    ]);

    Projects::create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'name' => 'Brand Identity',
        'status' => 'planning',
        'progress' => 0,
    ]);

    $this->actingAs($user)
        ->get(route('projects.index', ['search' => 'Mobile']))
        ->assertOk()
        ->assertSee('Mobile App')
        ->assertDontSee('Brand Identity');
});

test('tasks can be filtered by status', function () {
    $user = User::factory()->create();
    $client = Clients::create([
        'user_id' => $user->id,
        'company_name' => 'Task Client',
        'name' => 'Task Contact',
        'phone' => '081234567890',
        'status' => 'active',
    ]);
    $project = Projects::create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'name' => 'Task Project',
        'status' => 'active',
        'progress' => 10,
    ]);

    Task::create([
        'user_id' => $user->id,
        'project_id' => $project->id,
        'title' => 'Done Task',
        'status' => 'done',
        'due_date' => now()->addDay(),
    ]);

    Task::create([
        'user_id' => $user->id,
        'project_id' => $project->id,
        'title' => 'Pending Task',
        'status' => 'pending',
        'due_date' => now()->addDay(),
    ]);

    $this->actingAs($user)
        ->get(route('tasks.index', ['status' => 'done']))
        ->assertOk()
        ->assertSee('Done Task')
        ->assertDontSee('Pending Task');
});

test('clients can be searched', function () {
    $user = User::factory()->create();

    Clients::create([
        'user_id' => $user->id,
        'company_name' => 'North Studio',
        'name' => 'Nora',
        'phone' => '081234567890',
        'status' => 'active',
    ]);

    Clients::create([
        'user_id' => $user->id,
        'company_name' => 'South Lab',
        'name' => 'Sora',
        'phone' => '081234567891',
        'status' => 'inactive',
    ]);

    $this->actingAs($user)
        ->get(route('client.index', ['search' => 'North']))
        ->assertOk()
        ->assertSee('North Studio')
        ->assertDontSee('South Lab');
});

test('time tracking keeps date filters in pagination context', function () {
    $user = User::factory()->create();
    $client = Clients::create([
        'user_id' => $user->id,
        'company_name' => 'Timer Client',
        'name' => 'Timer Contact',
        'phone' => '081234567890',
        'status' => 'active',
    ]);
    $project = Projects::create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'name' => 'Timer Project',
        'status' => 'active',
        'progress' => 10,
    ]);

    TimeLogs::create([
        'user_id' => $user->id,
        'project_id' => $project->id,
        'start_time' => now()->startOfWeek()->addHour(),
        'end_time' => now()->startOfWeek()->addHours(2),
        'duration' => 3600,
    ]);

    $this->actingAs($user)
        ->get(route('time-tracking.index', [
            'start_date' => now()->startOfWeek()->format('Y-m-d'),
            'end_date' => now()->endOfWeek()->format('Y-m-d'),
        ]))
        ->assertOk()
        ->assertSee('Timer Project');
});
