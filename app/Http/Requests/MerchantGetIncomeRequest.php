<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantGetIncomeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'timeRange' => 'required|array',
            'timeRange.start' => 'required|date_format:Y-m-d H:i',
            'timeRange.end' => 'required|date_format:Y-m-d H:i'
        ];
    }
}
