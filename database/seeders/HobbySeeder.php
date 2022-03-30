<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hobby;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Hobby::truncate();
    	$data = [
    		[
    			'name' => 'Chess',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		],
    		[
    			'name' => 'Drawing',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		],
    		[
    			'name' => 'Singing',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		],
    		[
    			'name' => 'Cricket',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		],
    		[
    			'name' => 'Coding',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		],
    		[
    			'name' => 'Dancing',
    			'created_at' => date("Y-m-d H:i:s"),
    			'updated_at' => date("Y-m-d H:i:s"),
    		]
    	];
    	Hobby::insert($data);
    }
}
