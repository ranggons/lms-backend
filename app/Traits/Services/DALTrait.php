<?php

namespace App\Traits\Services;

use Illuminate\Database\Eloquent\Builder;

trait DALTrait
{
    public function query(Builder $data, ?int $size, ?int $page, ?string $search, ?string $searchBy, ?string $orderColumn, ?string $orderBy): array
    {
        if ($search) {
            $data->where($searchBy, 'like', "%{$search}%");
        }

        $count = $data->count();

        if ($orderColumn) {
            $data = $data->orderBy($orderColumn, $orderBy ?? "asc");
        }

        if ($size && $page) {
            $data = $data->skip(($page - 1) * $size)->limit($size);
        }

        $data = $data->get();

        return [$data, $count];
    }
}
