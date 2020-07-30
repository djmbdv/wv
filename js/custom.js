function percentageToDegrees(percentage) {

  return (percentage / (3600*8))* 360

}
function percentageToDegrees2(percentage) {

  return (percentage / 100)* 360

}


function drawClock(){
  var i = parseInt($('#counter1').attr('data-value'));
   if(i >= 3600*8 -1) i = 3600*8 - 1;
 //  var date = new Date(0);
 // date.setSeconds(i); // specify value for SECONDS here
  //var timeString = date.toISOString().substr(11, 8);
  //$("#counter1-label").text(timeString);

  $(".progress").each(function() {
    var value = $(this).attr('data-value');
    var left = $(this).find('.progress-left .progress-bar');
    var right = $(this).find('.progress-right .progress-bar');
    if(value > 3600*8) value = 0;
    if (value > 0) {
      if (value <= 3600*4) {
        right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)');
        left.css('transform', 'rotate(0deg)');
      } else {
        right.css('transform', 'rotate(180deg)');
        left.css('transform', 'rotate(' + percentageToDegrees(value - 3600*4) + 'deg)');
      }
    }
  });
    $(".progress2").each(function() {
    var value = $(this).attr('data-value');
    var left = $(this).find('.progress-left .progress-bar');
    var right = $(this).find('.progress-right .progress-bar');
    if(value > 100) value = 1;
    if (value > 0) {
      if (value <= 50) {
        right.css('transform', 'rotate(' + percentageToDegrees2(value) + 'deg)');
        left.css('transform', 'rotate(0deg)');
      } else {
        right.css('transform', 'rotate(180deg)');
        left.css('transform', 'rotate(' + percentageToDegrees2(value - 50) + 'deg)');
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

$("#btn-jornada-star").click(e=>{

});