<?php

namespace App\Http\Requests\Admin\VolunteerInfo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreVolunteerInfo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.volunteer-info.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_number' => ['required', 'string'],
            'alias' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'birthday' => ['required', 'date'],
            'education' => ['nullable', 'string'],
            'organisation' => ['nullable', 'string'],
            'mobile_number' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'interests' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string'],
            'volunteer_experences' => ['nullable', 'string'],
            'references' => ['nullable', 'string'],
            
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
