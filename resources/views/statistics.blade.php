@extends('layouts.app')

@section('content')
<h2 class="text-center meal-title">Statistics</h2>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header text-center">Food with higher calories</h5>
                <div class="panel-body">
                    <div class="table table-striped">   
                        <div class="stat-card">
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                @foreach ($productsWith5HigherCal as $product)   
                                    <tr>
                                        <!-- Product Name -->
                                        <td class="table-text" width="250px">
                                            <div>{{ $product->name }}</div>
                                        </td>
                                        <td class="table-text" width="150px">
                                            <div>{{ $product->calorie }} kCal</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <div class="stat-img">
                                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}"/>
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
                <h5 class="card-header text-center">Food with lower calories</h5>
                <div class="panel-body">
                    <div class="table table-striped">   
                        <div class="stat-card">
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                @foreach ($productsWith5LowerCal as $product)   
                                    <tr>
                                        <!-- Product Name -->
                                        <td class="table-text" width="150px">
                                            <div>{{ $product->name }}</div>
                                        </td>
                                        <td class="table-text" width="150px">
                                            <div>{{ $product->calorie }} kCal</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <div class="stat-img">
                                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}"/>
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
                <h5 class="card-header text-center">Food consumed with total higher calories</h5>
                <div class="panel-body">
                    <div class="table table-striped">   
                        <div class="stat-card">
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                @foreach ($productsWith5HigherCalTotal as $product)   
                                    <tr>
                                        <!-- Product Name -->
                                        <td class="table-text" width="150px">
                                            <div>{{ $product->name }}</div>
                                        </td>
                                        <td class="table-text" width="150px">
                                            <div>{{ $product->calorie }} kCal</div>
                                        </td>
                                        <td class="table-text" width="150px">
                                            <div>{{ $product->total_calories }} kCal total</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <div class="stat-img">
                                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}"/>
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
