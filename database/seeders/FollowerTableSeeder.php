<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        // 获取id为1以外的所有id
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 1号关注其他所有人
        $user->follow($follower_ids);


        // 其他所有人关注1号
        foreach ($followers as $follower) {
        	$follower->follow($user_id);
        }
        
    }
}
