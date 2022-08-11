var timeleft = 10;
var downloadTimer = setInterval(function(){
  if(timeleft <= 0){
    clearInterval(downloadTimer);
  }
  document.getElementById("progressBar").value = 10 - timeleft;
  timeleft -= 1;
}, 1000);

var rzp_refresh_time = 10,
    rzp_actual_refresh_time = rzp_refresh_time + 1;