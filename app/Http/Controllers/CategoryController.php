<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Logic to display categories
        return view('backend.category.index');
    }

    public function create()
    {
        // Logic to show form for creating a new category
        
    }

    public function store(Request $request)
    {
        // Logic to store a new category
        // Validate and save the category
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
        // Logic to delete a category
    }
    public function show($id)
    {
        // Logic to display a single category
    }
}
