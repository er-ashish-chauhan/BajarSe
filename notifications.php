<?php
session_start();
require 'nagad_db.php';
$db=connect_db();

$sql = "SELECT * FROM notifications";
$exe = $db->query($sql);
$results = $exe->fetch_all(MYSQLI_ASSOC);


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
         <!-- header -->
       <header>
        
           <div class="row no-gutters">
               <div class="col-12 f-20">
                  <a href="nagad_stores.php#menuPage"> <img src="img/back.svg"></a>&nbsp;&nbsp;Notifications
               </div>
           </div>
       </header>

        <!-- mid-area -->

       <div class="page-container">
        <div class="notification-scroll mt-3">
        <!-- <div class="notification-box mt-2">
          <div> <img src="img/pop_cross.svg" class="float-right w4 opacity-1"></div>
          <div class="clearfix"></div>

          <div class="gray f-12">Mar 20, 2020</div>
          <div class="f-14 dark">Grab the Special Discount Offer! Thrive Market</div>
          <div class="f-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
          <img src="img/img-1_square.png" class="full-width opacity-1 mt-1">
        </div> -->

        <?php foreach ($results as $key => $value) { ?>
          
          
         <div class="notification-box">
          <div class=""> <img src="img/pop_cross.svg" class="float-right w4 opacity-1 removeNotification"></div>
          <div class="clearfix"></div>

          <div class="gray f-12"><?php echo $value['created_at']?></div>
          <div class="f-14 dark"><?php echo $value['title']?></div>
          <div class="f-14"><?php echo $value['message']?></div>
        </div>
        
        <?php } ?>
        
        <div class="text-center bottom-tag-notification f-16 dark clear-notification">
          <a href="notifications_2.html">Clear All Notifications</a>
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
        <script src="js/main.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
