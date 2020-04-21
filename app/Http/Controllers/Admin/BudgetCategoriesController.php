<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BudgetCategory\BulkDestroyBudgetCategory;
use App\Http\Requests\Admin\BudgetCategory\DestroyBudgetCategory;
use App\Http\Requests\Admin\BudgetCategory\IndexBudgetCategory;
use App\Http\Requests\Admin\BudgetCategory\StoreBudgetCategory;
use App\Http\Requests\Admin\BudgetCategory\UpdateBudgetCategory;
use App\Models\BudgetCategory;
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

class BudgetCategoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBudgetCategory $request
     * @return array|Factory|View
     */
    public function index(IndexBudgetCategory $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(BudgetCategory::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

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

        return view('admin.budget-category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.budget-category.create');

        return view('admin.budget-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBudgetCategory $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBudgetCategory $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the BudgetCategory
        $budgetCategory = BudgetCategory::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/budget-categories'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/budget-categories');
    }

    /**
     * Display the specified resource.
     *
     * @param BudgetCategory $budgetCategory
     * @throws AuthorizationException
     * @return void
     */
    public function show(BudgetCategory $budgetCategory)
    {
        $this->authorize('admin.budget-category.show', $budgetCategory);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BudgetCategory $budgetCategory
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BudgetCategory $budgetCategory)
    {
        $this->authorize('admin.budget-category.edit', $budgetCategory);


        return view('admin.budget-category.edit', [
            'budgetCategory' => $budgetCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBudgetCategory $request
     * @param BudgetCategory $budgetCategory
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBudgetCategory $request, BudgetCategory $budgetCategory)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values BudgetCategory
        $budgetCategory->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/budget-categories'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/budget-categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBudgetCategory $request
     * @param BudgetCategory $budgetCategory
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBudgetCategory $request, BudgetCategory $budgetCategory)
    {
        $budgetCategory->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBudgetCategory $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBudgetCategory $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    BudgetCategory::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
