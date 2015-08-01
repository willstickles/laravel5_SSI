@extends('app')

@section('content')

    <div class="row">
        @if (isset($TempHum))
            <h1>Hello World - {{ $TempHum->Sensor_Err }}</h1>
            @else
            <h2>Nothing to see here.</h2>
        @endif
    </div>

@stop