<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::paginate(15);
        return CategoryResource::collection($category);
    }


    public function store(CategoryRequest $request)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required|string|min:5|max:255'
        //     ]
        // );
        // if ($validator->fails()) {
        //     return response()->json(
        //         [
        //             'error' => true,
        //             'errors' => $validator->errors()
        //         ],
        //         422
        //     );
        // }

        $category = new Category(['name' => $request->name]);
        $category->save();
        return  new CategoryResource($category);
    }


    public function show(Category $category)
    {
        // $category = Category::findOrFail($id);
        return  new CategoryResource($category);
    }


    public function update(CategoryRequest $request, Category $category)
    {
        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required|string|min:5|max:255'
        //     ]
        // );
        // if ($validator->fails()) {
        //     return response()->json(
        //         [
        //             'error' => true,
        //             'errors' => $validator->errors()
        //         ],
        //         422
        //     );
        // }
        $category->name = $request->name;
        $category->save();
        return  new CategoryResource($category);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        // return response()->json(null, 204);
        return response()->json(
            [
                'error' => false,
                'message' => " the category with  $category->id is deleted successfully"
            ],
            200
        );
    }
}
