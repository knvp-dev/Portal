<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'company' => "Konvert",
        'address' => $faker->word,
        'postalcode' => 1234,
        'city' => "Kortrijk",
        'phone' => '+32 (0)56 21 54 84',
        'fax' => '+32 (0)56 21 54 88',
        'entity' => 'KIV',
        'entity_extra' => null,
        'budget' => 72000,
        'start_budget' => 72000,
        'admin' => 0,
        'dm' => 0,
        'dm_id' => 0,
        'advertisement_budget' => 15000,
        'advertisement_start_budget' => 15000
    ];
});

$factory->define(App\PromoItem::class, function (Faker\Generator $faker) {
	return [
		'code' => $faker->unique()->randomDigit,
		'name_nl' => $faker->word,
		'name_fr' => $faker->word,
		'pack' => $faker->randomDigit,
		'stock' => $faker->randomDigit,
		'price' => $faker->randomDigit,
		'image' => 'imagepath'
	];
});

$factory->define(App\PromoOrder::class, function (Faker\Generator $faker) {
	return [
		'user_id' => function() {
			return factory('App\User')->create()->id;
		},
		'total_price' => $faker->randomDigit,
		'completed' => 0
	];
});