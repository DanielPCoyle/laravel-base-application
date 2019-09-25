<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
	return [
		"name" => $faker->name,
		"price" => $faker->randomNumber(2),
		"description" => $faker->text,
		"category_id" => rand(1,10),
		
	];
});