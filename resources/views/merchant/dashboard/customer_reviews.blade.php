@extends('merchant.layouts.app',['merchantid' => $merchantid ?? false])
@section('content')

@livewire("Customer_reviews", ['merchantid' => $merchantid ?? false, 'finalID' => $finalID ?? false])

@endsection
