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
                <h5 class="modal-title" id="addCommitmentModalLabel">Add Commitment</h5>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
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
</script>
@endpush
<script></script>