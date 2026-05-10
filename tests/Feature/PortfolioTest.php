<?php

use App\Models\Work;

test('portfolio index page loads successfully', function () {
    // Generate some mock works
    Work::factory(3)->create();

    // Act
    $response = $this->get('/portfolio');

    // Assert
    $response->assertStatus(200);
});

test('contact page loads successfully', function () {
    $response = $this->get('/contact');
    $response->assertStatus(200);
});

test('contact form validates input correctly', function () {
    $response = $this->post('/contact', [
        'name' => '', // Invalid
        'email' => 'invalid-email', // Invalid
        'message' => 'short', // Invalid
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'message']);
});
