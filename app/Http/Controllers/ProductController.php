<?php

namespace App\Http\Controllers;

use Request;
use Validator;
use Redirect;
use App\Meal;
use App\Product;
use DB;
use Builder;
use Model;


class ProductController extends Controller
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

    /**
     * Store a product
     */
    public function store($id) {

        $value = request::all();
        $meal = Meal::findOrFail($id);

        $rules = [
            'code' => 'required|string',
        ];

        $validator = Validator::make($value, $rules, [
            'code.required' => 'Please enter a correct code',
            'code.string' => 'Please enter a correct code',
        ]);

        if ($validator->fails()) {
            return redirect::back()
                ->withInput()
                ->withErrors($validator);
        }

        $url = 'https://fr.openfoodfacts.org/api/v0/produit/' . $value['code'] .'.json';
        $data = json_decode(file_get_contents($url), true);

        if( !empty($data['product']['product_name'])){
            $product = new Product;

            $product->name = $data['product']['product_name'];

            $product->code = $data['code'];

            $product->url = (isset ($data['product']['image_url'])) ? $data['product']['image_url'] : "";

            if (isset ($data['product']['nutriments']['energy_value'])) {
                if ($data['product']['nutriments']['energy_unit'] == 'kJ') {
                    $product->calorie = ($data['product']['nutriments']['energy_value']) / 4.184;
                } else {
                    $product->calorie = $data['product']['nutriments']['energy_value'];
                }
            } else {
                $product->calorie = 0;
            }
        }
        
        if (Product::where('code', $value['code'])->first()) {
            return Redirect::back()->with('success','Product added successfully!');
        } else {
            $product->save();
            $meal->products()->attach($product->id);
        }
        
        return Redirect::back()->with('success','Product added successfully!');
    }
}
