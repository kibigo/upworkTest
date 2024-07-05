<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_submission_successful()
    {

        $response = $this->postJson('/api/submit', [
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'message' => 'Welcome to Microsoft'
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Submission Saved',
                    'name' => 'John Doe',
                    'email' => 'john@gmail.com'
                ]);

        $this->assertDatabaseHas('submissions', [
            'message' => 'Welcome to Microsoft',
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
        ]);
        
    }

    public function test_submission_fails()
    {
        $response = $this->postJson('/api/submit', [
            'name' => 'John',
            'email' => 'invalid-email',
            'message' => ''
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'email', 'message']);
    }
    
}
