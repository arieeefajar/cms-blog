<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'kategory';

    protected $fillable = [
        'name',
    ];

    public function postKategory()
    {
        return $this->hasMany(PostKategoryModel::class, 'kategory_id', 'id');
    }
}
