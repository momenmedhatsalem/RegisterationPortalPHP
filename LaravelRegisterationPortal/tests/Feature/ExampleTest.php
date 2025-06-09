<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Services\WhatsAppService;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the homepage returns a successful response.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that a new user is inserted and redirected with success message.
     */
   public function test_it_inserts_a_new_user_and_redirects_with_success_message(): void
{
    // Create a mock of WhatsAppService
    $mockWhatsAppService = \Mockery::mock(\App\Services\WhatsAppService::class);
    $mockWhatsAppService->shouldReceive('validateWhatsAppNumber')->once()->andReturn(true);

    // Bind the mock into the service container
    $this->app->instance(\App\Services\WhatsAppService::class, $mockWhatsAppService);

    $response = $this->post('/submit', [
        'name' => 'Habiba Alaa',
        'username' => 'habiba123',
        'email' => 'habiba@example.com',
        'phone_number' => '+201234567890',           
        'whatsapp_phone_number' => '+201234567890',  
        'address' => '123 Street, City',
        'password' => 'Passw0rd!',
        'confirm_password' => 'Passw0rd!',
        'user_image' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
    ]);

    $response->assertRedirect('/');
    $response->assertSessionHas('success', 'You are successfully registered!');
}
}
