<?php

namespace App\Http\Controllers\User;

use App\Events\User\MembershipApplied;
use App\Models\DataCollection;
use App\Models\Form;
use App\Models\FormOptions;
use App\Models\FormQuestion;
use App\Http\Controllers\Controller;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Form $form
     * @return JsonResponse
     */
    public function index(Form $form)
    {
        $result = $form->questions()->with(['options'])->orderBy('sequence')->get();
        return response()->json([
            'questions' => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param DataCollection $dataCollection
     * @return JsonResponse
     */
    public function store(Request $request, DataCollection $dataCollection)
    {
        $user = $request->user();

        // TODO: bypass this condition for dataCollection that allows resubmit
        if ($dataCollection->isFilledByUser($user)) {
            abort(409, 'This form does not allow re-submit');
        }

        $sanitized = $request->validate([
            'response' => 'required|array',
            'response.*.answer' => 'required|string',
            'response.*.form_question_id' => 'required|integer'
        ]);

        $response = $dataCollection->response()->create([
            'user_id' => $request->user()->id
        ]);

        $sanitized = collect($sanitized['response'])->map(function ($item) use ($request) {
            return [
                'answer' => $item['answer'],
                'form_question_id' => $item['form_question_id']
            ];
        });

        $responseRecord = $response->answers()->createMany($sanitized);

        if ($dataCollection->purpose === 'member-application') {
            MembershipApplied::dispatch($response);
        }

        return response()->json([
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FormQuestion $question
     * @return JsonResponse
     */
    public function update(Request $request, Form $form, FormQuestion $question)
    {
        $sanitized = $request->validate([
            'sequence' => 'required|integer',
            'type' => 'required|in:text,textarea,checkbox,radio',
            'question' => 'required|string',
            'is_required' => 'required|boolean',
            'max_character' => 'sometimes|integer',
            'options' => 'sometimes|array',
            '*.options.value' => 'string'
        ]);

        $question->update($sanitized);

        if ($sanitized['type'] !== 'text' && $sanitized['type'] !== 'textarea') {

            $options = collect($sanitized['options'])->map(function ($option) {
                return new FormOptions($option);
            });

            $question->options()->delete();
            $question->options()->saveMany($options);
            $question->load(['options']);
        }

        return response()->json([
            'question' => $question
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Form $form
     * @param FormQuestion $question
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Form $form, FormQuestion $question)
    {
        $question->delete();
        return response()->json([
            'message' => 'deleted'
        ], 204);
    }
}
