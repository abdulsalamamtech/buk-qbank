<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneratedQuestionRequest extends FormRequest
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
            'question_type' => ['required', 'in:test,exam'],
            'year' => ['required', 'string'],
            'course_id' => ['required', 'exists:courses,id'],
            'level' => ['required', 'in:100,200,300,400'],
            'semester' => ['required', 'in:first,second'],

            'objective_instruction' => ['required', 'string'],
            'objective_total' => ['required', 'integer'],

            'theory_instruction' => ['required', 'string'],
            'theory_total' => ['required', 'integer'] 
        ];
    }
}
