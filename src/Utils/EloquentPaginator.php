<?php

declare(strict_types=1);

namespace Avature\Utils;

use Illuminate\Database\Eloquent\Builder;

final class EloquentPaginator
{
    public static function paginate(Builder $query, Paginator $paginator): object
    {
        $count = $paginator->getCount();

        $page = $paginator->getPage();

        $paginate =  $query->paginate((int) $count, ['*'], 'page', $page);

        return (object) [
            'elements' => $query->get(),
            'metadata' =>[
                'count' => $count,
                'page' => $paginate->currentPage(),
                'total' => $paginate->total(),
                'total_pages' => $paginate->lastPage(),
            ]
        ];
    }
}
