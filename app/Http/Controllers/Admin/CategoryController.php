<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\ServiceSubCategory;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.services.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $imagePath = $this->uploadFile($request->file('image'), 'uploads/category');

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description; 
        $category->status = $request->status;
        $category->show_at_trending = $request->show_at_trending;
        $category->image = $imagePath;

        // Prevent enabling show_at_trending if status is off
        if ($category->status == 0 && $category->show_at_trending == 1) {
            $category->show_at_trending = 0;
            flash()->warning('Show at Trending was turned off because Status is off');
        }

        $category->save();


        return redirect()->route('admin.service_category.index')->with('success', 'Category Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('admin.services.categories.edit', compact('category'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            $this->deleteFile($category->image);
            $imagePath = $this->uploadFile($request->file('image'), 'uploads/category');
            $category->image = $imagePath;
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->description = $request->description;
        $category->show_at_trending = $request->show_at_trending;

        // Prevent enabling show_at_trending if status is off
        if ($category->status == 0 && $category->show_at_trending == 1) {
            $category->show_at_trending = 0;
            session()->flash('warning', 'Show at Trending was turned off because Status is off');
        }

        $category->save();
        return redirect()->route('admin.service_category.index')->with('success', 'Course Category Updated Successfully');
    }


    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->status = $request->status;

        // If status is turned off, also turn off show_at_trending
        if ($category->status == 0 && $category->show_at_trending == 1) {
            $category->show_at_trending = 0;
        }

        $category->save();

        return response()->json(['success' => 'Status updated successfully.']);
    }

        /**
     * Update the show_at_trending status of the specified resource.
     */
    public function updateShowAtTrending(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Prevent enabling show_at_trending if status is off
        if ($request->show_at_trending == 1 && $category->status == 0) {
            return response()->json([
                'error' => 'Cannot enable Show at Trending when Status is off'
            ], 422);
        }
        
        $category->show_at_trending = $request->show_at_trending;
        $category->save();

        return response()->json(['success' => 'Show at trending status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Check if there are any associated course sub-category before deletion
        $hasItem  = ServiceSubCategory::where('category_id', $category->id)->exists();
    
        if ($hasItem) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete category with associated sub categories.'
            ]);
        }

        $this->deleteFile($category->image);
        $category->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
