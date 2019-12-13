<?php

use Faker\Generator as Faker;
use App\Modules\Users\User;
use Illuminate\Database\Eloquent\Factory;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'password' => bcrypt('secret'), // secret
      'remember_token' => str_random(10),
      'type' => $faker->randomElement(User::TYPE),
      'mobile' => $faker->phoneNumber,
      'gender' => $faker->randomElement(['male', 'female'])
    ];
});
