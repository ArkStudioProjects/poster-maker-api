<?php

namespace App\Http\Controllers;

use App\Classes\DesignImages;
use App\Http\Resources\DesignResource;
use App\Models\Design;
use Illuminate\Http\Request;

class ItemController extends Controller
{
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

        return DesignResource::make($design);
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
    public function update(Request $request, Design $design)
    {
        $design->update($request->all());
        $design->clearMediaCollectionExcept();
        DesignImages::setDesignMedia($design, $request->get('preview'), 'preview');
        DesignImages::extract($design);
        $design->refresh();

        return DesignResource::make($design);
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
