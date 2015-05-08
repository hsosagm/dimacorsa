<?php

class StatusTableSeeder extends Seeder {

	public function run()
	{
		$status = [
		            [
		                'status' => 'Active'
		            ],
		            [
		                'status' => 'Inactive'
		            ],
		        ];

        foreach($status as $st){
            Status::create($st);
        }
	}

}
