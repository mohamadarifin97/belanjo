@extends('layouts.main')
@push('styles')
<style>
    .dataTables_info, .dataTables_length {
        display: none;
    }
    .dataTables_filter {
        text-align: right;
    }
    #DataTables_Table_0_paginate {
        text-align: right;
    }
</style>
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-inline-flex align-items-center">
                        <h4 class="me-2">Monthly Commitment <a href="#" data-bs-toggle="modal" data-bs-target="#addCommitmentModal"><i class="bi bi-plus-square"></i></a></h4>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-3 mt-3">
                        <table class="table table-responsive commitment-table">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Spendings</h4>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('spending_list.store') }}" class="mt-3" method="POST">
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
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCommitmentModal" tabindex="-1" aria-labelledby="addCommitmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addCommitmentModalLabel">Add Commitment</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('commitment.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="commitment" class="form-label">Commitment</label>
                        <input id="commitment" type="text" class="form-control form-control-sm" name="commitment" placeholder="Add commitment">
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">Value</label>
                        <input id="value" type="text" class="form-control form-control-sm" name="value" placeholder="Add value">
                    </div>
                    <h5 class="mt-4">Current Month Source of Income</h5>
                    <div id="div_sourceOfIncome">
                        <div class="row row_sourceOfIncome">
                            <div class="col">
                                <label for="sourceOfIncome" class="form-label">Source of Income</label>
                                <input id="sourceOfIncome" type="text" class="sourceOfIncome form-control form-control-sm" name="sourceOfIncome_arr[0][source_of_income]" placeholder="Add source of income">
                            </div>
                            <div class="col">
                                <label for="valueSOI" class="form-label">Value</label>
                                <input id="valueSOI" type="text" class="value form-control form-control-sm" name="sourceOfIncome_arr[0][value]" placeholder="Add value">
                            </div>
                            <div class="col-1 align-self-end">
                                <h5><a id="test" href="#" onclick="addInput()"><i class="bi bi-plus-circle-fill"></i></a></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#addCommitmentModal').modal('show');
        var table = $('.commitment-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                "paginate": {
                    "previous": '<i class="bi bi-arrow-left me-2"></i>',
                    "next": '<i class="bi bi-arrow-right ms-2"></i>'
                },
                "aria": {
                    "paginate": {
                        "first":    'First',
                        "previous": 'Previous',
                        "next":     'Next',
                        "last":     'Last'
                    }
                }
            },
            ajax: "{{ route('commitment.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'commitment', commitment: 'name', orderable: false},
                {data: 'value', name: 'value', orderable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [],
            aoColumns: [
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false }
            ],
        });
    })

    function addInput() {
        let no_of_input = $('.row_sourceOfIncome').length
        $('#div_sourceOfIncome').append(`
            <div class="row row_sourceOfIncome mt-2">
                <div class="col">
                    <input type="text" class="sourceOfIncome form-control form-control-sm" name="sourceOfIncome_arr[${no_of_input}][source_of_income]" placeholder="Add source of income">
                </div>
                <div class="col">
                    <input type="text" class="value form-control form-control-sm" name="sourceOfIncome_arr[${no_of_input}][value]" placeholder="Add value">
                </div>
                <div class="col-1 align-self-end">
                    <h5><a href="#" onclick="deleteInput(this)"><i class="text-danger bi bi-dash-circle-fill"></i></a></h5>
                </div>
            </div>
        `)
    }

    function deleteInput(element) {
        $(element).parent().parent().parent().remove()

        $("input.sourceOfIncome").each(function(i) {
            if (i > 0) {
                $(this).attr('name', `sourceOfIncome_arr[${i}][source_of_income]`);
            }
        });

        $("input.value").each(function(i) {
            if (i > 0) {
                $(this).attr('name', `sourceOfIncome_arr[${i}][value]`);
            }
        });
    }
</script>
@endpush
<script></script>