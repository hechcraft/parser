<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginatorHelpers
{

    public static function paginate($items, $perPage = 15, $options = []): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage() ?: 1;

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
