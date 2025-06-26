<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use App\Models\ServiceSubCategory;
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

    public function getEmployees(Request $request, ServiceSubCategory $service)
    {
        $employees = $service->employees()
            ->whereHas('user', function ($query) {
                $query->where('status', 1);
            })
            ->with('user') // Eager load user details
            ->get();

        if ($employees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No employees available for this service'
            ]);
        }

        return response()->json([
            'success' => true,
            'employees' => $employees,
            'service' => $service
        ]);
    }

}
