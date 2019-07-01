<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Series extends Model
{
    protected $table = 'series';

    public function country() {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function category() {
        return $this->hasMany(SeriesCategory::class, 'series_id', 'id');
    }

    public function resource() {
        return $this->hasMany(SeriesResource::class, 'series_id', 'id');
    }

    public function playlist() {
        return $this->hasOne(SeriesPlaylist::class, 'series_id', 'id');
    }

    public function episodes() {
        return $this->hasMany(SeriesEpisodes::class, 'series_id', 'id');
    }

    public function search($request) {
//        dd((object)$request);
        $models     = $this->newQuery();
        $request    = json_decode(json_encode((object) $request), FALSE);
        dd($request);
        if ($request->keyword) {
            $keyword    = strtolower($request->keyword);
            $models = $models->where('title', 'like', '%' .$keyword. '%');
        }

        if ($request->year) {
            $models = $models->where('year', $request['year']);
        }

        if ($request['category']) {
            $models = $models->with('category')->where('category_id', $request['category']);
        }

        $models = $models->get();

        dd($models);
    }
}
