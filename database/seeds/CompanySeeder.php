<?php

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        factory(\App\Company::class, 100)->create();
    }
}
