<?php
session_start();
require 'nagad_db.php';
$db=connect_db();
$user_id=0;

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  header("Location: verify_mobile.php");
  die();
}

if(isset($_POST['address'])){
    $address=$_POST['address'];
    $area=$_POST['area'];
    $house_no=$_POST['house_no'];
    $landmark=$_POST['landmark'];
    $lat=$_POST['lat'];
    $lon=$_POST['lon'];

    $sql = "INSERT INTO customer_address(cust_id,house_no,address,area,landmark,lat,lon,created_at)"." VALUES('$user_id','$house_no','$address','$area','$landmark','$lat','$lon',now())";
    $exe = $db->query($sql);
    $addr_id = $db->insert_id;
    if(!empty($addr_id)){
        $message = "New address inserted.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Location: stores.php");
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>My Project</title>
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.12.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>

    
    <body class="gray-bg">
         <!-- address-map -->
         <div >
         <div class="header-overlay" style="position: absolute;">
           <!-- <a  onClick="history.go(-1); return false;" ><img src="img/back.png"></a> -->
          
         </div>
        <img src="img/map.png" class="full-width " style="display: none;">
        
        <!-- mid-part -->
        <div class="page-container">
          <div class="mt-3">
          <div class="section-heading"> <a href="stores.php"><img src="img/back.png"></a> &nbsp;Set Delivery Location</div>
          </div>

          <div class="theme-form-second lightplaceholder mt-per-5 ">
                        <form action="add_new_address.php#khataPage" method="post">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Location</label>
                                       
                                        <input id="geolocation" name="address" type="text" name="" class="form-control pb-0" placeholder="Enter your Location">
                                        <input id="lat" type="hidden" name="lat">
                                        <input id="lon" type="hidden" name="lon">
                                            
                                        
                                    </div>

                                    <div class="form-group">
                                        <input name="area" type="text" name="" class="form-control pb-0" placeholder="Enter your Area">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input name="house_no" type="text" name="" class="form-control pb-0" placeholder="House / Flat / Block No.">
                                    </div>
                                </div>

                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <input name="landmark" type="text" name="" class="form-control pb-0" placeholder="Landmark">
                                    </div>
                                </div>

                                 <div class=" col-md-12 text-center">
                                    <!-- <button class="btn btn-blue font-weight-bold">Enter Address</button> -->
                                    <input type="submit" class="btn btn-blue font-weight-bold" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
        </div>

        </div>
        
    
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
        <script src="assets/mail/jqBootstrapValidation.js"></script>
        <script src="assets/mail/contact_me.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApafGQtuvWaTvvHUCdFoGrcRgnsin4n2M&libraries=places"></script>

        <script type="text/javascript">

const componentForm = {
  locality: "long_name",
  administrative_area_level_1: "long_name",
  country: "long_name",
  postal_code: "short_name",
};

function initialize() {
  var input = document.getElementById('geolocation');
  var options = {
  types: ['geocode'],
  componentRestrictions: {country: 'IN'}
};
  var autocomplete = new google.maps.places.Autocomplete(input,options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lon = place.geometry.location.lng();
        console.log(place.address_components);
        //document.getElementById('cust_address').value = place.formatted_address;
        document.getElementById('lat').value = lat;
        document.getElementById('lon').value = lon;
    });
}
google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    </body>
</html>
