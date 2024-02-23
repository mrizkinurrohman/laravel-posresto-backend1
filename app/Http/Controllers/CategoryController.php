<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //index
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

    //stpre
    public function store(Request $request)
    {
        //validate the request
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:22048',
        ]);

        //store the request
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('/public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category Create Successfully');
    }

    //show
    public function show($id)
    {
        return view('pages.categories.show');
    }

    //edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        //validate the request
        $request->validate([
            'name' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:22048',

        ]);

        //store the request
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('/public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category Create Successfully');
    }

    //destroy
    public function destroy($id)
    {
        // delete the request
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category Create Successfully');
    }
}
