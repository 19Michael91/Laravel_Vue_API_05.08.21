<?php

use Illuminate\Database\Seeder;
use App\Organisation;
use App\User;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
                                                      'email'     => 'test@test.com',
                                                      'password'  => bcrypt('password'),
                                                  ]);

        factory(Organisation::class, 10)->create([
                                                                'user_id' => $user->id
                                                            ]);
    }
}
