@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Spendings</h4>
                    <div class="d-flex justify-content-end">
                        <div class="w-25 me-2">
                            <select id="spending_show_select" onchange="spendingFilter()" class="form-select form-select-sm" aria-label="Spending show filter">
                                <option value="">Show</option>
                                <option value="6">6</option>
                                <option value="12">12</option>
                                <option value="48">48</option>
                                <option value="36">36</option>
                                <option value="all">All</option>
                            </select>
                        </div>
                        <div class="w-25">
                            <select id="spending_year_select" onchange="spendingFilter()" class="form-select form-select-sm" aria-label="Spending year filter">
                                <option value="">Years</option>
                                @foreach ($years as $year)
                                    <option value="{{$year['year']}}">{{$year['year']}}</option>
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

        $('#spending_year_select, #spending_show_select').css('color','gray');
        $('#spending_year_select, #spending_show_select').on('change', function () {
            let year = $(this).val()

            if (year == '') {
                $(this).css('color','gray');
            } else {
                $(this).css('color','white');
            }
        })
    })

    function spendingFilter() {
        let year = $('#spending_year_select').val()
        let show = $('#spending_show_select').val()

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ url('home/spending-stat') }}",
            data: {year: year, show: show},
            success: function(response) {
                spendingStats(response)
            },  
            error: function(error) {
                console.log(error)
            }
        })
    }

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

        if (window.spendingchart) {
            window.spendingchart.destroy();
        }

        window.spendingchart = new ApexCharts(document.querySelector("#spendingChart"), options);
        window.spendingchart.render();
    }
</script>
@endpush