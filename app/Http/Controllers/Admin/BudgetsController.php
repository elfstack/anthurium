<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Budget\BulkDestroyBudget;
use App\Http\Requests\Admin\Budget\DestroyBudget;
use App\Http\Requests\Admin\Budget\IndexBudget;
use App\Http\Requests\Admin\Budget\StoreBudget;
use App\Http\Requests\Admin\Budget\UpdateBudget;
use App\Models\Activity;
use App\Models\Budget;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BudgetsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBudget $request
     * @return array|Factory|View
     */
    public function index(IndexBudget $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Budget::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'activity_id', 'budget_category_id', 'budget', 'expense', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.budget.index', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBudget $request
     * @param Activity $activity
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBudget $request, Activity $activity)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Budget
        $budget = $activity->budgets()->create($sanitized);

        if ($request->ajax()) {
            return ['message' => trans('brackets/admin-ui::admin.operation.succeeded'), 'data' => $budget];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Budget $budget
     * @throws AuthorizationException
     * @return void
     */
    public function show(Budget $budget)
    {
        $this->authorize('admin.budget.show', $budget);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Budget $budget
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Budget $budget)
    {
        $this->authorize('admin.budget.edit', $budget);


        return view('admin.budget.edit', [
            'budget' => $budget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBudget $request
     * @param Budget $budget
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBudget $request, Budget $budget)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Budget
        $budget->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/budgets'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/budgets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBudget $request
     * @param Budget $budget
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBudget $request, Budget $budget)
    {
        $budget->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBudget $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBudget $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Budget::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
