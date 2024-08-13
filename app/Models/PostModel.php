<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id'
    ];

    public function postKategory()
    {

        return $this->hasMany(PostKategoryModel::class, 'post_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kategory()
    {
        return $this->belongsToMany(KategoryModel::class, 'post_kategory', 'post_id', 'kategory_id');
    }
}
