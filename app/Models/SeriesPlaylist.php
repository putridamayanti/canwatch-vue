<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesPlaylist extends Model
{
    protected $table = 'series_playlist';

    public function series() {
        return $this->belongsTo(Series::class, 'series_id', 'id');
    }

    public function resources() {
        return $this->belongsTo(Resources::class, 'resource_id', 'id');
    }
}
