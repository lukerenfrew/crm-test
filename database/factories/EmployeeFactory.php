<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->companyEmail,
        'phone' => $faker->phoneNumber,
        'company_id' => function () {
            $company = Company::inRandomOrder()->limit(1)->first();
            return $company != null ? $company : factory(Company::class)->create();
        }
    ];
});
