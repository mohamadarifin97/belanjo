@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
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
                            <label for="monthYear" class="form-label">Month and Yeara</label>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="spendingChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        var spendings = {!! json_encode($spendings_data) !!}

        var options = {
            chart: {
                type: 'line'
            },
            stroke: {
                curve: 'smooth',
            },
            series: [{
                name: 'Spending',
                data: spendings.data
            }],
            xaxis: {
                categories: spendings.categories
            }
        }

        var chart = new ApexCharts(document.querySelector("#spendingChart"), options).render();
    </script>
@endpush