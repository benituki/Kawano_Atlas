<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if($category == 'name'){ //条件：$categoryがnameだったら＝カテゴリが名前と選択されていたら
      if(is_null($subjects)){ //条件：$subjectsがnullだったら＝サブジェクトが何も選択されていなければ
        $searchResults = new SelectNames();
      }else{ //条件：それ以外＝サブジェクトが選択されていたら。
        $searchResults = new SelectNameDetails(); //ここが原因
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else if($category == 'id'){ //条件：$categoryがidだったら＝カテゴリが社員IDと選択されていたら
      if(is_null($subjects)){
        $searchResults = new SelectIds();
      }else{
        $searchResults = new SelectIdDetails(); //ここが原因
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else{ //それ以外＝何も選択されていなかったら
      $allUsers = new AllUsers();
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}