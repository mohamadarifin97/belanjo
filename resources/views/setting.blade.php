@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Monthly Commitment</h4>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mb-3 mt-3">
                        <div class="col-md-6 ps-5">
                            <p>Zakat</p>
                        </div>
                        <div class="col-md-6">
                            <p>RM 70</p>
                        </div>
                    </div>

                    <form action="{{ route('commitment.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm" name="commitment" placeholder="Add commitment">
                            </div>
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm" name="value" placeholder="Add value">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('spending_list.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="monthYear" class="form-label">Month and Years</label>
                            <select class="form-select form-select-sm" name="month_year" id="monthYear" aria-label="Month and year">
                                @foreach ($months_years as $month_year)
                                    <option value="{{$month_year['month']}} - {{$month_year['year']}}">{{$month_year['month_name']}}, {{$month_year['year']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="spendingList" class="form-label">Spending List</label>
                            <textarea class="form-control fomr-control-sm" id="spendingList" name="spending_list" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection