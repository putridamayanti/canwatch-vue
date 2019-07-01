<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesResource extends Model
{
    protected $table    = 'series_resource';

    public function resource() {
        return $this->belongsTo(Resources::class, 'resource_id', 'id');
    }
}
