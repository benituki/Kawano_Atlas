$(function(){
    // モーダルを開く処理
    $('.js-modal-open').on('click', function(){
        $('.js-modal').fadeIn();
        var setting_reserve = $(this).attr('value');
        var setting_part = $(this).attr('part');
    
        $('.modal-inner-setting').text('予約日：' + setting_reserve);
        $('.modal-inner-part').text('予約時間：リモ' + setting_part + '部');
    
        // 追加：予約日と予約時間をフォームに追加
        $('#account_form').append('<input type="hidden" name="setting_reserve" value="' + setting_reserve + '">');
        $('#account_form').append('<input type="hidden" name="setting_part" value="' + setting_part + '">');
    
        // キャンセル用フォームの値を設定
        $('.date-cancel').val(setting_reserve);
        $('.time-cancel').val(setting_part);
        return false;
    });
    
    
});

