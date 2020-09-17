<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Models\Budget;
use App\Http\Controllers\Controller;
use App\Utils\Listing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function index(Request $request, Activity $activity)
    {
        $result = Listing::fromQuery(
            $activity->budgets()->getQuery()
        )->get($request);

        return response()->json($result);
    }


    public function indexYear(Request $request, int $year)
    {

        // TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Activity $activity
     * @return JsonResponse
     */
    public function store(Request $request, Activity $activity)
    {
        $sanitized = $request->validate([
            'item' => 'required|string',
            'type' => 'required|in:expense,income',
            'expense' => 'required|number',
            'actual' => 'sometimes|number'
        ]);

        $budget = new Budget($sanitized);
        $activity->budgets()->save($budget);

        return response()->json([
            'budget' => $budget
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Budget $budget
     * @return JsonResponse
     */
    public function show(Budget $budget)
    {
        return response()->json([
            'budget' => $budget
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Budget $budget
     * @return JsonResponse
     */
    public function update(Request $request, Budget $budget)
    {
        $sanitized = $request->validate([
            'item' => 'required|string',
            'type' => 'required|in:expense,income',
            'expense' => 'required|number',
            'actual' => 'sometimes|number'
        ]);

        $budget->update($sanitized);

        return response()->json([
            'budget' => $budget
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Budget $budget
     * @return Response
     * @throws \Exception
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();
        return response(null, 204);
    }
}
