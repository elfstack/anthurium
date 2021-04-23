<?php

namespace App\Http\Controllers\User;

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
}
