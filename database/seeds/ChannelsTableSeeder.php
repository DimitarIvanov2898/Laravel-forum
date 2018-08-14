<?php

use Illuminate\Database\Seeder;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channel = ['title' => 'Laravel', 'slug' => str_slug('Laravel')];
        $channel2 = ['title' => 'VueJs', 'slug' => str_slug('VueJs')];
        $channel3 = ['title' => 'ReactJs', 'slug' => str_slug('ReactJs')];
        $channel4 = ['title' => 'ReactNative', 'slug' => str_slug('ReactNative')];
        $channel5 = ['title' => 'PHP', 'slug' => str_slug('PHP')];
        $channel6 = ['title' => 'Html', 'slug' => str_slug('HTML')];
        $channel7 = ['title' => 'CSS', 'slug' => str_slug('CSS')];
        $channel8 = ['title' => 'C#', 'slug' => str_slug('C#')];
        $channel9 = ['title' => 'Cici', 'slug' => str_slug('Cicie')];

        \App\Channel::create($channel);
        \App\Channel::create($channel2);
        \App\Channel::create($channel3);
        \App\Channel::create($channel4);
        \App\Channel::create($channel5);
        \App\Channel::create($channel6);
        \App\Channel::create($channel7);
        \App\Channel::create($channel8);
        \App\Channel::create($channel9);

    }
}
