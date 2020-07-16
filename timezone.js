$(document).ready(function ()
 {

 var offset = new Date().getTimezoneOffset();

 var timestamp = new Date().getTime();

 var utc_timestamp = timestamp + (60000 * offset);

 $("#submit").click(function (event) 
 {
  $('#utc_timestamp').val(utc_timestamp);
  $('#time_zone_offset').val(offset)
 });

});