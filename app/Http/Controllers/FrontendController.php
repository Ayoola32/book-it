<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
public function index(Request $request)
{
    $categories = Category::with([
        'subCategories' => function ($query) {
            $query->where('status', 1)
                ->with([
                    'employees' => function ($query) {
                        // Only include employees with active users
                        $query->whereHas('user', function ($q) {
                            $q->where('status', 1);
                        })->with('user');
                    }
                ]);
        }
    ])->where('status', 1)->get();

    return view('welcome', compact('categories'));
}

}
