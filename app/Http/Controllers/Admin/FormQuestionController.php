<?php

namespace App\Http\Controllers\Admin;

use App\Models\Form;
use App\Models\FormOptions;
use App\Models\FormQuestion;
use App\Http\Controllers\Controller;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormQuestionController extends Controller
{
    // TODO: implement revision control mechanism
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
     * @param Form $form
     * @return JsonResponse
     */
    public function store(Request $request, Form $form)
    {
        $sanitized = $request->validate([
            'sequence' => 'required|integer',
            'type' => 'required|in:text,textarea,checkbox,radio',
            'question' => 'required|string',
            'is_required' => 'sometimes|boolean',
            // TODO: only when type is text
            'max_character' => 'sometimes|integer',
            'options' => 'sometimes|array',
            'options.*.value' => 'string'
        ]);

        $question = $form->questions()->create($sanitized);

        // TODO: check when edit, if form has answer, alert
        // TODO: allow notify changes to user when the form has changed

        if ($sanitized['type'] !== 'text' && $sanitized['type'] !== 'textarea') {

            $options = collect($sanitized['options'])->map(function ($option) {
                return FormOptions::make($option['value']);
            });

            $question->options()->saveMany($options);
            $question->load(['options']);
        }

        return response()->json([
            'question' => $question
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

        // TODO: check if form already have answers of this question
        // if forced, continue
        // otherwise:
        //  if form has answer, and the question has changed, alert
        //  or
        //                      the option has changed, error
        //  otherwise:
        //  if form doesn't have answer, continue

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

        // TODO: check before delete
        // if forced, continue
        // otherwise:
        // if form has answer, alert
        // otherwise:
        // continue
        return response()->json([
            'message' => 'deleted'
        ], 204);
    }
}
