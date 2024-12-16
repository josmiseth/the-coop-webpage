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
  <div style='width:5%;float:left;margin-left:20%;'>
	<p style='font-size:12px;color:black'>
	  Hatch status: <?php include 'read_hatch_data.php'?>
	</p>
    <canvas id="coopCanvas" width="200" height="200"></canvas>
    <script>
      // Fetch the hatch state from the PHP script
        fetch('read_hatch_status.php')
            .then(response => response.text())
            .then(data => {
                const action = data.trim().toUpperCase() === "OPEN" ? 1 : 0; // OPEN -> 1, CLOSED -> 0

                // Call the function to animate based on the fetched action state
                startAnimation(action);
            });

        function startAnimation(action) {
            const canvas = document.getElementById("coopCanvas");
            const ctx = canvas.getContext("2d");

            // Configuration for the coop
            const openingSize = 50; // Size of the square opening
            const hatchSize = openingSize + 10; // Hatch is slightly larger than the opening
            const animationDuration = 10000; // 10 seconds in milliseconds

            const coopBottomMargin = 25; // Distance from the canvas bottom to the bottom of the coop
            const coopHeight = 150; // Height of the brown coop
            const openingBottomMargin = 5; // Distance between the opening and the bottom of the coop
            const openingY = canvas.height - coopBottomMargin - openingSize - openingBottomMargin; // Y position of the opening

            // Pulley position (fixed)
            const pulleyY = 25;

            // Hatch movement positions
            const hatchStartY = pulleyY + 70; // Hatch starts just below the pulley
            const hatchEndY = openingY + openingSize; // Hatch ends with the lower edge covering the opening

            let currentHatchY = action === 1 ? hatchEndY : hatchStartY; // Initial hatch position
            let startTime = null;

            function drawCoop(hatchLowerY) {
                const canvasWidth = canvas.width;
                const canvasHeight = canvas.height;

                // Clear canvas
                ctx.clearRect(0, 0, canvasWidth, canvasHeight);

                // Coop frame
                ctx.fillStyle = "#8B4513";
                ctx.fillRect(50, 25, 100, coopHeight); // Coop box (scaled down)

                // Square opening near the bottom
                ctx.fillStyle = "#8B0000";
                ctx.fillRect(75, openingY, openingSize, openingSize); // Draw the opening

                // Hatch (dynamic, quadratic, slightly larger than the opening)
                const hatchX = 75 - 5; // Center the hatch over the opening
                const hatchY = hatchLowerY - hatchSize; // The top edge of the hatch
                ctx.fillStyle = "#D3D3D3";
                ctx.fillRect(hatchX, hatchY, hatchSize, hatchSize); // Quadratic hatch

                // Pulley system (fixed position)
                ctx.fillStyle = "#000";
                ctx.beginPath();
                ctx.arc(100, pulleyY, 5, 0, 2 * Math.PI); // Pulley (scaled down)
                ctx.fill();

                // Wire
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(100, pulleyY); // Pulley center
                ctx.lineTo(100, hatchLowerY - hatchSize / 2); // Wire to the center of the hatch
                ctx.stroke();
            }

            function animateHatch(timestamp) {
                if (!startTime) startTime = timestamp; // Record start time
                const elapsed = timestamp - startTime;

                // Calculate new position based on action
                const progress = Math.min(elapsed / animationDuration, 1); // Limit progress to 1

                if (action === 1) {
                    // Opening the hatch (move upwards to reveal the opening)
                    currentHatchY = hatchEndY - progress * (hatchEndY - hatchStartY);
                } else {
                    // Closing the hatch (move downwards to cover the opening)
                    currentHatchY = hatchStartY + progress * (hatchEndY - hatchStartY);
                }

                // Ensure the hatch doesn't go above the pulley
                currentHatchY = Math.max(currentHatchY, pulleyY + 5);

                // Draw the updated hatch position
                drawCoop(currentHatchY);

                // Continue animation if not yet finished
                if (progress < 1) {
                    requestAnimationFrame(animateHatch);
                }
            }

            // Start the animation
            requestAnimationFrame(animateHatch);
        }
    </script>



  </div>
     <div style='width:10%;float:left;margin-left:20%;'> 
        <iframe height='410px' width='100%' src='basic_page/' name='iframe_a'></iframe>
     </div> 

     <div style='width:20%;float:left;margin-left:5%;'> 
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
