<?php

namespace App\Http\Controllers\Api\Series;

use App\Models\Resources;
use App\Models\Series;
use App\Models\SeriesPlaylist;
use App\Supports\Dailymotion;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    protected $dailymotion;

    public function __construct()
    {
        $this->dailymotion = new Dailymotion();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = SeriesPlaylist::with('series')->orderBy('created_at', 'desc')->get();

        return response()->json($models, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model              = new SeriesPlaylist();
        $model->series_id   = $request->get('seriesSelected')['id'];
        $model->resource_id = $request->get('resourceSelected')['id'];
        $model->link        = $request->get('link');
        $model->save();

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model  = SeriesPlaylist::find($id);
        $resource = Resources::where('name', 'Dailymotion')->first();
        if ($model->resource_id == $resource->id) {
            $params = [
                'limit' => 50,
                'fields' => 'embed_html,title,thumbnail_120_url,duration,id'
            ];
        }
        $series = Series::where('id', $model->series_id)
            ->with('category.category')
            ->with('country')
            ->with('resource.resource')->first();
//        dd($series);
        $resource   = $series->resource[0]->resource;
        if (strtolower($resource->name) == 'dailymotion') {
            $data = $this->dailymotion->getVideo($series->playlist->link, $params);
        } else {
//            dd($series->episodes);
            if ($series->episodes) {
                $data = $series->episodes;
            }
        }
        return response()->json($data);
//        dd($data);
//        $client = new Client();
//        $res = $client->request('GET', $model->link.'/videos', ['query' => $params]);
//        $result = json_decode($res->getBody()->getContents());
//        dd($result);
//        return response()->json($result->list);
//        dd($result->list);
//        foreach ( $result->list as $item) {
//            dd($item);
//        }
//        dd($res->getBody()->getContents());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = SeriesPlaylist::with('series')->with('resources')->findOrFail($id);

        return response()->json($model, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $model              = SeriesPlaylist::find($id);
        $model->series_id   = $request->get('seriesSelected')['id'];
        $model->resource_id = $request->get('resourceSelected')['id'];
        $model->link        = $request->get('link');
        $model->save();

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = SeriesPlaylist::findOrFail($id);
        $model->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
