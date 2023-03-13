<?php

namespace App\Services\Rangon;

use App\Http\Resources\Api\Rangon\OrganizationResource;
use App\Models\Rangon\Organization;

class OrganizationService
{
    public function get(?int $size, ?int $page, ?string $search, ?string $orderColumn, ?string $orderBy): array
    {
        $data = Organization::query();

        if ($search) {
            $data->where('name', 'like', $search);
        }

        $count = $data->count();

        if ($orderColumn) {
            $data = $data->orderBy($orderColumn, $orderBy ?? "asc");
        }

        if ($size && $page) {
            $data = $data->skip(($page - 1) * $size)->limit($size);
        }

        $data = $data->get();

        return [OrganizationResource::collection($data), $count];
    }

    public function create($request): Organization
    {
        // TODO: create trait when model is creating for column created_by
        return Organization::create($request->validated() + [
            'created_by' => 1
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
