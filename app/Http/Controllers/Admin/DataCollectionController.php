<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use App\Models\Form;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataCollectionController extends Controller
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
        $result = Listing::create(DataCollection::class)
                    ->attachSorting(['id'])
                    ->modifyQuery(function ($query) {
                        $query->with('form');
                    })
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
           'form_id' => 'required|integer|exists:'.Form::class.',id',
           'purpose' => 'string',
           'is_re_submittable' => 'boolean'
       ]);

       return response()->json([
           'data_collection' => DataCollection::create($sanitized)
       ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param DataCollection $dataCollection
     * @return JsonResponse
     */
    public function show(DataCollection $dataCollection)
    {
        $dataCollection->load(['form']);

        return response()->json([
            'data_collection' => $dataCollection
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
