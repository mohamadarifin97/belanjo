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

                    <form action="{{ route('spending_list.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Add commitment">
                            </div>
                            <div class="col-auto">
                                <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1" placeholder="Add value">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection