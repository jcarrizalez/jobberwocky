<?php

namespace Avature\Services\Skills;

use Avature\Utils\Cache;
use Avature\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

class FinderSkillService
{
	protected Skill $skill;
	protected Cache $cache;

	public function __construct(Skill $skill, Cache $cache)
	{
		$this->skill = $skill;
		$this->cache = $cache;
	}

	public function getBySlugs($slug): Collection
	{
		$slugs = !is_array($slug) ? [$slug] : $slug;

		return $this->skill->whereIn('slug', $slugs)->get();
	}
}
