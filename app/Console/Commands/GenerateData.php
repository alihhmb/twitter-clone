<?php

namespace App\Console\Commands;

use App\Post;
use App\User;
use Illuminate\Console\Command;
use Faker;

class GenerateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Fake Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * This command generates 50 users, each use has 100 tweet
     * @return mixed
     */
    public function handle()
    {
        $faker = Faker\Factory::create();
        for($i=1; $i <= 50; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => '$2y$10$Rwwki2/Op5vBEPmyq3msG.OJ11I2vRqLW34kDEggMPwxhcGiAKmn.', // 123456
                'remember_token' => str_random(10),
            ]);
            for($j=1; $j <= 100; $j++) {
                Post::create([
                    'user_id' => $user->id,
                    'post' => $faker->paragraphs($nb = 3, $asText = true),
                ]);
            }
        }
    }
}
