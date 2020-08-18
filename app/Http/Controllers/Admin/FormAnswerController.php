<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormAnswer;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
