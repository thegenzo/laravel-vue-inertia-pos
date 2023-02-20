<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        // get categories
        $categories = Category::when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        // return inertia
        return Inertia::render('Apps/Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return Inertia::render('Apps/Categories/Create');
    }

    public function store(Request $request)
    {
        // validate
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2000',
            'name' => 'required|unique:categories',
            'description' => 'required'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // create category
        Category::create([
            'image' => $image->hashName(),
            'name'          => $request->name,
            'description'   => $request->description
        ]);

        //redirect
        return redirect()->route('apps.categories.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Apps/Categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        // validate
        $this->validate($request, [
            'name' => 'required|unique:categories,name,'.$category->id,
            'description' => 'required'
        ]);

        // check image update
        if ($request->file('image')) {
            // remove old image
            Storage::disk('local')->delete('/public/categories/'.basename($category->image));

            // upload new image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // update category with new image
            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'description' => $request->description
            ]);

        }

        // update category without image
        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // redirect
        return redirect()->route('apps.categories.index');
    }

    public function destroy($id)
    {
        // find by ID
        $category = Category::findOrFail($id);

        // remove image
        Storage::disk('local')->delete('public/categories/'.basename($category->image));

        // delete
        $category->delete();

        // redirect
        return redirect()->route('apps.categories.index');
    }
}
