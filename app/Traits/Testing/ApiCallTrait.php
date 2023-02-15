<?php

namespace App\Traits\Testing;

use Laravel\Sanctum\Sanctum;

trait ApiCallTrait
{
    public bool $validateCall = true;
    public bool $isActingAs = true;

    public function prepareFetchRequest(string $method, string $endpoint, array $inputs = [], $actingAs = null, array $tokenAbilities = ['*'], array $headers = [], bool $isReturnTypeIsFile = false)
    {
        if ($this->isActingAs && $actingAs) {
            Sanctum::actingAs(
                $actingAs,
                $tokenAbilities
            );
        }

        if ($method == 'GET') {
            if (!empty($inputs)) {
                $inputs = (is_array($inputs)) ? $inputs : json_decode($inputs, 1);
                $endpoint .= "?" . http_build_query($inputs);
            }
            $inputs = [];
        }

        return $this->fetchRequest($method, url($endpoint), $inputs, $headers, $isReturnTypeIsFile);
    }

    public function fetchRequest(string $method, string $url, array $inputs = [], array $headers = [], bool $isReturnTypeIsFile = false)
    {
        if ($this->debugData) {
            $this->showDebugMessage('Request with method ' . $method . ' to endpoint ' . $url);
        }

        $data = null;

        if ($isReturnTypeIsFile && $method == 'GET') {
            $this->response = $this->get($this->url);
            $data = $this->response;
        } else {

            $this->response = $this->json($method, $url, $inputs, $headers);
            $data = data_get($this->response->decodeResponseJson()->json(), "data");
            print_r($data);

            if (is_null($data)) {
                $data = $this->response->decodeResponseJson()->json();
            }
        }

        if ($this->debugData) {
            $this->showDebugMessage('Fetched data : ', $data, true);
        }

        if ($this->validateCall) {
            $this->response->assertOk();
        }

        return $data;
    }

    public function getRequest(string $endpoint, array $inputs = [], $actingAs = null, array $tokenAbilities = ['*'], array $headers = [], bool $isReturnTypeIsFile = false)
    {
        return $this->prepareFetchRequest('GET', $endpoint, $inputs, $actingAs, $tokenAbilities, $headers, $isReturnTypeIsFile);
    }

    public function postRequest(string $endpoint, array $inputs = [], $actingAs = null, array $tokenAbilities = ['*'], array $headers = [])
    {
        return $this->prepareFetchRequest('POST', $endpoint, $inputs, $actingAs, $tokenAbilities, $headers);
    }

    public function putRequest(string $endpoint, array $inputs = [], $actingAs = null, array $tokenAbilities = ['*'], array $headers = [])
    {
        return $this->prepareFetchRequest('PUT', $endpoint, $inputs, $actingAs, $tokenAbilities, $headers);
    }

    public function patchRequest(string $endpoint, array $inputs = [], $actingAs = null, array $tokenAbilities = ['*'], array $headers = [])
    {
        return $this->prepareFetchRequest('PATCH', $endpoint, $inputs, $actingAs, $tokenAbilities, $headers);
    }
}
