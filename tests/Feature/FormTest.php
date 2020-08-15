<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;

    /**
     * @var Model
     */
    private $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = factory(AdminUser::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_form()
    {
        $response = $this->actingAs($this->user, 'admin_api')->postJson('/admin/api/forms', [
            'title' => 'test form',
            'description' => 'this is the description'
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'form' => [
                         'title' => 'test form',
                         'description' => 'this is the description'
                     ]
                 ]);
    }
}
