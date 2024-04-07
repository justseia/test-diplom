<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => 'Kurbanbek Yerulan',
            'email'      => 'yerulan02@gmail.com',
            'age'  => 22,
            'aboutMe' => 'I am Yerulan',
            'password'   => bcrypt('secret'),
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
    }
}
