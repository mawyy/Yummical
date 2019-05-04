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

    private function show5HigherCal() {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->orderBy('calorie', 'desc')
            ->select('products.*')
            ->limit(5)
            ->distinct()
            ->get();
    }

    private function show5LowerCal() {
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
    private function show5HigherCalTotal() {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->select('products.*', DB::raw('SUM(calorie) as total_calories'))
            ->groupBy('products.id')
            ->orderByRaw(DB::raw('SUM(calorie) desc'))
            ->limit(5)
            ->get();
    }

    public function statistics() {
        $show5HigherCal = $this->show5HigherCal();
        $show5LowerCal = $this->show5LowerCal();
        $show5HigherCalTotal = $this->show5HigherCalTotal();

        return view('statistics')
            ->with('productsWith5HigherCal', $show5HigherCal)
            ->with('productsWith5LowerCal', $show5LowerCal)
            ->with('productsWith5HigherCalTotal', $show5HigherCalTotal);

    }
}
