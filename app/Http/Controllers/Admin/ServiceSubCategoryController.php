<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ServiceSubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Models\Category;
use App\Models\ServiceSubCategory;
use App\Traits\FileUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ServiceSubCategoryController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category, ServiceSubCategoryDataTable $dataTable)
    {
        if (!$category) {
            return redirect()->back()->with('error', 'Service Category not found.');
        }
        return $dataTable->setCategoryId($category->slug)->render('admin.services.service.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        return view('admin.services.service.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request, Category $category)
    {
       $service = new ServiceSubCategory();

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'uploads/service');
            $service->image = $imagePath;
        }

        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->status = $request->status;
        $service->description = $request->description;
        $service->price = $request->price;
        $service->sale_price = $request->sale_price;
        $service->category_id = $category->id;

        // Prevent enabling status if category is off
        if ($category->status == 0 && $service->status == 1) {
            $service->status = 0;
            session()->flash('warning', 'Status was turned off because Category Status is off');
        }

        $service->save();
        return redirect()->route('admin.service.index', $category->slug)->with('success', 'Service Created Successfully');


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
    public function edit(Category $category, ServiceSubCategory $service)
    {
        return view('admin.services.service.edit', compact('category', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, Category $category, ServiceSubCategory $service)
    {
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'uploads/service');
            $service->image = $imagePath;
        }

        $service->name = $request->name;
        $service->slug = Str::slug($request->name);
        $service->description = $request->description;
        $service->status = $request->status;
        $service->price = $request->price;
        $service->sale_price = $request->sale_price;


        if ($category->status == 0 && $service->status == 1) {
            $service->status = 0;
            session()->flash('warning', 'Status was turned off because Category Status is off');
        }

        $service->save();

        return redirect()->route('admin.service.index', $category->slug)->with('success', 'Service Updated Successfully');
    }


    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, Category $category, ServiceSubCategory $service)
    {
        $service->status = $request->status;

        if ($category->status == 0 && $service->status == 1) {
            $service->status = 0;
            session()->flash('warning', 'Status was turned off because Category Status is off');
        }
        
        $service->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, ServiceSubCategory $service)
    {
        // Check if the image exists before attempting to delete it
        if ($service->image) {
            $this->deleteFile($service->image);
        }

        $service->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Service deleted successfully.'
        ]);    
    }
}
