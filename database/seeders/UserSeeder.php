<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::truncate();
    	$data = [
    		[
    			'first_name' => 'Admin',
    			'last_name' => 'User',
    			'email' => 'admin@gmail.com',
    			'role' => 'Admin',
    			'password' => Hash::make('admin@123'),
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		]
    	];
    	User::insert($data);
    }
}
