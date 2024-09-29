<!doctype html>
<html lang="en">

<head>
<title>Smart Water Tank</title>

<style>
.outer{
    border:1px solid grey;
    margin:0%;
    width:100%;
    float:left;
}    

</style>

</head>

<body>


    <div align='center'> 
        <h3>The Coop Monitoring</h3> 
        <p style='font-size:12px;color:grey'>The dashboard displays real time water level in a tank. Tank level is updated every minute on arrival of sensor data from Raspberry Pi. <a href='tank_simulation' target='_blank'>Simulation</a></p>
	<p style='font-size:12px;color:black'>
	  Hatch status: <?php include 'read_hatch_data.php'?>
	</p>
	<p id="demo"></p>
	<script>

	  fetch('https://api.met.no/weatherapi/locationforecast/2.0/complete?lat=63.446827&lon=10.421906&altitude=90')
    .then(res => {
	return res.json();
		 })
    .then(data => {
	var temp = data.properties.timeseries[0].data.instant.details.air_temperature;
	document.getElementById("demo").innerHTML = "Temperature is: " + temp;
    })
    .catch(error => console.log(error));

	  
	</script>
    </div> 
<div align='center'> 
</div> 

<div class='outer'> 

     <div style='width:20%;float:left;margin-left:20%;'> 
        <iframe height='410px' width='100%' src='basic_page/' name='iframe_a'></iframe>
     </div> 

     <div style='width:30%;float:left;margin-left:5%;'> 
         <iframe height='410px' width='100%' src='tank_animation/' name='iframe_a'></iframe>
     </div> 

</div> 
 

<div class='outer'> 
    <div style='width:70%;margin-left:20%;float:left'> 
        <iframe height='420px' width='100%' src='graph/' name='iframe_a'></iframe>
         <p style='margin:1%;color:grey;font-size:12px'>The graph shows the water level readings for a selected date. Y-axis indicates the volume of water in the tank and X-axis denotes hour of the day</p> 
    </div> 
</div> 



</body>
</html>
