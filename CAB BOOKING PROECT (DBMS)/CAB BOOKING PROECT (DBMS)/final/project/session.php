<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";
$conn = mysqli_connect($servername, $username, $password, $dbname);
   session_start();
  $user_check = $_SESSION['login_user'];
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" href="geolocation.css" />
</head>
<body>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>



<!-- Start of first page -->
<div data-role="page" id="homePage">
<?php include("header.php") ?>
<div role="main" class="ui-content">
		<p>Geolocation Page</p>
		<div id="geoLocation">geoLocation</div>
		<button id="getGeolocation" onclick="getLocation()">get geolocation</button>
	</div><!-- /content -->
</div><!-- /page -->




<!-- Start of second page -->
<div data-role="page" id="mapPage">

<?php include("header.php") ?>

	<div role="main" class="ui-content">
	<div id="map-canvas">map-canvas</div>
	</div><!-- /content -->
</div><!-- /page -->





<!-- Start of second part B page -->






<!-- Start of third page -->

<div data-role="page" id="directionsPage">

	<?php include("header.php") ?>

	<div role="main" class="ui-content">
	<table border="0" cellpadding="0" cellspacing="3">
<tr>
    <td>
	<button onclick="GetRoute()" required/>CHECK ROUTE</button>
	<button onclick="getLocation()" required/>MY LOCATION</button>
	
	<form action="abc.php" method="post">
        Source:
        <input type="text" id="txtSource" name="frompoint" value="" placeholder="ENTER SOURCE"  style="width: 500px" />
        Destination:
        <input type="text" id="txtDestination" name="end" value="" placeholder="ENTER DESTINATION" style="width: 500px" />
        <br />
		<hr>
		DISTANCE:<input type="text" id="dvDistance" value="" name="distance" placeholder="Estimate Distance" style="width:300px" />
        DURATION:<input type="text" id="dvDuration" value="" placeholder="Estimate Duration" style="width:300px" />
        EXPECTED FARE<input type="text" id="fare" name="fare" value="4" placeholder="Estimate Fare" style="width:300px" />
	  	<a href="#search">see drivers</a>
		<input type="text"  placeholder="PLEASE SELECT SUITABLE DRIVER ACCORDING TO YOUR CONVIENECE" name="driverid" id="id"  value="" required/>

		<input type="submit" value="TAKE A DRIVE"  required/>
 </form>
         <hr />
    </td>
     <td>
        <div id="dvMap" style="width: 800px; height: 500px">
        </div>
    </td>
	</tr>
	<tr>
    <td>
	<div id="dvPanel" style="width: 500px; height: 500px"></div>
    </td>
	<td>
	<div id="search">
	<h1>DRIVERS LIST</h1>
<?php
$ins="SELECT * from drivers where D_status='On' && Current='Stop'";
$result = $conn->query($ins);
if ($result->num_rows > 0) 
{echo "<table><tr><th>ID </th><th> DRIVER NAME</th><th> EMAIL</th><th> PHONE</th><th> STATUS </th><th> CURRENT LOCATION</th></tr>";
while($row = $result->fetch_assoc()) 
	{
     echo "<tr><td>    &nbsp".$row["id"]." </td><td>  &nbsp    ".$row["D_name"]." </td><td>   ".$row["D_email"]." </td> <td>   ".$row["D_phone"]." </td><td>      ".$row["D_status"]."</td><td>          " .$row["D_location"]. "</td></tr>";
	}
	echo "</table>";
}
else {
    echo "<h2>SORRY !!! NO DRIVERS FOUND</h2>";
}
?>
</div>
</td>

</tr>

</table>

</div>
    <br />
	
	</div>
	</div><!-- /content -->
</div><!-- /page -->



<!-- fourth page--->
<div data-role="page" id="history">
<?php include("header.php") ?>

<div role="main" class="ui-content">
<div id="utk"><h2>ACCOUNT HISTORY</h2>
<h3>TO SEE CURRENT BOOKING STATUS CLICK tO REFRESH<h3>
<button onclick="window.location.reload();">LAST BOOKING STATUS</button>
	
</div>
<?php
$sql = "SELECT * FROM travel_history where Tourist_name ='$user_check'";
$result = $conn->query($sql);
if ($result->num_rows > 0) 
{echo "<table><tr><th> STARTING </th><th> DESTINATION </th><th> FARE</th><th>DRIVER_ID</th><th>     STATUS</th></tr>";
while($row = $result->fetch_assoc()) 
	{
     echo "<tr><td>".$row["Starting_point"]." </td><td>".$row["Destination"]." </td><td> ".$row["Fare"]." </td> <td> ".$row["Driver_id"]." </td><td>      ".$row["Status"]."</td></tr>";
	}
	echo "</table>";
}
else {
    echo "<------HAVEN'T BOOK ANY RIDE BOOK NOW ------>";
}
$conn->close();
?>
<form action="update_status.php" method="post">
<input type="submit" value="location achieved"/>
</form>
	</div><!-- /content -->

	
</div><!-- /page -->


<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTZea67jn4YSPIGu0dNTHRyB1jnvo1Q00"></script>
 <!--<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>-->
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript">
	function myFunction() {
  var a=confirm("ARE YOU SURE WANT TI EXIT");
	if(a==true)
	{
		window.location.assign("logout.php")
	}
	}
	
	//geolocationPage
var x = document.getElementById("geoLocation");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
	//alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
	var l=document.getElementById("txtSource");
	locAPI = "http://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true";
    // x.innerHTML = locAPI;
	$.get({
		url : locAPI,
		success:function(data){
			console.log(data);
			l.value  = data.results[0].address_components[4].long_name+",";
			l.value += data.results[0].address_components[1].long_name+",";
			l.value += data.results[0].address_components[2].long_name+",";
			l.value += data.results[0].address_components[3].long_name+",";
			l.value += data.results[2].address_components[5].long_name+",";
			l.value += data.results[0].address_components[5].long_name+",";
			l.value += data.results[0].address_components[6].long_name;
			}
		});
}

$(document).on('click', '#getGeolocation', function(){
    console.log("clicked");
    getLocation();
});

//map page



var y = document.getElementById("map-canvas");
var mapLatitude;
var mapLongitude;
var myLatlng;

function getMapLocation() {
	console.log("getMapLocation");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showMapPosition);
    } else {
        y.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showMapPosition(position) {
	console.log("showMapPosition");
    mapLatitude = position.coords.latitude;
    mapLongitude = position.coords.longitude;
    myLatlng = new google.maps.LatLng(mapLatitude,mapLongitude);
    getMap();
}


var map;
function getMap() {
	console.log("getMap");
  var mapOptions = {
    zoom: 12,
    center: new google.maps.LatLng(mapLatitude, mapLongitude)
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

	var marker = new google.maps.Marker({
	    position: myLatlng,
	    map: map,
	    title:"You are here!"
	});
}

$( document ).on( "pageshow", "#mapPage", function( event ) {
  getMapLocation();
});

//distance Page


var source;
var destination;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
google.maps.event.addDomListener(window, 'load', function () {
    new google.maps.places.SearchBox(document.getElementById('txtSource'));
    new google.maps.places.SearchBox(document.getElementById('txtDestination'));
    directionsDisplay = new google.maps.DirectionsRenderer({ 'draggable': true });
});
 
function GetRoute() {
	console.log("hi");
    var mumbai = new google.maps.LatLng(18.9750, 72.8258);
    var mapOptions = {
        zoom: 7,
        center: mumbai
    };
    map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('dvPanel'));
 
    //*********DIRECTIONS AND ROUTE**********************//

    source = document.getElementById("txtSource").value;
    destination = document.getElementById("txtDestination").value;
 
    var request = {
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
 
    //*********DISTANCE AND DURATION**********************//
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [source],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
            var distance = response.rows[0].elements[0].distance.text;
            var duration = response.rows[0].elements[0].duration.text;
            var dvDistance = document.getElementById("dvDistance");
			var dvDuration = document.getElementById("dvDuration");
			var dvFare = document.getElementById("fare");
			
            dvDistance.value = distance ;
            dvDuration.value =  duration;
			dvFare.value =  parseFloat(distance)*4;
			
             
        } else {
            alert("Unable to find the distance via road.");
        }
    });
}
</script>
</body>
</html>