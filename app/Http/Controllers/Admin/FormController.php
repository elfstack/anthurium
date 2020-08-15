<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $result = Listing::create(Form::class)
                    ->attachSorting(['id'])
                    ->get($request);

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
       $sanitized = $request->validate([
           'title' => 'required|string',
           'description' => 'sometimes|string'
       ]);

       return response()->json([
           'form' => Form::create($sanitized)
       ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Form $form
     * @return JsonResponse
     */
    public function show(Form $form)
    {
        return response()->json([
            'form' => $form
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Form $form
     * @return JsonResponse
     */
    public function update(Request $request, Form $form)
    {
        // TODO: not implemented
        $sanitized = [
            'title' => 'required|string',
            'description' => 'sometimes|string'
        ];

        $form->update($sanitized);

        return response()->json([
            'form' => $form
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Form $form
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Form $form)
    {
        // TODO: delete all related information, override methods in model
        $form->delete();
        return response()->json([
            'message' => 'success'
        ], 204);
    }
}
