<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesEpisodes extends Model
{
    protected $table    = 'series_episodes';

    public function series() {
        return $this->belongsTo(Series::class, 'series_id', 'id');
    }
}
