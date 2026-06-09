<?php

use App\Models\Clients;
use App\Models\Projects;
use App\Models\Task;
use App\Models\TimeLogs;
use App\Models\User;

test('guests are redirected away from time tracking', function () {
    $this->get('/time-tracking')
        ->assertRedirect('/login');
});

test('users cannot toggle another users task', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $client = Clients::create([
        'user_id' => $owner->id,
        'company_name' => 'Owner Client',
        'name' => 'Owner Contact',
        'phone' => '081234567890',
        'status' => 'active',
    ]);

    $project = Projects::create([
        'user_id' => $owner->id,
        'client_id' => $client->id,
        'name' => 'Owner Project',
        'status' => 'active',
        'progress' => 10,
    ]);

    $task = Task::create([
        'user_id' => $owner->id,
        'project_id' => $project->id,
        'title' => 'Protected Task',
        'status' => 'pending',
        'due_date' => now()->addDay(),
    ]);

    $this->actingAs($intruder)
        ->patchJson(route('tasks.toggle', $task))
        ->assertForbidden();

    expect($task->fresh()->status)->toBe('pending');
});

test('users cannot start timers on another users project', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $client = Clients::create([
        'user_id' => $owner->id,
        'company_name' => 'Owner Client',
        'name' => 'Owner Contact',
        'phone' => '081234567890',
        'status' => 'active',
    ]);

    $project = Projects::create([
        'user_id' => $owner->id,
        'client_id' => $client->id,
        'name' => 'Owner Project',
        'status' => 'active',
        'progress' => 10,
    ]);

    $this->actingAs($intruder)
        ->postJson(route('time-tracking.start'), [
            'project_id' => $project->id,
        ])
        ->assertStatus(422);

    $this->assertDatabaseCount('time_logs', 0);
});

test('users cannot stop another users timer', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $client = Clients::create([
        'user_id' => $owner->id,
        'company_name' => 'Owner Client',
        'name' => 'Owner Contact',
        'phone' => '081234567890',
        'status' => 'active',
    ]);

    $project = Projects::create([
        'user_id' => $owner->id,
        'client_id' => $client->id,
        'name' => 'Owner Project',
        'status' => 'active',
        'progress' => 10,
    ]);

    $timeLog = TimeLogs::create([
        'user_id' => $owner->id,
        'project_id' => $project->id,
        'start_time' => now()->subHour(),
    ]);

    $this->actingAs($intruder)
        ->postJson(route('time-tracking.stop', $timeLog))
        ->assertForbidden();

    expect($timeLog->fresh()->end_time)->toBeNull();
});
