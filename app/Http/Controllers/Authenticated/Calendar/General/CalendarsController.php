<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        // トランザクションを開始（情報の更新）
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            
            // array_filterはコールバック、array_combineは配列の結合
            // 日付と時間を結合、一致しているかの確認。
            // 上記を$reserveDaysに格納。
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            
            // 日付から時間を連想する。（予約した日時）
            foreach($reserveDays as $key => $value){
                // ReserveSettings内にあるカラムから情報を得る。（条件が明確なときは whereが便利）
                // ログインユーザーが予約している日時を取得。（first()のため単体結果。）
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)
                ->where('setting_part', $value)
                ->first();

                // decrement(デクメント)はプロパティを指定。つまり、予約する時間の指定
                // 予約人数（limit_usersカラム）を減らす
                $reserve_settings->decrement('limit_users');

                // attachは中間テーブルにデータを挿入できる。（ログインユーザーのID）
                $reserve_settings->users()->attach(Auth::id());
            }
            // 全てが計画通りだった場合。
            DB::commit();
        }catch(\Exception $e){
            // 変更または操作を取り消す場合。
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
        $getPart = $request->input('setting_part');
        $getDate = $request->input('setting_reserve');
        // dd($getPart, $getDate);
        $reserve_settings = ReserveSettings::where('setting_reserve', $getDate)
        ->where('setting_part', $getPart)
        ->first();
        
        $reserve_settings->increment('limit_users');
        $reserve_settings->users()->detach(Auth::id());
        
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
