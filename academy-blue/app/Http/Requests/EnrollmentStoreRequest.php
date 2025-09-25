<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:users.id,id'],
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'enrollment_date' => ['required'],
            'status' => ['required', 'in:activo,completado,cancelado'],
        ];
    }
}
