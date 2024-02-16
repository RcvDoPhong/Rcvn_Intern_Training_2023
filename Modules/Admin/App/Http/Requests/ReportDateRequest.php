<?php

namespace Modules\Admin\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportDateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'reportTimeType' => [
                'required'
            ],
            'timeLineReport' => [
                'required'
            ],
            'timeLineReport.fromDate' => [
                'required_if:reportTimeType,date',
                'before:timeLineReport.toDate'
            ],
            'timeLineReport.toDate' => [
                'required_if:reportTimeType,date',
                'after:timeLineReport.fromDate'
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'timeLineReport.fromDate' => 'From date',
            'timeLineReport.toDate' => 'To date'
        ];
    }
}
