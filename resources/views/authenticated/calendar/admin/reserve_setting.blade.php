@extends('layouts.sidebar')
@section('content')
<div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-80 border pt-5 pb-5" style="background-color: #fff; box-shadow: 0 20px 20px rgba(0, 0, 0, 0.16); margin-top: 30px; border-radius: 10px;">
    <p style="font-size: 20px; text-align: center;">{{ $calendar->getTitle() }}</p>
    {!! $calendar->render() !!}
    <div class="adjust-table-btn m-auto text-right">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
@endsection