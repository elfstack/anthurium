<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DataCollection;
use App\Models\DataCollectionResponse;
use App\Models\Form;
use App\Utils\Listing;
use Illuminate\Auth\Access\AuthorizationException;
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
                    ->attachFiltering([
                        'purpose',
                        'activity_id'
                    ])
                    ->attachSorting([
                        'updated_at'
                    ])
                    ->modifyQuery(function ($query) {
                        $query->with('form');
                        // TODO: determine whether the user filled this form
                    })
                    ->get($request);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param DataCollection $dataCollection
     * @return JsonResponse
     */
    public function show(DataCollection $dataCollection)
    {
        $dataCollection->load(['form.questions.options', 'activity']);

        return response()->json([
            'data_collection' => $dataCollection
        ]);
    }

    /**
     * Show response
     *
     * @param Request $request
     * @param DataCollectionResponse $dataCollectionResponse
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function showResponse(Request $request, DataCollectionResponse $dataCollectionResponse)
    {
        $this->authorizeForUser($request->user('api'), 'view', $dataCollectionResponse);

        $dataCollectionResponse->load(['response', 'dataCollection.form']);

        // put response into form details to unify data format
        $dataCollectionResponse->dataCollection->form->questions = $dataCollectionResponse->response;
        unset($dataCollectionResponse->response);

        return response()->json([
            'data_collection_response' => $dataCollectionResponse
        ]);
    }
}
