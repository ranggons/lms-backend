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
            $response = $this->addOptionalResponse($response, $optionalResponses);
        }
        return response($response);
    }

    public function errorResponse(string $message, int $errorCode = 400, array $optionalResponses = null, bool $isStrictCode = true)
    {
        $response = [
            'status'    =>  $this->errorStatus($errorCode),
            'code'      =>  $errorCode,
            'message'   =>  $message
        ];
        if ($optionalResponses) {
            $response = $this->addOptionalResponse($response, $optionalResponses);
        }
        return response($response, $isStrictCode ? $errorCode : 200);
    }

    public function addOptionalResponse(array $response, $optionalResponses)
    {
        foreach ($optionalResponses as $key => $value) {
            $response[$key] = $value;
        }
        return $response;
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
