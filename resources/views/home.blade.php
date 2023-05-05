@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Spendings</h4>
                    <div class="d-flex justify-content-end">
                        <div class="w-25">
                            <select id="spending_year_select" class="form-select form-select-sm" aria-label="Default select example">
                                @foreach ($years as $year)
                                    <option>{{$year['year']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="spendingChart" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function () {
        var spendings = {!! json_encode($spendings_data) !!}
        spendingStats(spendings)

        $('#spending_year_select').on('change', function () {
            let year = $(this).val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ url('home/spending-stat') }}",
                data: {year: year},
                success: function(response) {
                    spendingStats(response)
                },  
                error: function(error) {
                    console.log(error)
                }
            })
        })
    })

    function spendingStats(data) {
        var options = {
            chart: {
                type: 'line',
                foreColor: '#0C6DFD'
            },
            stroke: {
                curve: 'smooth',
            },
            series: [{
                name: 'Spending',
                data: data.data
            }],
            xaxis: {
                categories: data.categories
            }
        }

        if (window.myChart) {
            window.myChart.destroy();
        }

        window.myChart = new ApexCharts(document.querySelector("#spendingChart"), options);
        window.myChart.render();
    }
</script>
@endpush