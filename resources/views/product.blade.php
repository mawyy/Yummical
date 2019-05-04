@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="/meal" class="btn btn btn-info">
                < Back
            </a>
        </div>
    </div>
</div>
<h2 class="text-center meal-title">{{ $meal->type }} of the {{ $meal->date }}</h2>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header text-center">Add new food</h5>
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('errors')
                    @include('flash-message')
                    
                    <!-- New Product Form -->
                    <form method="POST" class="form-horizontal">
                        {{ csrf_field() }}           
                        <div class="form-group">
                            <!-- Product Code -->
                            <label for="meal" class="col-sm-3 control-label">Code Product</label>
                            <div class="col-sm-12">
                                <input class="code form-control" type="number" name="code">                
                            </div>
                        </div>

                        <!-- Add Meal Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-info">Add Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
        @if (count($products) > 0)
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header text-center">Food of the {{ $meal->type }} (<b>{{ $tot_cal_meal }} kcal total</b>)</h5>
                <div class="panel-body">
                    <div class="table table-striped">
                        <!-- Food of the Meal -->                            
                        @foreach ($products as $product)                                
                        <!-- Food Name -->
                        <div class="food-card">
                            <div class="food-img">
                                <img src="{{ $product->url }}" alt="{{ $product->name }}" title="{{ $product->name }}" height="100px"/>
                            </div>
                            <div class="food-name"> {{ $product->name }} </div>
                            <div>
                                <form action="{{ url('/meal', ['meal_id' => $meal->id, 'product_id' => $product->id]) }}" method="post">
                                    <input class="btn btn-outline-danger" type="submit" value="Delete Food" />
                                    <input type="hidden" name="_method" value="delete" />
                                    {!! csrf_field() !!}
                                </form>
                            </div>
                        </div>                                
                        @endforeach                            
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

