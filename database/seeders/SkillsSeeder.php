<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends Seeder
{
    protected const TABLE = 'skills';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = self::data();

        DB::transaction(function () use ($data) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            DB::table(self::TABLE)->truncate();

            DB::table(self::TABLE)->insert($data);

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        });
    }

    private static function data(): array
    {
        return [
            [
                'id'=> 1,
                'slug' => 'php',
                'description' => 'PHP'
            ],
            [
                'id'=> 2,
                'slug' => 'javascript',
                'description' => 'JAVASCRIPT'
            ],
            [
                'id'=> 3,
                'slug' => 'c-plus-plus',
                'description' => 'C++'
            ],
            [
                'id'=> 4,
                'slug' => 'java',
                'description' => 'Java'
            ],
            [
                'id'=> 5,
                'slug' => 'python',
                'description' => 'Python'
            ],
            [
                'id'=> 6,
                'slug' => 'ruby',
                'description' => 'Ruby'
            ],
            [
                'id'=> 7,
                'slug' => 'lua',
                'description' => 'Lua'
            ],
            [
                'id'=> 8,
                'slug' => 'bootstrap',
                'description' => 'Bootstrap'
            ],
            [
                'id'=> 9,
                'slug' => 'angular-js',
                'description' => 'Angular JS'
            ],
            [
                'id'=> 10,
                'slug' => 'react-js',
                'description' => 'React JS'
            ],
            [
                'id'=> 11,
                'slug' => 'react-native',
                'description' => 'React Native'
            ],
            [
                'id'=> 12,
                'slug' => 'postgresql',
                'description' => 'Postgresql'
            ],
            [
                'id'=> 13,
                'slug' => 'mysql',
                'description' => 'Mysql'
            ],
            [
                'id'=> 14,
                'slug' => 'mongo-db',
                'description' => 'Mongo DB'
            ],
            [
                'id'=> 15,
                'slug' => 'redis',
                'description' => 'Redis'
            ],
            [
                'id'=> 16,
                'slug' => 'memcached',
                'description' => 'Memcached'
            ],
            [
                'id'=> 17,
                'slug' => 'html',
                'description' => 'HTML'
            ],
            [
                'id'=> 18,
                'slug' => 'css',
                'description' => 'Css'
            ],
            [
                'id'=> 19,
                'slug' => 'rabbitmq',
                'description' => 'Rabbitmq'
            ],
            [
                'id'=> 20,
                'slug' => 'kafka',
                'description' => 'Kafka'
            ],
            [
                'id'=> 21,
                'slug' => 'docker',
                'description' => 'Docker'
            ],
            [
                'id'=> 22,
                'slug' => 'kubernetes',
                'description' => 'Kubernetes'
            ],
        ];
    }
}
