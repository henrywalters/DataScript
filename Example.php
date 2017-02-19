<?php

include 'datascript.php';

?>

<script
			  src="https://code.jquery.com/jquery-3.1.1.js"
			  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
			  crossorigin="anonymous"></script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<html>

<div id='dataTable' style="float:left">

</div>

Cell 1: if (<input type='text' id='rand1'>) <br>
Cell 2: if (<input type='text' id='rand2'>) <br>
<button onClick='filter()'>Filter</button>
<div id="slider-range" style="width:40%;float:center"></div>

<div id='dataTable2' style="float:right">

</div>
</html>

<script>
function getRandomInt(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min)) + min;
}

var s_data = [];
var root_note = ['a','b','c','d','e','f','g'];
var mod = ['','#','f'];


for (var i = 0; i < 500; i++){
	s_data.push([root_note[getRandomInt(0,7)],getRandomInt(0,20)]);
}
var s_headers = ['ROOT NOTE', 'MODIFIER'];
const data = new Data(s_data,s_headers);
data.get_raw_filter_options();

$(document).ready(function(){
	var filters = data.get_raw_filter_options();
	var max = Math.max.apply(null, filters['MODIFIER']);
	var min = Math.min.apply(null, filters['MODIFIER']);
	console.log(min,max);

    $( "#slider-range" ).slider({
      range: true,
      min: min,
      max: max,
      values: [ min, max ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        	data.set_header_filters([],true);
        	console.log(ui.values[0],ui.values[1]);
			data.set_filters({'MODIFIER':{'condition':'raw-condition', 'variables': 'cell > ' + ui.values[0] + ' && cell < ' + ui.values[1] }});
			data.filter_data();
			$('#dataTable2').html(data.table('test','1'));

      }
    });
     $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );

	filter();
});


function filter(){
	//const data = new Data(s_data,s_headers);
	$('#dataTable').html(data.raw_table('test','1'));
	var r1 = $('#rand1').val();
	var r2 = $('#rand2').val();
	var r1 = ((r1) ? r1 : true);
	var r2 = ((r2) ? r2 : true);
	data.set_header_filters([],true);
}



</script>
