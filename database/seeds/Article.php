<?php

use think\migration\Seeder;

class Article extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create($locale = 'zh_CN');
        $rows = [];
        for ($i = 0; $i < 100; $i++) {
            $rows[] = [
                'title' => $faker -> title,
                'featured_image' => $faker -> imageUrl(),
                'release_time' => $faker -> unixTime,
                'describes' => $faker ->randomAscii,
                'keywords' => $faker  ->randomAscii,
                'content_markdown' => '',
                'content' => '',
                'is_original' => mt_rand(0,1),
                'source_url' => $faker -> url,
                'source_name' => $faker -> title,
                'category_id' => 0,
                'category_name' => '未知',
                'views' => mt_rand(1,9999),
                'create_time' => $faker-> unixTime,
                'update_time' => $faker -> unixTime,
                'delete_time' => 0,
            ];
        }
        $this->table('article')->insert($rows)->save();
        
    }
}