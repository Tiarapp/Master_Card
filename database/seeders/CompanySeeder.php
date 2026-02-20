<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'id' => 1,
                'name' => 'PT. SPA (Corrugated Box)',
                'address' => 'Jl. Industri Raya No. 123',
                'phone' => '021-12345678',
                'email' => 'info@spa-corrugated.com',
                'logo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'PT. SPA (Tissue Manufacturing)',
                'address' => 'Jl. Industri Raya No. 456',
                'phone' => '021-87654321',
                'email' => 'info@spa-tissue.com',
                'logo' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['id' => $company['id']],
                $company
            );
        }
    }
}
