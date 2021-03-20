<?php
session_start();
require 'nagad_db.php';

$mobile = $_SESSION['mobile'];
$user_id = $_SESSION['user_id'];
$db=connect_db();

$sql1 = "SELECT name FROM customers WHERE id='$user_id'";
$exe1 = $db->query($sql1);
if($exe1->num_rows>0){
  $results_data = $exe1->fetch_all(MYSQLI_ASSOC);
  $name=$results_data[0]['name'];
  if($name!=""){
    header("Location: stores.php");
    die();
  }
}


$countries = get_country_list($user_id);
$states = get_state_list($user_id,1);
$cities = get_city_list($user_id,1);


if(isset($_POST['cust_name'])){
  $cust_name=$_POST['cust_name'];
  $cust_address=$_POST['cust_address'];
  $country=$_POST['country'];
  $state=$_POST['state'];
  $city=$_POST['city'];
  $pin_code=$_POST['pin_code'];
  $geo_location=$_POST['geo_location'];
  $lat=$_POST['lat'];
  $lon=$_POST['lon'];
  
  if($cust_name==""){
      $message = "Name can not be empty.";
      echo "<script type='text/javascript'>alert('$message');</script>";
  }else if($cust_address==""){
      $message = "Address can not be empty.";
      echo "<script type='text/javascript'>alert('$message');</script>";
  }else{
    $db=connect_db();
    $sql1 = "UPDATE customers SET name='$cust_name',address='$cust_address',country='$country',state='$state',city='$city',pin_code='$pin_code',geo_location='$geo_location',lat='$lat',lon='$lon' WHERE id='$user_id'";
    $exe1 = $db->query($sql1);
    if($exe1==1){
      $sql = "INSERT INTO customer_address(cust_id,address,lat,lon,created_at)"." VALUES('$user_id','$geo_location','$lat',$lon,now())";
      $exe = $db->query($sql);
      header("Location: stores.php");
      die();
    }else{
      $message = "detail not updated";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
}else{
  // $message = "form not submit";
  // echo "<script type='text/javascript'>alert('$message');</script>";
}







function get_city_list($user_id,$state_id){
  $db=connect_db();
  $sql="SELECT id,city_name FROM cities WHERE active='1' && state_id='$state_id'";
  $exe = $db->query($sql);
  $results = $exe->fetch_all(MYSQLI_ASSOC);
  return $results;
}

function get_state_list($user_id,$country_id){
  $db=connect_db();
  $sql="SELECT id,state_name FROM states WHERE active='1' && country_id='$country_id'";
  $exe = $db->query($sql);
  $results = $exe->fetch_all(MYSQLI_ASSOC);
  return $results;
}

function get_country_list($user_id){
  $db=connect_db();
  $sql="SELECT id,country_name FROM countries WHERE active='1'";
  $exe = $db->query($sql);
  $results = $exe->fetch_all(MYSQLI_ASSOC);
  return $results;
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
    <body >

        <!-- The Modal -->
        <div class="modal" id="review2" >
    <div class="modal-dialog mt-per-50">
      <div class="modal-content">
      
        <div class="modal-body">
          <div class="theme-modal">
            <div class="row">
              <div class="col-12 ">
                
                 <div class="dark f-18 mt-2 ">Add to Home Screen</div>
                  <div class="row mt-2">
                    <div class="col-2">
                      <img src="img/home-icon.svg">
                    </div>
                    <div class="col-8">
                      <div class="f-18 dark">Nagad</div>
                      <div class="f-14">www.nagad.in</div>
                    </div>
                  </div>
              </div>

             <hr>
           
            
            </div>
          </div>
        </div>
        <div class="modal-footer" >
         <div class="text-center two-btn" >
           <div class="row dark  ">
             <div class="col-6 br-right">
               <a class="btn btn-transparent text-uppercase font-weight-bold f-14 dark" data-dismiss="modal" aria-label="Close">Cancel</a>
             </div>
             <div class="col-6 ">
               <a href="stores.html" class="btn btn-transparent text-uppercase font-weight-bold f-14 dark" >Add</a>
             </div>
           </div>
         </div>
        </div>
        
      
        
      </div>
    </div>
  </div>


  <div class="modal" id="review">
    <div class="modal-dialog mt-per-50">
      <div class="modal-content">
      
        <div class="modal-body">
          <div class="theme-modal">
            <div class="row">
              <div class="col-12 text-center">
                
                <img src="img/pop_cross.svg " class="modal-cross"  data-dismiss="modal" aria-label="Close">
                 <img src="img/nagad.svg">
                 <div class="dark f-18 mt-2 ">Introducing Nagad App</div>
                 <p class="mt-2 f-14">Add Nagad App to your homescreen to get
 a better shopping experience.</p>
              </div>

              <div class="col-12 text-center">
                <a >
                <button class="btn btn-primary f-13" data-toggle="modal" data-target="#review2"  data-dismiss="modal" aria-label="Close">add to home screen</button>
                </a>
              </div>
            
            </div>
          </div>
        </div>
        
      
        
      </div>
    </div>
  </div>
  
         <!-- title -->
        <div class="page-title text-center">
            Personal Details
            <div class="sub-heading">Enter your Name and Location.<br> 
Let’s Start!</div> 

            
        </div>

        <!-- mid-area -->
        <form action="personal_detail.php" method="post">
        <div >
        <div >
            <div class="text-center">
                <div class="container">
                    <div class="theme-form-second mt-per-14">
                        <form>
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Customer name</label>
                                        <input type="text" name="cust_name" class="form-control" placeholder="Enter Customer Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input id="cust_address" type="text" name="cust_address" class="form-control" placeholder="Street Address">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                    <input id="country" type="text" name="country" class="form-control" placeholder="Country">
                                    </div>
                                </div>

                                  <div class="col-6">
                                    <div class="form-group">
                                    <input id="administrative_area_level_1" type="text" name="state" class="form-control" placeholder="State">
                                    </div>
                                </div>

                                 <div class="col-6">
                                    <div class="form-group">
                                    <input id="locality" type="text" name="city" class="form-control" placeholder="City">
                                </div>
                                </div>

                               
                                 <div class="col-6">
                                    <div class="form-group">
                                      <input id="postal_code" type="text" name="pin_code" class="form-control" placeholder="Zip Code">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Geo location</label>
                                        <img src="img/geo_location.svg" class="geo-icon">
                                        <input id="geolocation" type="text" name="geo_location" class="form-control" placeholder="Pick your Geo Location">

                                        <input id="lat" type="hidden" name="lat">
                                        <input id="lon" type="hidden" name="lon">
                                    </div>

                                   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        
         <!-- footer -->

        <div class="footer-part text-center" >
            <div class="container pb-4">
              <input type="submit" class="btn btn-primary btn-block" value="Save" >
                <!-- <a href="nagad_stores.html" class="btn btn-primary btn-block" data-toggle="modal" data-target="#review"> Save </a> -->
                
            </div>
        </div>
        </div>
      </form>
      

     


       


        
        
        
    
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

// $(document).ready(function(){
//   $("button").click(function(){
//     $("p").slideToggle();
//   });
// });

//initialize();

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

        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
        document.getElementById('cust_address').value = place.formatted_address;
        document.getElementById('lat').value = lat;
        document.getElementById('lon').value = lon;
        // document.getElementById('cityLat').value = place.geometry.location.lat();
        // document.getElementById('cityLng').value = place.geometry.location.lng();
    });
}
google.maps.event.addDomListener(window, 'load', initialize);

        </script>
    </body>
</html>
