<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\User;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FormAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Form $form
     * @return JsonResponse
     */
    public function index(Request $request, Form $form)
    {
        $query = $form->answers()->with('answerer')->getQuery();
        $result = Listing::fromQuery($query)->get($request);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Form $form
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function store(Form $form, Request $request)
    {
        // TODO: save answer to database
        /*
         * {
         *   "answers": [{
         *     "question_id": 1,
         *     "answer": "xx"
         *     ...
         *   }]
         * }
         */
        $sanitized = $request->validate([
            'answers' => 'array',
            'answers.question_id' => [
                'required',
                'integer',
                Rule::exists('form_questions', 'id')->where(function ($query) use (&$form) {
                    $query->where('form_id', $form->id);
                })
            ],
            'answers.answer' => [
                // TODO
            ]
        ]);

        $answers = collect($sanitized['answers'])->map(function ($answer) {
            return [
                'form_question_id' => $answer['question_id'],
                'answer' => $answer['answer']
            ];
        });

        // TODO: save answerer
        // FIXME: this is only the case of logged user filling the form

        $answersWrapper = $form->answers()->create([
            'answerer_id' => $request->user()->id,
            'answerer_type' => 'user'
        ]);

        $answersWrapper->answers()->create($answers);

        return response()->json([
            'message' => 'success'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Form $form
     * @param FormAnswer $answer
     * @return JsonResponse
     */
    public function show(Form $form, FormAnswer $answer)
    {
        $answer->load(['answers.question']);

        return response()->json([
            'answer' => $answer
        ]);
    }

    /**
     * Get answer by user id
     *
     * @param Form $form
     * @param User $user
     * @return JsonResponse
     */
    public function getAnswersByUserId(Form $form, User $user)
    {
        $answer = $form->answersAnsweredBy($user);

        if ($answer == null) {
            abort(404, 'No information available');
        }
        $answer->load(['answers.question']);

        return response()->json([
            'answer' => $answer
        ]);
    }

    /**
     * Get registration form answer by user id
     *
     * @param User $user
     * @return JsonResponse
     */

    public function getRegistrationFormAnswerByUserId(User $user)
    {
        $registrationFormId = Configuration::getConfig('registration.form_id');

        if (!$registrationFormId) {
            abort(405, "Registration form is disabled");
        }

        $answer = Form::find($registrationFormId)->answerAnsweredBy($user);
        $answer->load(['answers.question']);

        return response()->json([
            'answer' => $answer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormAnswer  $formAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormAnswer $formAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormAnswer  $formAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormAnswer $formAnswer)
    {
        //
    }
}
