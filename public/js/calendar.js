$(function(){
    // モーダルを開く処理
    $('.js-modal-open').on('click', function(){
        $('.js-modal').fadeIn();
        var setting_reserve = $(this).attr('value');
        var setting_part = $(this).attr('part');
    
        $('.modal-inner-setting').text('予約日：' + setting_reserve);
        $('.modal-inner-part').text('予約時間：リモ' + setting_part + '部');

        // 情報を出力する。（予約時間は数字）
        $('.date-cancel').val(setting_reserve);
        $('.time-cancel').val(setting_part);
        return false;
    });
    
});

