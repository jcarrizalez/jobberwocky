<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    protected const TABLE = 'countries';

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
                'code' => 'ARG',
                'name' => 'Argentina'
            ],
            [
                'id'=> 2,
                'code' => 'CHL',
                'name' => 'Chile'
            ],
            [
                'id'=> 3,
                'code' => 'URY',
                'name' => 'Uruguay'
            ],
            [
                'id'=> 4,
                'code' => 'USA',
                'name' => 'Estados Unidos de América'
            ],
            [
                'id'=> 5,
                'code' => 'ESP',
                'name' => 'España'
            ],
        ];
    }
}
