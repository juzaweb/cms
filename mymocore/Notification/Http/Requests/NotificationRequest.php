<?php

namespace Mymo\Notification\Http\Requests;

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
