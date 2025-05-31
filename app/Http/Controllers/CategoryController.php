<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use FileUpload;

    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.category.index',compact('categories'));
    }

    public function create()
    {
        return view('backend.category.create');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status' => ['required', 'boolean', 'in:0,1'],
        ]);

        // Logic to store a new category
        $imagePath = $this->uploadFile($request->file('image'), 'uploads/category');

        $category = new Category();
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->description = $request->description;
        $category->image = $imagePath;
        $category->status = $request->status;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category created successfully.');  
        
    }

    public function edit($id)
    {
        // Logic to show form for editing an existing category
        
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing category
        // Validate and update the category
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        // Delete the image file if it exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function show($id)
    {
        // Logic to display a single category
    }
}
