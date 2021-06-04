<?php

namespace Mymo\Core\Traits;

trait ResponseMessage
{
    protected function response($data, $status)
    {
        if (!is_array($data)) {
            $data = [$data];
        }
    
        if (request()->has('redirect')) {
            $data['redirect'] = request()->input('redirect');
        }
        
        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }
    
    protected function success($message)
    {
        if (is_string($message)) {
            $message = ['message' => $message];
        }

        return $this->response($message, true);
    }
    
    protected function error($message)
    {
        if (is_string($message)) {
            $message = ['message' => $message];
        }

        return $this->response($message, false);
    }
}
