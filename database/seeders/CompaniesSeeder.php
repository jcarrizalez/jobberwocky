<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesSeeder extends Seeder
{
    protected const TABLE = 'companies';

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
                'id' => 1, 
                'name' => 'Cisco'
            ],
            [
                'id' => 2, 
                'name' => 'Adobe'
            ],
            [
                'id' => 3, 
                'name' => 'Wegmans Food Markets'
            ],
            [
                'id' => 4, 
                'name' => 'Workday'
            ],
            [
                'id' => 5, 
                'name' => 'Kimpton Hotels & Restaurants'
            ],
            [
                'id' => 6, 
                'name' => 'Edward Jones'
            ],
            [
                'id' => 7, 
                'name' => 'Ultimate Software'
            ],
            [
                'id' => 8, 
                'name' => 'Texas Health Resources'
            ],
            [
                'id' => 9, 
                'name' => 'Boston Consulting Group'
            ],
            [
                'id' => 10, 
                'name' => 'Stryker'
            ],
            [
                'id' => 11, 
                'name' => 'Publix Super Markets'
            ],
            [
                'id' => 12, 
                'name' => 'American Express'
            ],
            [
                'id' => 13, 
                'name' => 'Quicken Loans'
            ],
            [
                'id' => 14, 
                'name' => 'Orrick'
            ],
            [
                'id' => 15, 
                'name' => 'Baird'
            ],
            [
                'id' => 16, 
                'name' => 'JM Family Enterprises'
            ],
            [
                'id' => 17, 
                'name' => 'Kimley-Horn'
            ],
            [
                'id' => 18, 
                'name' => 'Camden Property Trust'
            ],
            [
                'id' => 19, 
                'name' => 'Cooley'
            ],
            [
                'id' => 20, 
                'name' => 'Plante Moran'
            ],
            [
                'id' => 21, 
                'name' => 'Salesforce'
            ],
            [
                'id' => 22, 
                'name' => 'Veterans United Home Loans'
            ],
            [
                'id' => 23, 
                'name' => 'Intuit'
            ],
            [
                'id' => 24, 
                'name' => 'The Cheesecake Factory'
            ],
            [
                'id' => 25, 
                'name' => 'Hilton'
            ],
        ];
    }
}
