<?php

namespace Mymo\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'data.subject' => 'required',
            'via' => 'required|array',
        ];
    }
}
