<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    // 投稿の一覧を表示
    public function show(Request $request){
        // 全ての投稿データを取得
        $posts = Post::with('user', 'postComments')->get();
        // メインカテゴリーとサブカテゴリーのデータを取得
        $categories = MainCategory::get();
        $subCategories = SubCategory::get();
        // Like モデルと Post モデルのインスタンスを作成
        $like = new Like;
        $post_comment = new Post;
        if (!empty($request->keyword)) {
            // キーワード検索の場合の処理
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%' . $request->keyword . '%')
            ->orWhereHas('subCategories', function ($query) use ($request) {
                $query->where('sub_category', 'like', $request->keyword );
            })
            ->orWhere('post', 'like', '%' . $request->keyword . '%')
            ->get();
        } else if($request->category_word){
            // カテゴリー検索の場合の処理
            $subcategory = SubCategory::findOrFail($request->category_word);
            $posts = $subcategory->posts()->with('user', 'postComments')->get();
        } else if($request->like_posts){
             // いいねした投稿を表示する場合の処理
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if($request->my_posts){
            // 自分の投稿を表示する場合の処理
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'subCategories', 'like', 'post_comment'));
    }


    // 投稿の詳細を表示
    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    // 新規投稿フォームを表示
    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    // 新規投稿
    public function postCreate(PostFormRequest $request){
        $request->validate([
            'post_category_id' => 'required', // カテゴリは必須ですが、uniqueルールは削除しました
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ]);
    
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
    
        // リクエストから送信されたカテゴリIDを取得
        $category_id = $request->post_category_id;
    
        // カテゴリがサブカテゴリーであるかどうかを確認
        $category = SubCategory::find($category_id);
        if (!$category) {
            // もしサブカテゴリーが見つからない場合、メインカテゴリーを確認
            $mainCategory = MainCategory::find($category_id);
            if ($mainCategory) {
                // メインカテゴリーが見つかった場合、そのIDを中間テーブルに保存
                $post->subCategories()->attach($mainCategory->id);
            }
        } else {
            // もしサブカテゴリーが見つかった場合、そのIDを中間テーブルに保存
            $post->subCategories()->attach($category->id);
        }
    
        return redirect()->route('post.show', ['id' => $post->id])->with('success', 'Post created successfully');
    }
    

    // 投稿編集
    public function postEdit(Request $request){
        $request -> validate ([
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // 投稿削除
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    // 新規メインカテゴリー
    public function mainCategoryCreate(Request $request){

        $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ]);

        MainCategory::create([
            'main_category' => $request -> main_category_name
        ]);

        return redirect()->route('post.input');
    }

    // サブカテゴリー
    public function subCategoryCreate(Request $request){
        $validatedData = $request->validate([
            'main_category_id' => 'required',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ]);
    
        SubCategory::create([
            'main_category_id' => $validatedData['main_category_id'],
            'sub_category' => $validatedData['sub_category_name']
        ]);
        return redirect()->route('post.input');
    }

    // コメント追加
    public function commentCreate(Request $request){
        // バリエーション
        $request -> validate ([
            'comment' => 'required|string|max:2500',
        ]);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    // 投稿一覧表示
    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    // お気に入り投稿（いいね）
    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    // お気に入り追加
    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    // お気に入り解除
    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
