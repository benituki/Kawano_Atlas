<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    public function showUsers(Request $request){
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = $request->subject;

        // ユーザークエリを初期化する
        $usersQuery = User::query();

        // 科目が選択されている場合、OR条件で検索条件に追加する
        if (!empty($subjects)) {
            $usersQuery->whereHas('subjects', function ($query) use ($subjects) {
                $query->whereIn('subjects.id', $subjects); // 'subjects.id' を指定して明示的にテーブルを指定する
            });
        }
        // ユーザーを取得する
        $users = $usersQuery->get();

        // 科目一覧を取得する
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}