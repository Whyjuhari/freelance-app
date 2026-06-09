<?php

use App\Models\Clients;
use App\Models\Finances;
use App\Models\Projects;
use App\Models\User;

function createProjectFor(User $user, string $name = 'Website Project'): Projects
{
    $client = Clients::create([
        'user_id' => $user->id,
        'company_name' => $name . ' Client',
        'name' => 'Contact ' . $name,
        'phone' => '081234567890',
        'status' => 'active',
    ]);

    return Projects::create([
        'user_id' => $user->id,
        'client_id' => $client->id,
        'name' => $name,
        'status' => 'active',
        'progress' => 25,
        'budget' => 2500000,
    ]);
}

test('users can create finance records for their own projects', function () {
    $user = User::factory()->create();
    $project = createProjectFor($user);

    $this->actingAs($user)
        ->post(route('keuangan.store'), [
            'project_id' => $project->id,
            'type' => 'income',
            'amount' => 1500000,
            'note' => 'Termin pertama',
            'date' => now()->format('Y-m-d'),
        ])
        ->assertRedirect(route('keuangan.index'));

    $this->assertDatabaseHas('finances', [
        'user_id' => $user->id,
        'project_id' => $project->id,
        'type' => 'income',
        'amount' => 1500000,
        'note' => 'Termin pertama',
    ]);
});

test('users cannot update another users finance records', function () {
    $owner = User::factory()->create();
    $intruder = User::factory()->create();
    $project = createProjectFor($owner);

    $finance = Finances::create([
        'user_id' => $owner->id,
        'project_id' => $project->id,
        'type' => 'income',
        'amount' => 1000000,
        'note' => 'Protected',
    ]);

    $this->actingAs($intruder)
        ->put(route('keuangan.update', $finance), [
            'type' => 'expense',
            'amount' => 100,
            'note' => 'Intruder',
        ])
        ->assertForbidden();

    expect($finance->fresh()->amount)->toBe(1000000);
});

test('dashboard uses finance income from database', function () {
    $user = User::factory()->create();
    $project = createProjectFor($user);

    Finances::create([
        'user_id' => $user->id,
        'project_id' => $project->id,
        'type' => 'income',
        'amount' => 1250000,
        'created_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Rp 1.250.000');
});

test('report pages and csv export are available', function () {
    $user = User::factory()->create();
    $project = createProjectFor($user);

    Finances::create([
        'user_id' => $user->id,
        'project_id' => $project->id,
        'type' => 'income',
        'amount' => 2000000,
        'created_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('laporan.index'))
        ->assertOk()
        ->assertSee('Rp 2.000.000');

    $this->actingAs($user)
        ->get(route('laporan.print'))
        ->assertOk()
        ->assertSee('FreelanceApp Report');

    $this->actingAs($user)
        ->get(route('laporan.export.csv'))
        ->assertOk()
        ->assertHeader('content-type', 'text/csv; charset=UTF-8');
});
