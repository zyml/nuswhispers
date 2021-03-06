<?php

namespace NUSWhispers\Http\Controllers;

use Cache;
use NUSWhispers\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $output = Cache::rememberForever('categories', function () {
            return ['data' => ['categories' => Category::categoryAsc()->get()]];
        });

        return response()->json($output);
    }

    /**
     * Get the category JSON by a given category_id
     * route: api/categories/<category_id>.
     *
     * @param int $category_id
     *
     * @return json {"success": true or false, "data": {"category": category}};
     */
    public function show($categoryId)
    {
        if (! ($category = Category::find($categoryId))) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'data' => ['category' => $category]]);
    }
}
