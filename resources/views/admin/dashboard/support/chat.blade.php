@extends('admin.layouts.app')

@section('content')



@livewire('support-chat', ['support_id' => $ticket->id])





@endsection