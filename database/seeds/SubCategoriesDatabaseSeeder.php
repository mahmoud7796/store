<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubCategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<10;$i++){
            factory(Category::class,1)->create([
                'parent_id' => $this->getRandomCategory(),
            ]);
        }
    }

private function  getRandomCategory(){
        $parent_id =  \App\Models\Category::inRandomOrder()->first()->id;
        return $parent_id;
}
}
