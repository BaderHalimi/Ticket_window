@extends('merchant.layouts.app', ["merchant" => $merchantid ?? false])
@section('content')
    @include('merchant.dashboard.offers.product_show')
@endsection
