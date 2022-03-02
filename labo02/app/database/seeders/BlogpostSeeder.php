<?php

namespace Database\Seeders;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogpostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        $faker->seed(668);
        for ($i = 0; $i < 50; $i++) {
            DB::table('blogposts')->insert([
                'title' => Str::substr($faker->realText(25, 5), 0, -1),
                'content' => $faker->realText(200, 3),
                'image' => $this->downloadPicsumFile($faker->numberBetween(1, 100000)),
                'featured' => false,
                'author_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
                'created_at' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
                'updated_at' => null
            ]);
        }
        DB::table('blogposts')->whereIn('id', $faker->randomElements(range(1,50),5))
            ->update(['featured' => true]);
    }

    private function downloadPicsumFile(int $seed) : string {
        $url = 'https://picsum.photos/seed/' . $seed . '/800/600';
        try {
            $contents = file_get_contents($url);
            $fileName = md5($contents) . '.jpg';
            Storage::put('public/' . $fileName, $contents);
            return $fileName;
        } catch (\ErrorException $e) {
            echo 'WARNING: image could not be downloaded !!! URL: ' . $url . PHP_EOL;
            echo 'MESSAGE: ' . $e->getMessage() . PHP_EOL;
        }
        return '';



    }
}
