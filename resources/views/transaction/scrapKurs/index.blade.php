@extends('template.header-footer')
@section('css-content')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('main-content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Scrap Kurs</h4>
            <div class="form-group">
                <form method="POST" action="{{ url('admin/scrapKurs') }}">
                <div class="container">
                    <div class="row">
                        @csrf
                            <label class="label col-md-3 text-right">Bank</label>
                            <select class="form-control col-md-3" name="bank">
                                <option value="bi">Bank Indonesia</option>
                                <option value="bca">BCA</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-danger">Go</button>
                            {{-- <button type="button" class="btn btn-sm btn-info">View</button> --}}
                    </div>
                </div>
                
            </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js-content')
<script src="{{Asset('assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{ asset('js/transaction/kursRate/index.js') }}"></script>
@endsection