<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Redirect;
use App\Meal;
use App\Product;
use DB;

class MealController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        //$meals = Meal::all();
        $user = $request->user();
        $meals = $user->meals()->orderBy('date', 'desc')->get();
        $mealsByDate = $meals->groupBy('date');
        $tot_cal_meal = 0;

        $mealsByDateWithCal = [];
        
        foreach ($mealsByDate as $date => $meals) {
            $tot_cal_day = 0;
            foreach ($meals as $meal) {
                $tot_cal_day += $meal->getCalories();
            }
            $mealByDateFinal = new \stdClass; 
            $mealByDateFinal->date = $date;
            $mealByDateFinal->meals = $meals;
            $mealByDateFinal->dayCalories = $tot_cal_day;

            $mealsByDateWithCal[] = $mealByDateFinal;
        } 
        
                
        return view('meal')->with('mealsByDateWithCal', $mealsByDateWithCal);
    }

    /**
     * Show a meal
     */
    public function show($id) {
        $meal = Meal::find($id);
        $products = $meal->products;
        $tot_cal_meal = $meal->getCalories();
        
        return view('product')
                ->with('products', $products)
                ->with('meal', $meal)
                ->with('tot_cal_meal', $tot_cal_meal);
    }

    /**
     * Store a meal
     */
    public function store(Request $request) {

        $rules = [
            'meal' => 'required|string',
            'date' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'meal.required' => 'Please enter a correct type of meal',
            'meal.string' => 'Please enter a correct type of meal',
            'date.required' => 'Please enter a correct date (dd/mm/yyyy)',
            'date.date' => 'Please enter a correct date (dd/mm/yyyy)',
        ]);

        if ($validator->fails()) {
            return redirect('/meal')
                ->withInput()
                ->withErrors($validator);
        }

        $meal = new Meal;

        $meal->type = $request->meal;
        $meal->date = $request->date;

        $meal->save();

        $user = $request->user();
        $user->meals()->attach($meal->id);

        return Redirect::back()->with('success','Meal created successfully!');
    }

    /**
     * Delete a meal
     */
    public function deleteMeal($id, Request $request) {
        $user = $request->user();
        $user->meals()->detach($id);
        Meal::destroy($id);
        return Redirect::back()->with('success','Meal deleted successfully!');
    }

    /**
     * Delete a product
     */
    public function deleteProduct($meal_id, $product_id) {
        $meal = Meal::findOrFail($meal_id);
        //$meal->products()->detach($product_id);
        DB::table($meal->products()->getTable())
            ->where('meal_id', '=', $meal_id)
            ->where('product_id', '=', $product_id)
            ->limit(1)
            ->delete();

        return Redirect::back()->with('success','Food deleted successfully!');
    }
}