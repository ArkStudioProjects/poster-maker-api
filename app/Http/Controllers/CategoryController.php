<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DesignResourceLite;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoryCollection
     */
    public function index()
    {
        $categories = Category::topLevel()
            ->with(['subCategories' => function($q) {
                $q->orderBy('order', 'asc')
                  ->orderBy('id');
            }])
            ->orderBy('order', 'asc')
            ->orderBy('id')
            ->get();
        return new CategoryCollection( $categories );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     * @return CategoryResource|array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function show(Category $category)
    {
        $designs = $category->designs()->orderBy('updated_at', 'desc')->paginate();

        return DesignResourceLite::collection($designs)
            ->additional(CategoryResource::make($category)->resolve());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
