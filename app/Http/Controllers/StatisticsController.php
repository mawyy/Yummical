<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use DB;

class StatisticsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // SELECT distinct products.* 
        // FROM `products` 
        // inner join meal_product on products.id = meal_product.product_id
        // order by calorie desc
        // limit 5
        $this->middleware('auth');
    }

    public function show5HigherCal() {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->orderBy('calorie', 'desc')
            ->select('products.*')
            ->limit(5)
            ->distinct()
            ->get();
    }

    public function show5LowerCal() {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->orderBy('calorie', 'asc')
            ->select('products.*')
            ->limit(5)
            ->distinct()
            ->get();
    }
    // SELECT products.* , sum(calorie) as total_calories
    // FROM `products` 
    // inner join meal_product on products.id = meal_product.product_id
    // group by products.id
    // order by total_calories desc
    // limit 5
    public function show5HigherCalTotal() {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->select('products.*', DB::raw('SUM(calorie) as total_calories'))
            ->groupBy('products.id')
            ->orderByRaw(DB::raw('SUM(calorie) desc'))
            ->limit(5)
            ->get();
    }
}
