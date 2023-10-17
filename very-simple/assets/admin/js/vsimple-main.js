jQuery(document).ready(function ($) {

    var all_words =  $('input[name="vsimple_settings[all_words]"]'),
    with_numbers =  $('input[name="vsimple_settings[with_numbers]"]');

   all_words.change(function() {
    if (!$(this).prop('checked')) {
      with_numbers.prop('checked', false);
    }
  });
    
      with_numbers.change(function() {
        if ($(this).prop('checked')) {
          if (!all_words.prop('checked')) {
           all_words.prop('checked', true);
          }
        }
      });
});