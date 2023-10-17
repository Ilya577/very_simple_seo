jQuery(document).ready(function ($) {

   
  var panel = $('.vsimple_panel');
  var toggleButton = panel.find('.toggle-button');

  let isResizing = false;
  let initialHeight;
  
  toggleButton.on("mousedown", function(e) {
    isResizing = true;
    initialHeight = e.clientY;
    toggleButton.css("cursor", "grabbing"); // Изменяем вид курсора при начале перетаскивания
  });
  
  $(document).on("mousemove", function(e) {
    if (isResizing) {
      const currentHeight = e.clientY;
      const heightDifference = currentHeight - initialHeight;
      const newHeight = $(".panel-content").height() - heightDifference;
      
      // Устанавливаем новую высоту блока
      $(".panel-content").css("height", newHeight);
      $(".panel_block").css("height", newHeight - 105);
      initialHeight = currentHeight;
    }
  });
  
  $(document).on("mouseup", function() {
    isResizing = false;
    toggleButton.css("cursor", "grab"); // Возвращаем стандартный вид курсора
  });
    
});