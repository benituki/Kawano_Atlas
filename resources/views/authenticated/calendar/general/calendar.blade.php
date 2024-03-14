@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
{{-- モーダルウィンドウ開始 --}}
<!-- 編集用の画面風フォーム -->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form id="account_form" action="{{ route('deleteParts') }}" method="POST">
      <div class="w-100">
        <div class="modal-inner-setting w-50 m-auto">
          <p class="reservation_date">予約日：</p>
          <input type="hidden" class="date-cancel" name="getData" value="" form="reserveParts">
        </div>
        <div class="modal-inner-part w-50 m-auto pt-3 pb-3">
          <p class="reservation_time">予約時間：</p>
          <input type="hidden" class="time-cancel" name="getPart" value="" form="reserveParts">
        </div>
        <div class="w-50 m-auto">
          <p>上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block " href="#">閉じる</a>
          <button type="submit" class="btn btn-primary d-block">キャンセル</button>
        </div>
      </div>
      @csrf
    </form>
  </div>
</div>
{{-- モーダルウィンドウ終わり --}}
@endsection