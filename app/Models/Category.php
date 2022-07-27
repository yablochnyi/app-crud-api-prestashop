<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = false;

    public function products()
    {
        return $this->hasMany(UserProduct::class, 'category_id', 'prestashop_id');
    }
}
