<?php

namespace Avature\Services\Alerts;

use Avature\Utils\Paginator;
use Avature\Utils\EloquentPaginator;
use Avature\Utils\Cache;
use Avature\Models\Skill;

class FinderAlertService
{
    protected Skill $skill;
    protected Cache $cache;
    protected EloquentPaginator $paginator;

    public function __construct(Skill $skill, Cache $cache, EloquentPaginator $paginator)
    {
        $this->skill = $skill;
        $this->cache = $cache;
        $this->paginator = $paginator;
    }

    public function search(?string $search = null, Paginator $paginator): object
    {
        $cache = self::class.$search.$paginator->toString();

        if (null !== $response = $this->cache->get($cache)) {

            /**
        	 * Hasta tener el metodo de limpiar cache por patron key
        	 */
            //return $response;
        }

        $response = $this->paginator->paginate(
            $this->skill->search($search, $user = null),
            $paginator
        );

        $this->cache->put($cache, $response);

        return $response;
    }
}
