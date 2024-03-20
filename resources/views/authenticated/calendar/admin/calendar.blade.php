@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto">
  <div class="w-100 border pt-5 pb-5" style="background-color: #fff; box-shadow: 0 20px 20px rgba(0, 0, 0, 0.16); margin-top: 30px;">
    <p style="font-size: 20px; text-align: center;">{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection