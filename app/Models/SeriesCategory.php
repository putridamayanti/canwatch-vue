<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesCategory extends Model
{
    protected $table = 'series_categories';

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
