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

    // SELECT distinct products.*
    // FROM `products` 
    // inner join meal_product on products.id = meal_product.product_id
    // inner join meal_user on meal_user.meal_id = meal_product.meal_id
    // where meal_user.user_id = 1
    // order by calorie desc

    private function show5HigherCal($user) {
        
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->join('meal_user', 'meal_user.meal_id', '=', 'meal_product.meal_id')
            ->where('meal_user.user_id', '=', $user->id )
            ->orderBy('calorie', 'desc')
            ->select('products.*')
            ->limit(5)
            ->distinct()
            ->get();
    }

    private function show5LowerCal($user) {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->join('meal_user', 'meal_user.meal_id', '=', 'meal_product.meal_id')
            ->where('meal_user.user_id', '=', $user->id )
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
    private function show5HigherCalTotal($user) {
        return Product::join('meal_product', 'products.id', '=', 'meal_product.product_id')
            ->join('meal_user', 'meal_user.meal_id', '=', 'meal_product.meal_id')
            ->where('meal_user.user_id', '=', $user->id )
            ->select('products.*', DB::raw('SUM(calorie) as total_calories'))
            ->groupBy('products.id')
            ->orderByRaw(DB::raw('SUM(calorie) desc'))
            ->limit(5)
            ->get();
    }

    public function statistics(Request $request) {
        $user = $request->user();
        $show5HigherCal = $this->show5HigherCal($user);
        $show5LowerCal = $this->show5LowerCal($user);
        $show5HigherCalTotal = $this->show5HigherCalTotal($user);

        return view('statistics')
            ->with('productsWith5HigherCal', $show5HigherCal)
            ->with('productsWith5LowerCal', $show5LowerCal)
            ->with('productsWith5HigherCalTotal', $show5HigherCalTotal);

    }
}
