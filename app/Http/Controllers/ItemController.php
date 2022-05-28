<?php

namespace App\Http\Controllers;

use App\Classes\DesignImages;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware( ['auth:sanctum'] )->only(['store', 'update', 'destroy']);
        $this->middleware( ['ability:create'] )->only('store');
        $this->middleware( ['ability:update'] )->only('update');
        $this->middleware( ['ability:delete'] )->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return DesignResource
     */
    public function store(Request $request)
    {
        $design = Design::make($request->all());
        $design->author()->associate( auth()->user() );
        $design->save();
        DesignImages::setDesignMedia($design, $request->get('preview'), 'preview');
        DesignImages::extract($design);
        $design->refresh();
        $design->categories()->attach( $request->input('category'));

        return $design->id;
    }

    /**
     * Display the specified resource.
     *
     * @param Design $design
     * @return DesignResource
     */
    public function show(Design $item)
    {
        return DesignResource::make($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return DesignResource
     */
    public function update(Request $request, Design $item)
    {
        logger()->info('Updating', $item->only(['id', 'title']));
        $item->author()->associate( auth()->user() );
        $item->categories()->sync( [ $request->input('category') ]);
        $item->update($request->all());
        $item->refresh();

        $item->clearMediaCollection('preview');
        DesignImages::setDesignMedia($item, $request->get('preview'), 'preview');
        $item->clearMediaCollection('node-images');
        DesignImages::extract($item);

        $item->refresh();
        return DesignResource::make($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
