<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function boot()
    {
        parent::boot();

        // 监听事件
        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }


    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 关注动作
     * @Author   Robert
     * @DateTime 2021-05-20
     * @param    [type]     $user_ids [description]
     * @return   [type]               [description]
     */
    public function follow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followerings()->sync($user_ids, false);
    }


    /**
     * 取关动作
     * @Author   Robert
     * @DateTime 2021-05-20
     * @param    [type]     $user_ids [description]
     * @return   [type]               [description]
     */
    public function unfollow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }

        $this->followerings()->detach($user_ids);
    }

    public function isFollowing($user_id)
    {
        // contains 判断 参数是否在集合中 返回 boolean 值
        return $this->followerings->contains($user_id);
    }


    public function followers()
    {
        return $this->belongsToMany(Users::class, 'followers', 'user_id', 'follower_id');
    }

    public function followerings()
    {
        return $this->belongsToMany(User::class. 'followers', 'follower_id', 'user_id');
    }



    /**
     * 获取当前用户所有 动态
     * @Author   Robert
     * @DateTime 2021-05-19
     * @return   [type]     [description]
     */
    public function feed()
    {
        return $this->stauses()
                        ->orderBy('created_at', 'desc');
    }






    /**
     * 根据email获取头像
     * @Author   Robert
     * @DateTime 2021-05-17
     * @param    string     $size [description]
     * @return   [type]           [description]
     */
    public function gravatar($size = "100")
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        
        return "https://gravatar.loli.net/avatar/$hash?s=$size";
    }


}
