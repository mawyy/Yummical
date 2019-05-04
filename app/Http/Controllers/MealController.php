<?php

namespace App\Http\Controllers;

use Request;
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

    public function index() {
        //$meals = Meal::all();
        $meals = Meal::orderBy('date', 'asc')->get();
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

        $value = request::all();

        $rules = [
            'meal' => 'required|string',
            'date' => 'required|date',
        ];

        $validator = Validator::make($value, $rules, [
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

        $meal->type = $value['meal'];
        $meal->date = $value['date'];

        $meal->save();

        return Redirect::back()->with('success','Meal created successfully!');
    }

    /**
     * Edit a meal
     */
    public function edit($id) {

    }

    /**
     * Delete a meal
     */
    public function delete($id) {
        Meal::destroy($id);

        return Redirect::back()->with('success','Meal deleted successfully!');
    }
}