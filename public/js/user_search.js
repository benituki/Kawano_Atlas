$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $(this).find('.toggle_arrow').text(function(_, text) {
      return text === '∨' ? '∧' : '∨';
    });
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
  });
});
