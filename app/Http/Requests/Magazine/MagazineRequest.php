<?php

namespace App\Http\Requests\Magazine;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class MagazineRequest extends FormRequest
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
            'thumbnail'        => ['sometimes', 'required', 'image'],
            'title'            => ['required', 'max:100', 'string'],
            'body'             => ['required', 'string'],
            'footer'           => ['nullable', 'string'],
            'post_schedule'    => ['sometimes', 'required', 'date', 'date_format:Y-m-d H:i'],
        ];
    }
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $time = Carbon::parse($this->post_schedule);
                $time->shiftTimezone('UTC'); // The timezone is set to Asia/Jakarta, set back to how it was requested

                if ($time->isPast()) {
                    $validator->errors()->add('post_scheudle', 'Post scheudle must set to now or upcoming date');
                }
            }
        ];
    }
}
