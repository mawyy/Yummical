@extends('layouts.app')

@section('content')
<!-- ## Card display Login ## -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary">
                <h5 class="card-header text-center text-white bg-primary">Dashboard</h5>
                               
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="text-welcome">
                        You are logged in!<br><br>
                        You can now add your meals and check the calories consumed per meal and per day.<br>
                        Bon appétit !
                    </div>
                </div>
                @yield('content')
            </div>
        </div>

        <!-- ## Card display Add form ## -->
        <div class="col-md-8">
        @include('flash-message')
            <div class="card">
                <h5 class="card-header text-center bg-info">New meal</h5>
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('errors')
                    
                    <!-- New Meal Form -->
                    <form action="/meal" method="POST" class="form-horizontal">
                        {{ csrf_field() }}           
                        <div class="form-group">
                            <!-- Meal Type -->
                            <label for="meal" class="col-sm-3 control-label">Meal type</label>
                            <div class="col-sm-12">
                                <select id="meal-type" class="form-control" name="meal">
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Lunch">Lunch</option>
                                    <option value="Snack">Snack</option>
                                    <option value="Diner">Diner</option>
                                </select>
                            </div>
                            <!-- Meal Date -->
                            <label for="meal" class="col-sm-3 control-label">Meal date</label>
                            <div class="col-sm-12">
                                <input class="date form-control" type="date" name="date">                
                            </div>
                        </div>

                        <!-- Add Meal Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-primary">Add Meal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ## Card display All meals ## -->
        @if (count($mealsByDateWithCal) > 0)
        <div class="col-md-8">
            <div class="card">
                <div class="panel panel-default">
                    <h5 class="card-header text-center panel-heading bg-info">Current Meals</h5>
                    <div class="panel-body">                        
                            
                        @foreach ($mealsByDateWithCal as $mealByDateWithCal)
                        <div class="day-table border border-secondary">
                            <div class="day-title">
                                <h5>Day {{ $mealByDateWithCal->date }}</h5> 
                                <h6>Total calories of the day: <b>{{ $mealByDateWithCal->dayCalories }} kCal<b></h6>
                            </div>
                            <table class="table table-striped meal-table">
                                <!-- Table Body -->
                                <tbody>
                                
                                @foreach ($mealByDateWithCal->meals as $meal)                          
                                    <tr>
                                        <!-- Meal Name -->
                                        <td width="150px">
                                            <div>{{ $meal->type }}</div>
                                        </td>
                                        <td width="150px">
                                            <div>{{ $meal->getCalories() }} kCal</div>
                                        </td>
                                        <!-- Details -->
                                        <td>
                                            <a href="/meal/{{ $meal->id }}/edit" class="btn btn-outline-primary">
                                                Details
                                            </a>
                                        </td>
                                        <!-- Delete Meal -->
                                        <td>
                                        <form action="{{ url('/meal', ['id' => $meal->id]) }}" method="post">
                                            <input class="btn btn-outline-danger" type="submit" value="Delete Meal" />
                                            <input type="hidden" name="_method" value="delete" />
                                            {!! csrf_field() !!}
                                        </form>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                                
                                </tbody>
                            </table>
                        </div>   
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="/statistics" class="btn btn-success">
                Show my statistics
            </a>
        </div>
        @endif

    </div>
</div>
@endsection

