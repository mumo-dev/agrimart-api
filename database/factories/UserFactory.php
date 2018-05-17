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
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function (Faker $faker){
    return[
        'name'=>$faker->word
    ];
});

$factory->define(App\Product::class, function (Faker $faker){
   return[
       'category_id'=> App\Category::all()->random()->id,
       'user_id'=>App\User::all()->random()->id,
       'name'=>$faker->word,
       'description'=>$faker->paragraph,
       'price'=>$faker->numberBetween(20,200)
   ];
});

$factory->define(App\Image::class, function (Faker $faker){
   return[
      'img_path'=>$faker->randomElement([
          'food.jpeg','food2.jpeg','food3.jpg','food4.jpeg','food5.jpeg','food6.jpeg','food7.jpeg','food8.jpeg',
          'food9.jpg','food10.jpg','food11.png','food12.jpg','food13.jpg','food14.jpg','food15.jpg','food16.jpg',
          'food17.jpeg','food18.jpg']),
      'product_id'=>factory('App\Product')->create()->id
   ] ;
});

