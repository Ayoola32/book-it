<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with([
            'services' => function ($query) {
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

        $employees = Employee::with('services')->with('user')->get();

        return view('welcome', compact('categories', 'employees'));
    }


    public function getServices(Request $request, Category $category)
    {
        $setting_currency = 'GBP';

        $services = $category->services()
            ->where('status', 1)
            ->with('category')
            ->get()
            ->map(function ($service) use ($setting_currency) {
                if (isset($service->price)) {
                    $service->price = Number::currency($service->price, $setting_currency);
                }

                if (isset($service->sale_price)) {
                    $service->sale_price = Number::currency($service->sale_price, $setting_currency);
                }

                return $service;
            });

        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }

}
