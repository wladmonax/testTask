@extends('base')

@section('content')
    <div class="container">
        <div id="app">
            <div class="row bg-white content-block">
                <div class="col">
                    <home :notes="{{json_encode($notes)}}"></home>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')

@endsection
