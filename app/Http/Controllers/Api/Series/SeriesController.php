<?php

namespace App\Http\Controllers\Api\Series;

use App\Models\Category;
use App\Models\Country;
use App\Models\Resources;
use App\Models\Series;
use App\Models\SeriesCategory;
use App\Models\SeriesResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Series::orderBy('created_at', 'desc')->get();

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
        $model                  = new Series();
        $model->country_id      = $request->get('country_id')['id'];
        $model->title           = $request->get('title');
        $model->description     = $request->get('description');
        $model->year            = $request->get('year');
        $model->slug            = str_slug($request->get('title').'-'.$request->get('year'));
        if($request->get('image')) {
            $image  = $request->get('image');
            $name   = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $location   = public_path(DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'series'.DIRECTORY_SEPARATOR);
            Image::make($request->get('image'))->save($location.$name);
            $model->image = $name;
        }
        $model->save();

        if ($request->get('categorySelected')) {
            $getCategory = $request->get('categorySelected');
            for ($i=0; $i < count($getCategory); $i++) {
                $category = new SeriesCategory();
                $category->series_id    = $model->id;
                $category->category_id  = $getCategory[$i]['id'];
                $category->save();
            }
        }

        if ($request->get('resourceSelected')) {
            $getResource = $request->get('resourceSelected');
            for ($i=0; $i < count($getResource); $i++) {
                $resource = new SeriesResource();
                $resource->series_id    = $model->id;
                $resource->resource_id  = $getResource[$i]['id'];
                $resource->save();
            }
        }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model      = Series::with('country')
            ->with('category.category')
            ->with('resource.resource')
            ->find($id);
        $category   = Category::orderBy('name')->get();
        $country    = Country::orderBy('name')->get();
        $resource   = Resources::orderBy('name')->get();
        $series_category    = SeriesCategory::where('series_id', $model->id)->get();
        $series_resource    = SeriesResource::where('series_id', $model->id)->get();

        return response()->json(['data' => $model, 'category' => $category,
            'country' => $country, 'resource' => $resource], 200);
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
        $model                  = Series::find($id);
        $model->country_id      = $request->get('country_id')['id'];
        $model->title           = $request->get('title');
        $model->description     = $request->get('description');
        $model->year            = $request->get('year');
        $model->slug            = str_slug($request->get('title').'-'.$request->get('year'));
        if($request->get('image') != $model->image) {
            $image  = $request->get('image');
            $name   = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $location   = base_path().DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'series'.DIRECTORY_SEPARATOR;
            Image::make($request->get('image'))->save($location.$name);
            $model->image = $name;
        }
        $model->save();

        if ($request->get('categorySelected')) {
            $getCategory = $request->get('categorySelected');
            for ($i=0; $i < count($getCategory); $i++) {
                $category = new SeriesCategory();
                $category->series_id    = $model->id;
                $category->category_id  = $getCategory[$i]['id'];
                $category->save();
            }
        }

        if ($request->get('resourceSelected')) {
            $getResource = $request->get('resourceSelected');
            for ($i=0; $i < count($getResource); $i++) {
                $resource = new SeriesResource();
                $resource->series_id    = $model->id;
                $resource->resource_id  = $getResource[$i]['id'];
                $resource->save();
            }
        }
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
        $model = Series::find($id);
        $model->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
