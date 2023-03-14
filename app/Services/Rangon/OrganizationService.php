<?php

namespace App\Services\Rangon;

use App\Http\Resources\Api\Rangon\OrganizationResource;
use App\Models\Rangon\Organization;
use App\Traits\Services\DALTrait;

class OrganizationService
{
    use DALTrait;

    public function get(?int $size, ?int $page, ?string $search, ?string $orderColumn, ?string $orderBy): array
    {
        $data = Organization::query();

        [$data, $count] = $this->query(
            data: $data,
            size: $size,
            page: $page,
            search: $search,
            orderColumn: $orderColumn,
            orderBy: $orderBy,
            searchBy: "name"
        );

        return [OrganizationResource::collection($data), $count];
    }

    public function create($request): Organization
    {
        return Organization::create($request->validated() + [
            'created_by' => auth('sanctum')->id()
        ]);
    }

    public function update($request, Organization $organization): bool
    {
        return $organization->update($request->validated());
    }

    public function delete(Organization $organization): bool
    {
        return $organization->delete();
    }
}
