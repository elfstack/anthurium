<?php

use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\FormQuestion;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Form::class, 5)->create()->each(function (Form $form) {
            $question = $form->questions()->create([
                'question' => 'test',
                'type' => 'text',
                'max_character' => 255,
                'is_required' => true,
                'sequence' => 1
            ]);

            $answers = $form->answers()->create([
                'answerer_id' => 1,
                'answerer_type' => 'user'
            ]);

            $answers->answers()->create([
                'form_question_id' => $question->id,
                'answer' => 'test'
            ]);
        });
    }
}
