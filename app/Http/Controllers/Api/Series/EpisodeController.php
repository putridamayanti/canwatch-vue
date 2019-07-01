<?php

namespace App\Http\Controllers\Api\Series;

use App\Models\Series;
use App\Models\SeriesEpisodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = SeriesEpisodes::with('series')->orderBy('created_at')->get();

        return response()->json($models);
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
        $validator  = \Validator::make($request->all(),[
            'title'      => 'required',
            'source'    => 'required',
        ],[],[
            'title'      => 'Title',
            'source'    => 'Content',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'data' => $validator->errors()]);
        }

        $model  = new SeriesEpisodes();
        $model->series_id   = $request->get('seriesSelected')['id'];
        $model->title       = $request->get('title');
        $source = '<iframe frameborder="0" src="'.$request->get('source').'" allowfullscreen></iframe>';
        $model->source      = $source;
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
        //
    }

    /**
     * Display the specified series.
     *
     * @param  int  $seri
     * @return \Illuminate\Http\Response
     */
    public function showBySeries($seri) {
        $model  = SeriesEpisodes::where('series_id', $seri)->get();

        return response()->json($model, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model  = SeriesEpisodes::with('series')->find($id);

        return response()->json($model);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator  = \Validator::make($request->all(),[
            'title'      => 'required',
            'source'    => 'required',
        ],[],[
            'title'      => 'Title',
            'source'    => 'Content',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'data' => $validator->errors()]);
        }

        $model  = SeriesEpisodes::find($id);
        $model->series_id   = $request->get('seriesSelected')['id'];
        $model->title       = $request->get('title');
        $source = '<iframe frameborder="0" src="'.$request->get('source').'" allowfullscreen></iframe>';
        $model->source      = $source;
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
        $model = SeriesEpisodes::findOrFail($id);
        $model->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
