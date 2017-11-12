<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;
	$sex = ['男','女'];

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
		'sex' => $sex[random_int(0,1)],
		'tel' => $faker->phoneNumber,
		'stuId' => random_int(15180120000,15180190077),
        'remember_token' => str_random(10),
    ];
});
