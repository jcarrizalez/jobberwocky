<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Illuminate\Console\Command;
            
class AvatureDemoSeeder extends Seeder
{
    protected const TABLE_JOBS = 'jobs';
    protected const TABLE_USERS = 'users';
    protected const TABLE_COMPANIES = 'companies';
    protected const TABLE_USER_COMPANIES = 'user_companies';
    protected const TABLE_JOB_SKILL = 'job_skill';
    protected const PASSWORD = 123456;
    protected const USERS_RANDOM = 5;
    protected $faker;
    protected $command;

    public function __construct(Faker $faker, Command $command)
    {
        $this->faker = $faker;
        $this->command = $command;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(env('APP_ENV') !== 'local'){
            return $this->command->error('Only for Local Development: '. self::class);
        }

        if(DB::table(self::TABLE_USERS)->count()){

            return $this->command->error('There are records in DB of this Seeeder: '. self::class);
        }

        $companies = DB::table(self::TABLE_COMPANIES)->get()->map(fn($country) => (array) $country)->toArray();

        $users = $this->users();
        $userCompanies = $this->userCompanies($users, $companies);
        $jobs = $this->jobs();

        DB::transaction(function () use ($users, $userCompanies, $jobs) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            DB::table(self::TABLE_USERS)->insert($users['userStatic']);
            DB::table(self::TABLE_USERS)->insert($users['userRandom']);
            DB::table(self::TABLE_USER_COMPANIES)->insert($userCompanies);
            DB::table(self::TABLE_JOBS)->insert($jobs[self::TABLE_JOBS]);
            DB::table(self::TABLE_JOB_SKILL)->insert($jobs[self::TABLE_JOB_SKILL]);

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        });
    }

    protected function users(): array
    {
        $userStatic = [];
        $userRandom = [];

        $person = function($id = null, $firstName = null, $lastName = null, $email = null) use (&$userStatic, &$userRandom) {

            $data = [
                'first_name' => $firstName ?? $this->faker->firstName,
                'last_name' => 'Faker ' . ($lastName ?? $this->faker->lastName),
                'email' => $email ?? $this->faker->freeEmail,
                'password' => Hash::make(self::PASSWORD),
            ];

            if($id){
                return array_push($userStatic, array_merge(compact('id'), $data));
            }
            return array_push($userRandom, $data);
        };

        /**
        * Users Test static password 123456
        */
        $person(1, 'Juan', 'Carrizalez Employer', 'employer@gmail.com');
        $person(2, 'Juan', 'Carrizalez Employee', 'employee@gmail.com');
        $person(3, 'Employer', 'Test 01', 'avature+employer@gmail.com');
        $person(4, 'Employee', 'Test 02', 'avature+employee@gmail.com');
        $person(5, 'Avature', 'Test 03', 'avature+01@gmail.com');
        $person(6, 'Avature', 'Test 04', 'avature+02@gmail.com');
        $person(7, 'Avature', 'Test 05', 'avature+03@gmail.com');

        /**
        * Users Test random password 123456
        */
        for ($i=0; $i < self::USERS_RANDOM; $i++) {
            $person();
        }

        return compact('userStatic', 'userRandom');
    }

    protected function userCompanies(array $users, array $companies): array
    {
        /**
        * Relations User Company: [Is Employer]
        */
        return $this->userCompanyIds($users['userStatic'], $companies, [
            [
                'email' => 'employer@gmail.com',
                'companies' => [
                    'Adobe',
                    'Cisco',
                    'Ultimate Software',
                    'American Express',
                ]
            ],
            [
                'email' => 'avature+employer@gmail.com',
                'companies' => [
                    'Hilton'
                ]
            ],
        ]);
    }

    protected function jobs(): array
    {
        return $this->jobSkillsIds([
            [
                self::TABLE_JOBS => [
                    'id' => 1,
                    'user_id' => 1,
                    'company_id' => 1,
                    'country_id' => 1,
                    'title' => 'Cisco [' . $this->faker->jobTitle .']',
                    'description' => $this->faker->text(250),
                    'hidden_company' => true,
                    'active' => true,
                ],
                self::TABLE_JOB_SKILL => [
                    ['job_id' => 1, 'skill_id' => 1],
                    ['job_id' => 1, 'skill_id' => 2],
                    ['job_id' => 1, 'skill_id' => 8],
                    ['job_id' => 1, 'skill_id' => 13],
                    ['job_id' => 1, 'skill_id' => 16],
                    ['job_id' => 1, 'skill_id' => 17],
                    ['job_id' => 1, 'skill_id' => 18],
                ],
            ],
            [
                self::TABLE_JOBS => [
                    'id' => 2,
                    'user_id' => 1,
                    'company_id' => 2,
                    'country_id' => 1,
                    'title' => 'Adobe [' . $this->faker->jobTitle .']',
                    'description' => $this->faker->text(250),
                    'hidden_company' => false,
                    'active' => true,
                ],
                self::TABLE_JOB_SKILL => [
                    ['job_id' => 2, 'skill_id' => 3],
                    ['job_id' => 2, 'skill_id' => 4],
                ],
            ],
            [
                self::TABLE_JOBS => [
                    'id' => 3,
                    'user_id' => 1,
                    'company_id' => 7,
                    'country_id' => 1,
                    'title' => 'Ultimate Software [' . $this->faker->jobTitle .']',
                    'description' => $this->faker->text(250),
                    'hidden_company' => false,
                    'active' => true,
                ],
                self::TABLE_JOB_SKILL => [
                    ['job_id' => 3, 'skill_id' => 5],
                ],
            ],
        ]);
    }


    protected function userCompanyIds(array $users, array $companies, array $relations): array
    {
        $emailUsers = array_column($users, 'email');
        
        $nameCompanies = array_column($companies, 'name');

        $items = [];

        foreach ($relations as $relation) {
            
            if(false !== $userKey = array_search($relation['email'], $emailUsers)){

                $userId = $users[$userKey]['id'];

                foreach ($relation['companies'] as $company) {

                    if(false !== $companyKey = array_search($company, $nameCompanies)){

                        $items[] = [
                            'user_id' => $users[$userKey]['id'],
                            'company_id' => $companies[$companyKey]['id'],
                        ];
                    }
                }
            }
        }
        return $items;
    }

    protected function jobSkillsIds(array $relations): array
    {
        $jobs = [];
        $job_skill = [];

        foreach ($relations as $relation) {

            array_push($jobs, $relation[self::TABLE_JOBS]);

            foreach ($relation[self::TABLE_JOB_SKILL] as $jobSkill) {

                array_push($job_skill, $jobSkill);
            }
        }

        return compact(self::TABLE_JOBS, self::TABLE_JOB_SKILL);
    }
}
