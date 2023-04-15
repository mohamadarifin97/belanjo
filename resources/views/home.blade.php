@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
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