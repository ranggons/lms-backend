<?php

namespace App\Traits\API;

trait ApiResponseTrait
{


    public function successResponse(array $data, array $optionalResponses = null)
    {
        $response = [
            'status'    =>  'success',
            'code'      =>  '200',
            'data'      =>  $data
        ];
        if ($optionalResponses) {
            foreach ($optionalResponses as $key => $value) {
                $response['key'] = $value;
            }
        }
        return response($response);
    }

    public function errorResponse(string $message, int $errorCode = 400, array $optionalResponses = null)
    {
        $response = [
            'status'    =>  $this->errorStatus($errorCode),
            'code'      =>  $errorCode,
            'message'   =>  $message
        ];
        if ($optionalResponses) {
            foreach ($optionalResponses as $optionalResponse) {
                foreach ($optionalResponses as $key => $value) {
                    $response['key'] = $value;
                }
            }
        }
        return response($response);
    }

    public function errorStatus(int $errorCode)
    {
        switch ($errorCode) {
            case 401:
                return 'unauthorized';
            case 401:
                return 'forbidden';
            case 404:
                return 'not found';
            case 500:
                return 'error';
            default:
                return 'error';
        }
    }
}