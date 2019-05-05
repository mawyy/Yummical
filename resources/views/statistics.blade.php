@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="/meal" class="btn btn btn-dark">
                < Back
            </a>
        </div>
    </div>
</div>
<h2 class="text-center meal-title">Statistics</h2>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header text-center bg-success">Food consumed with higher calories</h5>
                <div class="panel-body">
                    <div class="table table-striped">   
                        <div class="stat-card">
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                    <tr class="table-success">
                                        <th width="250px">Food</th>
                                        <th width="180px">Calories for 100 g/ml</th>
                                        <th></th>
                                    </tr>
                                @foreach ($productsWith5HigherCal as $product)   
                                    <tr>
                                        <!-- Product Name -->
                                        <td class="table-text">
                                            <div>{{ $product->name }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $product->calorie }} kCal</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <div class="stat-img">
                                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}" align="right"/>
                                            <div> 
                                        </td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                        </div>                                  
                    </div>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header text-center bg-success">Food consumed with lower calories</h5>
                <div class="panel-body">
                    <div class="table table-striped">   
                        <div class="stat-card">
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                    <tr class="table-success">
                                        <th width="250px">Food</th>
                                        <th width="180px">Calories for 100 g/ml</th>
                                        <th></th>
                                    </tr>
                                @foreach ($productsWith5LowerCal as $product)   
                                    <tr>
                                        <!-- Product Name -->
                                        <td class="table-text">
                                            <div>{{ $product->name }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $product->calorie }} kCal</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <div class="stat-img">
                                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}" align="right"/>
                                            <div> 
                                        </td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                        </div>                                  
                    </div>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header text-center bg-success">Food consumed with higher total calories</h5>
                <div class="panel-body">
                    <div class="table table-striped">   
                        <div class="stat-card">
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                    <tr class="table-success">
                                        <th class="" width="200px">Food</th>
                                        <th width="180px">Calories for 100 g/ml</th>
                                        <th>Total calories</th>
                                        <th></th>
                                    </tr>
                                @foreach ($productsWith5HigherCalTotal as $product)   
                                    <tr>
                                        <!-- Product Name -->
                                        <td class="table-text">
                                            <div>{{ $product->name }}</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $product->calorie }} kCal</div>
                                        </td>
                                        <td class="table-text">
                                            <div>{{ $product->total_calories }} kCal total</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <div class="stat-img">
                                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}" align="right"/>
                                            <div> 
                                        </td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                        </div>                                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
