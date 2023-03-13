<?php

namespace App\Http\Controllers\Api\V1\Rangon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rangon\OrganizationRequest;
use App\Models\Rangon\Organization;
use App\Services\Rangon\OrganizationService;
use Illuminate\Http\Request;

class OrganizationControllerApi extends Controller
{
    public function index(Request $request, OrganizationService $organizationService)
    {
        [$data, $count] = $organizationService->get($request->size, $request->page, $request->search, $request->orderColumn, $request->orderBy);

        return $this->successResponse($data, ['count' => $count]);
    }

    public function store(OrganizationRequest $organizationRequest, OrganizationService $organizationService)
    {
        $data = $organizationService->create($organizationRequest);

        return $this->successResponse($data);
    }

    public function update(OrganizationRequest $organizationRequest, Organization $organization, OrganizationService $organizationService)
    {
        $organizationService->update($organizationRequest, $organization);

        return $this->successResponse($organization);
    }

    public function destroy(Organization $organization, OrganizationService $organizationService)
    {
        $organizationService->delete($organization);

        return $this->successResponse(null);
    }
}
