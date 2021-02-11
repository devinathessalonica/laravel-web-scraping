@extends('template.header-footer')
@section('css-content')
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<link href="{{ asset('assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">PROFILE</h4>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Nama :</th>
                                <th>{{Auth::user()->username}}</th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
@endsection

@section('js-content')
<script src="{{Asset('money/formatUang.js')}}"></script>
<script src="{{Asset('money/keyPressuang.js')}}"></script>
<script src="{{Asset('assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<!-- End plugin js for this page -->
<!-- Custom js for this page-->
<script src="{{asset('js/data-table.js')}}"></script>
<script src="{{Asset('js/dashboard.js')}}"></script>
@endsection