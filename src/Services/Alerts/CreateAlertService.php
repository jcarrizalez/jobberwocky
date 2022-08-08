<?php

namespace Avature\Services\Alerts;

use Illuminate\Database\Eloquent\Collection;
use App\Payloads\CreateAlertPayload;
use Avature\Utils\Cache;
use Avature\Utils\DB;
use Avature\Models\User;
use Avature\Models\Skill;
use Avature\Services\Skills\FinderSkillService;
use Exception;

class CreateAlertService
{
    protected DB $db;
    protected User $user;
    protected Cache $cache;
    protected FinderSkillService $finderSkillService;

    public function __construct(
        DB $db,
        User $user,
        Cache $cache,
        FinderSkillService $finderSkillService
    ) {
        $this->db = $db;
        $this->user = $user;
        $this->cache = $cache;
        $this->finderSkillService = $finderSkillService;
    }

    public function make(CreateAlertPayload $payload): ?Collection
    {
        $response = null;

        $this->db->transaction(function () use ($payload, &$response) {
            try {
                $skills = $this->finderSkillService->getBySlugs($payload->getSkills());

                $user = $this->user->with('skills')->find($payload->getUserId());

                $userSkills = array_column($user->skills->toArray(), 'slug');

                $newSkills = array_column($skills->toArray(), 'slug');

                $detach = new Collection(array_diff($userSkills, $newSkills));

                $attach = new Collection(array_diff($newSkills, $userSkills));

                $user->skills()->detach($detach->map(function (string $slug) use ($user) {
                    return $user->skills->firstWhere('slug', $slug)->id;
                }));

                $user->skills()->attach($attach->map(function (string $slug) use ($user, $skills) {
                    return [
                        'user_id' => $user->id,
                        'skill_id' => $skills->firstWhere('slug', $slug)->id,
                    ];
                }));

                $user->save();

                $response = $skills;
            } catch (Exception $e) {
            }
        });

        return $response;
    }
}
