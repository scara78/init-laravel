@extends('layouts.admin')

@section('content')
            <!-- Breadcrumb-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('admin')}}">Home</a>
                </li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
            <div class="container-fluid">
                <settings-component></settings-component>
            </div>

@endsection
