<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Contact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // カテゴリーを先に追加
        $this->call([
            CategorySeeder::class,
        ]);

        Product::factory(35)->create();
        Contact::factory(35)->create();
    }
}
