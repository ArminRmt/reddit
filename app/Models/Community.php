<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;
    // protected $fillable = ['post_id', 'user_id', 'comment_text'];
    protected $fillable = ['user_id', 'name', 'description'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
