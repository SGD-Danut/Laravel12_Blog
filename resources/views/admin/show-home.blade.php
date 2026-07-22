@extends('admin.template.master-page')

@section('head-title', $title)

@section('big-title', $title)

@section('content')
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $title }}</h5>
    </div>
    <div class="card-body">
        <p class="card-text">Bine ați venit în secțiunea de admin!</p>
    </div>
@endsection