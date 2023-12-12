<?php

namespace App\Http\Requests\Division;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DivisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', "unique:division,name,$this->id,name", 'string', 'max:50'],
            'division_lead' => ['sometimes', 'exists:user,username', 'nullable'],
            'vision'        => ['sometimes', 'required', 'string'],
            'mission'       => ['sometimes', 'required', 'string'],
        ];
    }

    /**
     * Additional validation
     *
     * @return array
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->has('division_lead') || $this->division_lead === null)
                    return;
                if (User::query()->firstWhere('username', $this->division_lead)->role !== 'member') {
                    $validator->errors()->add('division_lead', 'Only members can be the division lead');
                }
            }
        ];
    }
}
