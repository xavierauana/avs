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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'password'       => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Role::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->word,
        'code' => $faker->unique()->word
    ];
});
$factory->define(\App\Permission::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->word,
        'code' => $faker->unique()->word
    ];
});
$factory->define(App\PropertyType::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->name,
    ];
});
$factory->define(App\Property::class, function (Faker\Generator $faker) {
    return [
        'name'             => $faker->name,
        'description'      => json_encode(['code' => $faker->sentence()]),
    ];
});
$factory->define(App\RoomType::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->name,
    ];
});
$factory->defineAs(App\RoomType::class, 'single', function (Faker\Generator $faker) {
    $property = create_properties();

    return [
        'code'        => $faker->name,
        'property_id' => $property->id
    ];
});
$factory->define(App\Room::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->unique()->word,
    ];
});
$factory->define(App\Media::class, function (Faker\Generator $faker) {
    return [
        'link'=>$faker->imageUrl,
        'type'=>'image',
    ];
});
