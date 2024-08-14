<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostKategoryModel extends Model
{
    use HasFactory;

    protected $table = 'post_kategory';

    protected $guarded = ['id'];

    public function posts()
    {
        return $this->hasMany(PostModel::class, 'id', 'post_id');
    }

    public function kategory()
    {
        return $this->belongsTo(KategoryModel::class, 'kategory_id', 'id');
    }
}
