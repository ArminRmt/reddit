<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use HasFactory, SoftDeletes;
    // protected $fillable = ['post_id', 'user_id', 'comment_text'];
    protected $fillable = ['user_id', 'name', 'description'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }


    // public function sluggable()
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'name'
    //         ]
    //     ];
    // }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    // public function posts()
    // {
    //     return $this->hasMany(Post::class);
    // }
}
