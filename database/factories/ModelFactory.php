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
        'code' => 0,
        'worker_code' => 0,
        'user_access_code' => 0,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret1234'),
        'salt' => '1234',
        'theme' => 'default',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Worker::class, function (Faker\Generator $faker) {

    return [
        'code' => 0,
        'name' => $faker->name,
        'legal_id' => $faker->creditCardNumber,
        'job_title' => 'Vendedor',
        'phone' => $faker->phoneNumber,
        'state' => 1,
        'current_branch_code' => '1',
    ];
});

$factory->define(App\WorkerSetting::class, function (Faker\Generator $faker) {

    return [
        'worker_code' => 0,
        'hourly_rate' => 0,
        'vehicle_code' => 0,
        'schedule_code' => 0,
        'notification_group' => 0,
        'self_print' => 1,
        'print_group' => 0,
        'commission_group' => 0,
        'discount_group' => 0,
        'branches_group' => 0,
        'pos_group' => 0
    ];
});

$factory->define(App\WorkerAccount::class, function (Faker\Generator $faker) {

    return [
        'worker_code' => 0,
        'cashbox_account' => 0,
        'stock_account' => 0,
        'loan_account' => 0,
        'long_loan_account' => 0,
        'salary_account' => 0,
        'commission_account' => 0,
        'bonus_account' => 0,
        'antiquity_account' => 0,
        'holidays_account' => 0,
        'savings_account' => 0,
        'insurance_account' => 0,
        'reimbursement_accounts' => '{}',
        'draw_accounts' => '{}',
        'bank_accounts' => '{}',
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {

    return [
        'code' => $faker->lexify('????????????????'),
        'provider_code' => '1',
        'description' => implode(' ', $faker->words(2)),
        'category_code' => '0',
        'onload_function' => '',
        'onsale_function' => '',
        'measurement_unit_code' => '0',
        'cost' => 100,
        'avg_cost' => 98,
        'price' => 200,
        'sellable' => 1,
        'sell_at_base_price' => 0,
        'base_price' => 120,
        'alternatives' => json_encode(array()),
        'volume' => 1,
        'weight' => 1.4,
        'package_code' => '',
        'package_measurement_unit_code' => '0',
        'order_by' => 0,
        'service' => 0,
        'materials' => json_encode(array()),
        'points_cost' => 0,
        'sales_account' => '0',
        'returns_account' => '0',
    ];
});
