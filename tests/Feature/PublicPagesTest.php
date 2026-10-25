<?php

namespace Tests\Feature;

use App\Models\CompanySetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CompanySetting::current();
    }

    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Driving Growth Through Modern Technology');
    }

    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('About');
        $response->assertSee('Our Mission');
    }

    public function test_services_page_renders_successfully(): void
    {
        $response = $this->get(route('services'));

        $response->assertStatus(200);
        $response->assertSee('Custom Software Engineering');
    }

    public function test_contact_page_renders_successfully(): void
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertSee('Send Us a Message');
    }

    public function test_contact_form_submission_stores_message_and_redirects(): void
    {
        $response = $this->post(route('contact.send'), [
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '+1 555 9876',
            'subject' => 'Project Consultation',
            'message' => 'We need an enterprise Laravel web application with API integration.',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'subject' => 'Project Consultation',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post(route('contact.send'), []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }
}
