<?php

namespace App\Http\Requests\Admin\Budget;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateBudget extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.budget.edit', $this->budget);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'activity_id' => ['sometimes', 'string'],
            'budget_category_id' => ['nullable', 'string'],
            'budget' => ['sometimes', 'numeric'],
            'expense' => ['sometimes', 'numeric'],
            'name' => ['sometimes', 'string'],
            
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
