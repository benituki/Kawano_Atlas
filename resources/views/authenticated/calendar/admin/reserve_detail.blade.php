@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        <tr class="text-center">
          <!-- 予約した人の情報を表示 -->
            @foreach ($reservePersons as $reservePerson)
                @foreach ($reservePerson->users as $user)
                    <tr class="text-center">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->over_name }} {{ $user->under_name }}</td>
                        <td>リモート</td>
                    </tr>
                @endforeach
            @endforeach
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection