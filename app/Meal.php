<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public function products() {
        return $this->belongsToMany('App\Product');
    }
    
    public function getCalories() {
        $products = $this->products;
        $total_cal = 0;
        foreach ($products as $product) {
            $total_cal += $product->calorie;
        }
        return $total_cal;
    }
}
