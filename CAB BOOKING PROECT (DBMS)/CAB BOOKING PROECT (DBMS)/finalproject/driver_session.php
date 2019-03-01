<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";
$conn = mysqli_connect($servername, $username, $password, $dbname);
   session_start();
   $driver_check = $_SESSION['login_driver'];
   $driver_id = $_SESSION['login_id'];
   $up="UPDATE drivers set D_status='ON' ,Available='YES' where D_name='$driver_check'";
if(mysqli_query($conn, $up)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $up. " . mysqli_error($link);
}
   if(!isset($_SESSION['login_driver'])){
      header("location:head.php");
   }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" href="geolocation.css" />
</head>
<body>




<!-- Start of first page -->
<div data-role="page" id="homePage">
<?php include("dheader.php") ?>
<div role="main" class="ui-content">
		<p>Geolocation Page</p>
		<div id="geoLocation">geoLocation
	    
		</div>
		<form action="update.php" method="post">
		<input type="text" value="" placeholder="your location" name="d_location" id="location" required/>
		<input type='text' id="longitude" value="" name="longitude" required/>
		<input type='text' id="latitude"  value="" name="latitude" required/>
		<input type="submit" value="submit location">
		</form>
	</div><!-- /content -->
</div><!-- /page -->




<!-- Start of second page -->
<div data-role="page" id="mapPage">

<?php include("dheader.php") ?>

	<div role="main" class="ui-content">
	<div id="map-canvas">map-canvas</div>
	</div><!-- /content -->
</div><!-- /page -->





<!-- Start of second part B page -->






<!-- Start of third page -->

<div data-role="page" id="passenger">

	<?php include("dheader.php")?>
	<?php
$in="SELECT * from travel_history where Driver_id=$driver_id && Status='pending' || Status='running'";
$result = $conn->query($in);

if ($result->num_rows > 0) 

{
	echo "<h1>YOU HAVE TO TAKE.... </h1>";
	echo "<table><tr><th>ID </th><th> CUSTOMER_NAME</th><th>FROM</th><th> TO</th><th>  FARE </th><th>EARNING</th><th>STATUS</th></tr>";
while($row = $result->fetch_assoc()) 
	{
	echo "<h1>".$row["Tourist_name"]."<h1>";
     echo "<tr><td>    &nbsp".$row["Travel_no"]." </td><td>  &nbsp    ".$row["Tourist_name"]." </td><td>   ".$row["Starting_point"]." </td> <td>   ".$row["Destination"]." </td><td>      ".$row["Fare"]."</td><td>          ".$row["Dsalary"]."</td><td>" .$row["Status"]. "</td></tr>";
	}
	echo "</table>";
}

else {
    echo "<h1>NO CUSTOMERs found</h1>";
}
	?>


<?php
	if(isset($_POST['cancel']))
{
$update2="DELETE from travel_history where Status='pending' and Driver_id=$driver_id";
if(mysqli_query($conn,$update2))
{

} else {
    echo "ERROR: Could not able to execute $update2. " . mysqli_error($link);
}
header("location:driver_session.php");  
}
	?>
	<?php
	if(isset($_POST['confirm']))
{
$update2="update travel_history set Status='running' where Status='pending' and Driver_id=$driver_id";
$update3="UPDATE drivers set Available='NO' where  id=$driver_id";
//$query_run=mysqli_query($conn,$update3);
if(mysqli_query($conn,$update3))
{
echo"hellsdsds";
} else {
    echo "ERROR: Could not able to execute $update2. " . mysqli_error($update3);
}
if(mysqli_query($conn,$update2)){
	 $sql3="SELECT * from travel_history where Driver_id=$driver_id && Status='running'";
$result = $conn->query($sql3);
if ($result->num_rows > 0) 
{
	echo "<h1>YOU HAVE TO TAKE.... </h1>";
	echo "<table><tr><th>ID </th><th> CUSTOMER_NAME</th><th>FROM</th><th> TO</th><th>  FARE </th><th>EARNING</th><th>STATUS</th></tr>";
while($row = $result->fetch_assoc()) 
	{
	echo "<h1>".$row["Tourist_name"]."<h1>";
     echo "<tr><td>    &nbsp".$row["Travel_no"]." </td><td>  &nbsp    ".$row["Tourist_name"]." </td><td>   ".$row["Starting_point"]." </td> <td>   ".$row["Destination"]." </td><td>      ".$row["Fare"]."</td><td>          ".$row["Dsalary"]."</td><td><h3>CATCH THE TOURIST</h3></td></tr>";
	}
	echo "</table>";
}
} else {
    echo "ERROR: Could not able to execute $update2. " . mysqli_error($link);
}
//header("location:driver_session.php");  
}
	?>
	


<table border="0" cellpadding="0" cellspacing="3">
<tr>
    <td>
	<form action="" method="post">
<input type="submit" name="confirm" value="CONFIRM BOOKING"/>
<input type="submit" name="cancel" value="CANCEL BOOKING"/>
	  Source:
        <input type="text" id="txtSource" name="frompoint" value="" placeholder="ENTER SOURCE"  style="width: 500px" />
        Destination:
        <input type="text" id="txtDestination" name="end" value="" placeholder="ENTER DESTINATION" style="width: 500px" />
        <br />
		<hr>
		DISTANCE:<input type="text" id="dvDistance" value="" name="distance" placeholder="Estimate Distance" style="width:300px" />
        DURATION:<input type="text" id="dvDuration" value="" placeholder="Estimate Duration" style="width:300px" />
        EXPECTED FARE<input type="text" id="fare" name="fare" value="" placeholder="Estimate Fare" style="width:300px" />
	  	<button onclick="GetRoute()" required/>CHECK ROUTE</button>
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
</tr>
</table>	
	
<!-- /content -->
</div><!-- /page -->



<!-- fourth page--->
<div data-role="page" id="account">
<?php include("dheader.php") ?>

<div role="main" class="ui-content">
<div id="utk"><h2>ACCOUNT HISTORY</h2>
<?php
$query = "SELECT * FROM travel_history where Driver_id=$driver_id";
$query_run = mysqli_query($conn,$query);
$qty= 0;
while ($num = mysqli_fetch_assoc ($query_run)) {
    $qty += $num["Fare"];
}
echo "<b><h1>COMPANY's TOTAL EARNING BY YOUR SERVICE</h1></b>";
echo $qty;

?>
<h3>TO SEE CURRENT BOOKING STATUS CLICK tO REFRESH<h3>
<button onclick="window.location.reload();">LAST BOOKING STATUS</button>

<?php
$in="SELECT * from travel_history where Driver_id=$driver_id";
$result = $conn->query($in);
if ($result->num_rows > 0) 
{echo "<table><tr><th>ID </th><th> CUSTOMER_NAME</th><th>FROM</th><th> TO</th><th>  FARE </th><th>EARNING</th><th>STATUS</th></tr>";
while($row = $result->fetch_assoc()) 
	{
     echo "<tr><td>    &nbsp".$row["Travel_no"]." </td><td>  &nbsp    ".$row["Tourist_name"]." </td><td>   ".$row["Starting_point"]." </td> <td>   ".$row["Destination"]." </td><td>      ".$row["Fare"]."</td><td>          ".$row["Dsalary"]."</td><td>" .$row["Status"]. "</td></tr>";
	}
	echo "</table>";
}
else {
    echo "no earning found";
}
	?>
	<?php
$query = "SELECT * FROM travel_history where Driver_id=$driver_id";
$query_run = mysqli_query($conn,$query);
$qty= 0;
while ($num = mysqli_fetch_assoc ($query_run)) {
    $qty += $num["Dsalary"];
}
echo "<b>YOUR TOTAL EARNING  IS </b>";
echo $qty;

?>
</div>

	</div><!-- /content -->

	
</div><!-- /page -->
<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
   <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTZea67jn4YSPIGu0dNTHRyB1jnvo1Q00"></script>
 <!--<script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>-->
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript">
	function myFunction() {
  var a=confirm("ARE YOU SURE WANT it to  EXIT");
	if(a==true)
	{
		window.location.assign("d_logout.php")
	}
	}
	
	//geolocationPage
var x = document.getElementById("geoLocation");
//function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
//}
function showPosition(position) {
	var longi=document.getElementById("longitude");
	var latti=document.getElementById("latitude");
	//alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude);
     latti.value= position.coords.latitude ; 
    longi.value=position.coords.longitude;
	
	var l=document.getElementById("txtSource");
	var l1=document.getElementById("location");
	
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
			
			l1.value  = data.results[0].address_components[4].long_name+",";
			l1.value += data.results[0].address_components[1].long_name+",";
			l1.value += data.results[0].address_components[2].long_name+",";
			l1.value += data.results[0].address_components[3].long_name+",";
			l1.value += data.results[2].address_components[5].long_name+",";
			l1.value += data.results[0].address_components[5].long_name+",";
			l1.value += data.results[0].address_components[6].long_name;
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