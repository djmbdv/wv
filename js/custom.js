function percentageToDegrees(percentage) {

  return (percentage / 60)* 360

}

function drawClock(){
  var i = parseInt($('#counter1').attr('data-value'));
   if(i == 60) i = 0;

  $("#counter1-label").text(i);

  $(".progress").each(function() {
    var value = $(this).attr('data-value');
    var left = $(this).find('.progress-left .progress-bar');
    var right = $(this).find('.progress-right .progress-bar');
    if(value > 100) value = 0;
    if (value > 0) {
      if (value <= 30) {
        right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)');
        left.css('transform', 'rotate(0deg)');
      } else {
        right.css('transform', 'rotate(180deg)');
        left.css('transform', 'rotate(' + percentageToDegrees(value - 30) + 'deg)');
      }
    }
  });
  $('#counter1').attr('data-value',i+1);
}

$(drawClock);
var i = setInterval(drawClock, 1000);

function stop(){
  clearInterval(i);
}