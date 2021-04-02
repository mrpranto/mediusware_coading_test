<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        \App\Models\User::query()->create([
            'name' => 'pranto',
            'email' => 'pranto@email.com',
            'password' => bcrypt('11223344')
        ]);

        $variants = ['color', 'size'];

        foreach ($variants as $key => $variant)
        {
            \App\Models\Variant::query()->create([
                'title' => $variant
            ]);
        }

    }
}
