<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use App\Models\SeriesEpisodes;
use App\Models\SeriesPlaylist;
use App\Supports\Dailymotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    protected $dailymotion;

    public function __construct()
    {
        $this->dailymotion = new Dailymotion();
    }

    public function index() {
        $top = Series::orderBy('created_at', 'desc')->take(10)->get();
        $latest = SeriesEpisodes::with('series')->take(10)->orderBy('created_at', 'desc')->get();
        $korean = Series::join('countries', 'countries.id', '=', 'series.id')
            ->where('countries.name', 'Korean')->get();
        $chinese = Series::join('countries', 'countries.id', '=', 'series.id')
            ->where('countries.name', 'Chinese')->get();

        return response()->json(['top' => $top, 'latest' => $latest, 'korean' => $korean, 'chinese' => $chinese], 200);
    }

    public function detail($slug) {
        $params = [
            'limit' => 50,
            'fields' => 'embed_html,title,thumbnail_120_url,duration,id'
        ];
        $series = Series::where('slug', $slug)
            ->with('category.category')
            ->with('country')
            ->with('resource.resource')->first();
        $resource   = $series->resource[0]->resource;
//        dd($resource);
        if (strtolower($resource->name) == 'dailymotion') {
            $data = $this->dailymotion->getVideo($series->playlist->link, $params);
        } else {
//            dd($series->episodes);
            if ($series->episodes) {
                $data = $series->episodes;
            }
        }



        return response()->json(['detail' => $series, 'data' => $data, 'type' => strtolower($resource->name)], 200);
    }

    public function getSeries(Request $request , Series $models) {
//        return response()->json($request->all());
        if (!$request->all()) {
            $models = $models->get();
        } else {
            $keyword    = explode(' ', $request->get('keyword'));
            $year       = $request->get('year');
            $category   = $request->get('category');
            if ($keyword) {
                $models = $models->where(function ($query) use ($keyword) {
                    foreach ($keyword as $item) {
                        $query->where('title', 'like', '%' . $item . '%');
                    }
                });
            }
            if ($year) {
                $models = $models->where('year', $year);
            }
            if ($category) {
                $models = $models->join('series_categories', 'series_id', '=', 'series.id')
                    ->where('series_categories.category_id', $category);
            }
            $models = $models->get();
        }

        return response()->json($models, 200);
    }
}
