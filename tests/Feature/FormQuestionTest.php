<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormQuestionTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;

    /**
     * @var Model
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(AdminUser::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_form_questions()
    {
        $form = factory(Form::class)->create();

        $response = $this->actingAs($this->user, 'admin_api')->getJson('/admin/api/forms/' . $form->id . '/questions');

        $response->assertStatus(200);
    }

    public function test_add_form_question()
    {
        $form = factory(Form::class)->create();

        $response = $this->actingAs($this->user, 'admin_api')
            ->postJson('/admin/api/forms/' . $form->id . '/questions', [
                'sequence' => 1,
                'type' => 'text',
                'question' => 'Howdy?',
                'is_required' => true,
                'max_character' => 255
            ]);

        print_r($response->content());

        $response->assertStatus(201)
            ->assertJson([
                'question' => [
                    'sequence' => 1,
                    'type' => 'text',
                    'question' => 'Howdy?',
                    'is_required' => true,
                    'max_character' => 255
                ]
            ]);
    }

    public function test_add_form_question_with_options()
    {
        $form = factory(Form::class)->create();

        $response = $this->actingAs($this->user, 'admin_api')
            ->postJson('/admin/api/forms/' . $form->id . '/questions', [
                'sequence' => 2,
                'type' => 'checkbox',
                'question' => 'Howdy?',
                'is_required' => true,
                'options' => ['fantastic', 'great', 'fine', 'ok']
            ]);

        print_r($response->content());

        $response->assertStatus(201)
            ->assertJson([
                'question' => [
                    'sequence' => 2,
                    'type' => 'checkbox',
                    'question' => 'Howdy?',
                    'is_required' => true,
                    'options' => [
                        ['value' => 'fantastic'],
                        ['value' => 'great'],
                        ['value' => 'fine'],
                        ['value' => 'ok']
                    ]
                ]
            ]);
    }
}
