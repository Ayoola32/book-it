<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Models\Category;
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
        return $dataTable->render('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
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
        $category->status = $request->status;
        $category->show_at_trending = $request->show_at_trending;
        $category->image = $imagePath;

        // Prevent enabling show_at_trending if status is off
        if ($category->status == 0 && $category->show_at_trending == 1) {
            $category->show_at_trending = 0;
            flash()->warning('Show at Trending was turned off because Status is off');
        }

        $category->save();


        return redirect()->route('admin.category.index')->with('success', 'Category Created Successfully');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        
        $category->show_at_trending = $request->show_at_trending;
        $category->save();

        return response()->json(['success' => 'Show at trending status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
