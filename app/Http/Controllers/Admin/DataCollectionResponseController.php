<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\DataCollection;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Models\User;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataCollectionResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param DataCollection $dataCollection
     * @return JsonResponse
     */
    public function index(Request $request, DataCollection $dataCollection)
    {
        $query = $dataCollection->responses()->with('answerer')->getQuery();
        $result = Listing::fromQuery($query)->get($request);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataCollection $dataCollection
     * @param Request $request
     * @return JsonResponse
     */
    public function store(DataCollection $dataCollection, Request $request)
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

        $answersWrapper = $dataCollection->responses()->create([
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
     * @param DataCollection $dataCollection
     * @param FormAnswer $answer
     * @return JsonResponse
     */
    public function show(DataCollection $dataCollection, FormAnswer $answer)
    {
        $answer->load(['answers.question']);

        return response()->json([
            'answer' => $answer
        ]);
    }

    /**
     * Get answer by user id
     *
     * @param DataCollection $dataCollection
     * @param User $user
     * @return JsonResponse
     */
    public function getResponseByUserId(DataCollection $dataCollection, User $user)
    {
        $response = $dataCollection->getResponseByUser($user);

        if ($response == null) {
            abort(404, 'The form has not been filled by user');
        }

        return response()->json([
            'response' => $response
        ]);
    }

    /**
     * Get registration form answer by user id
     *
     * FIXME: this needs to be reimplemented
     *
     * @param User $user
     * @return JsonResponse
     */

    public function getMemberFormResponseByUserId(User $user)
    {
        $dataCollection = null;

        try {
            $dataCollection = DataCollection::memberApplicationForm();
        } catch (\Exception $e) {
            abort(405, 'member application form disabled');
        }

        $response = $dataCollection->getResponseByUser($user);

        return response()->json([
            'response' => $response
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
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
