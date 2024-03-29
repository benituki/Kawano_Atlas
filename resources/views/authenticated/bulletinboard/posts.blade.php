@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="user_names"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p class="post_title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="sub_category_look">
        @foreach($post->subcategories as $subcategory)
        {{ $subcategory->sub_category }}
        @endforeach
      </div>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post->commentCount() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0">
                <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
                <span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span>
            </p>
            @else
            <p class="m-0">
                <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
                <span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span>
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class="post_input"><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="keyword">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">

    {{-- サブカテゴリーの検索をするためにbladeから値を送る必要がある。 --}}
    <p>カテゴリー検索</p>
    <ul>
      @foreach($categories as $category)
      <li class="main_categories" category_id="{{ $category->id }}">
        <div class="mein_category_text">
          <span>{{ $category->main_category }}</span>
          <span class="toggle_arrow">∨</span>
        </div>
        <ul style="display: none;">

          @foreach($category->subcategories as $subcategory)
          <li class="sub_category" category_id="{{ $subcategory->id }}">
            <a href="{{ route('post.show', ['category_word' => $subcategory->id]) }}">
              <div class="sub_category_text">
                {{ $subcategory->sub_category }}
              </div>
            </a>
          </li>
          @endforeach

        </ul>
      </li>
      @endforeach
    </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection