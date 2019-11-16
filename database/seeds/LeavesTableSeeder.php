<?php

use Illuminate\Database\Seeder;

class LeavesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leaves')->insert([
            'leave_type' => 'Casual leave',
            'days' => 12,
        ]);
        DB::table('leaves')->insert([
            'leave_type' => 'Sick leave',
            'days' => 12,
        ]);
        DB::table('leaves')->insert([
            'leave_type' => 'Paid leave',
            'days' => 10, //after 2 year service
        ]);
    }
}
