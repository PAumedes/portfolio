<?php

use App\Models\User;
use App\Models\Work;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('unauthenticated users cannot access admin works', function () {
    $response = $this->get('/admin/works');
    $response->assertRedirect('/login');
});

test('authenticated users can access admin works index', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/works');

    $response->assertStatus(200);
});

test('authenticated users can access admin works create', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/works/create');

    $response->assertStatus(200);
});

test('authenticated users can store a new work with image', function () {
    Storage::fake('local'); // or whatever disk is used

    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/admin/works', [
        'title' => 'My New Project',
        'description' => 'A beautiful project',
        'image' => UploadedFile::fake()->image('project.jpg'),
    ]);

    $this->assertDatabaseHas('works', [
        'title' => 'My New Project',
        'slug' => 'my-new-project',
    ]);

    $work = Work::first();
    $this->assertNotNull($work->getFirstMediaUrl('default'));

    $response->assertRedirect('/admin/works');
    $response->assertSessionHas('success');
});
