@extends('layouts.admin')

@section('content')
            <!-- Breadcrumb-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('admin')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Live TV</li>
            </ol>
            <div class="container-fluid">
                <livetv-component></livetv-component>
            </div>

@endsection
