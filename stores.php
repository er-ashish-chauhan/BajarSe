<?php
session_start();
require 'nagad_db.php';
$db=connect_db();

$name="";
$address="";
$referral_code="";
if(isset($_SESSION['mobile'])){
  $mobile = $_SESSION['mobile'];
}else{
  header("Location: verify_mobile.php");
  die();
}
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT * FROM customers WHERE id=$user_id";
  $exe = $db->query($sql);
  $results = $exe->fetch_all(MYSQLI_ASSOC);
  $name = $results[0]['name'];
  $address = $results[0]['address'];
  $referral_code = $results[0]['referral_code'];
}


$sql1 = "SELECT shop_setting.id,shop_setting.business_name,shop_setting.tagline,shop_setting.category,shop_setting.shop_type,shop_setting.shop_image,shop_setting.shop_cover_image,shop_setting.payment_type,shop_setting.delivery_mode,shop_setting.delivery_free,shop_setting.delivery_charge,shop_setting.min_order_value,shop_setting.max_delivery_distance,shop_setting.delivery_time,shop_setting.active_status,shop_setting.address,shop_setting.mobile,cust_fav_stores.id as fav FROM shop_setting LEFT JOIN cust_fav_stores ON (shop_setting.id=cust_fav_stores.shop_id && cust_fav_stores.cust_id='$user_id') WHERE shop_setting.active_status=1 && shop_setting.approve_status=1";
$exe1 = $db->query($sql1);
$results_data = $exe1->fetch_all(MYSQLI_ASSOC);
//print_r($results_data);



$sql_categories = "SELECT * FROM shop_categories WHERE status=1";
$exe_categories = $db->query($sql_categories);
$results_categories = $exe_categories->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Bajarse</title>
        <!-- <link rel="manifest" href="manifest.webmanifest" /> -->
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.12.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/bootstrap-slider.css" rel="stylesheet" />
    </head>

 <style>
   .showBox{
    padding:5px;
    background-color: green;
    color:white;

   }
   .pac-container {
      z-index: 1051 !important;
  }
 </style>

    <body class="gray-bg">
         <!-- header -->
<!-- add more address -->
<div class="modal fade" id="moreAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute;
    right: 5px;
    top: 5px;">
          <span aria-hidden="true">&times;</span>
        </button>
      
      <div class="modal-body p5-all">
        <div>
         <div class="header-overlay" style="position: absolute;">
           <!-- <a  onClick="history.go(-1); return false;" ><img src="img/back.png"></a> -->
           <a href="stores.php" style="display:none;"><img src="img/back.png"></a>
         </div>
        <img src="img/map.png" class="full-width">
        
        <!-- mid-part -->
        <div >
          <div class="mt-3">
          <div class="section-heading">Set Delivery Location</div>
          </div>

          <div class="theme-form-second lightplaceholder mt-per-5 ">
                        <form >
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Location</label>
                                       
                                        <!-- <textarea name="address" class="form-control" id="search_geoLocation" placeholder="Enter your Location"></textarea> -->
                                        <input type="text" name="address" class="form-control" id="search_geoLocation" placeholder="Enter your Location">
                                            
                                        
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
                                    <input type="submit" class="btn btn-blue font-weight-bold" value="Submit" data-dismiss="modal">
                                </div>
                            </div>
                        </form>
                    </div>
        </div>

        </div>
      </div>
    
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choose a Delivery Address</h5>
        <button type="button" class="close opacity-1" data-dismiss="modal" aria-label="Close">
          <img src="img/pop_cross.svg">
        </button>
      </div>
      <div class="modal-body pop-scroll" >
        <div class="divider"></div>
         <a href="add_new_address.php" >
                 <div class="app-section pl-22px mt-2px ">
                   <img src="img/plus_border.svg " class="mt-5-neg">&nbsp;&nbsp;&nbsp;<span class=" font-weight-bold text-green f-16">Add New Address</span>
                 </div>
          </a>

          <div id="cust_other_locations">
            <!-- <div class="divider"></div>
            <div class="app-section pl-20px">
              <div class="row no-gutters">
                    <div class="col-1 my-auto">
                      <img src="img/location_border.svg">&nbsp;&nbsp;&nbsp;
                    </div>
                    <div class="col-10">
                       <span class="font-15 dark">Craig Park Layout</span>
                     <div class="f-14">802, Craig Park Layout, Silverlake Terrace..</div>
                     <div class="time">2 hrs</div>
                    </div>
                  </div>
            </div> -->
          </div>
          

         <!-- <div class="divider"></div>
          <div class="app-section pl-20px" >
            <div class="row no-gutters">
                  <div class="col-1 my-auto">
                    <img src="img/location_border.svg">&nbsp;&nbsp;&nbsp;
                  </div>
                  <div class="col-10">
                     <span class="font-15 dark">Craig Park Layout</span>
                   <div class="f-14">802, Craig Park Layout, Silverlake Terrace..</div>
                   <div class="time">2 hrs</div>
                  </div>
                </div>
          </div> -->
           <!-- <div class="divider"></div>
          <div class="app-section pl-20px">
            <div class="row no-gutters">
                  <div class="col-1 my-auto">
                    <img src="img/location_border.svg">&nbsp;&nbsp;&nbsp;
                  </div>
                  <div class="col-10">
                     <span class="font-15 dark">Craig Park Layout</span>
                   <div class="f-14">802, Craig Park Layout, Silverlake Terrace..</div>
                   <div class="time">2 hrs</div>
                  </div>
                </div>
          </div> -->
      </div>
      
    </div>
  </div>
</div>




<div class="modal fade" id="shopFilterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header pb-0">
        <h5 class="modal-title" id="exampleModalLabel">Filters</h5>
        <div class="text-uppercase f-10 text-right dark mt-12" id="clearAll" onclick="clearFilter();">Clear All</div>
        <img src="img/pop_cross.svg" class="cross-pop" data-dismiss="modal" aria-label="Close">
        <button type="button" class="close opacity-1" data-dismiss="modal" aria-label="Close" style="display:none;">
          <img src="img/pop_cross.svg">
        </button>
      </div>
      <div class="modal-body">

        
        <div class="divider"></div>
          <div class="row ">
            <div class="col-md-12 mt-1" >
              <div class="form-group">
                <label>Delivery Mode</label>
                <div class="mt-2 f-14 dark">
                  <span><input id="radio_home_filter" type="radio" name="delivery_mode_filter" value="1" ></span>&nbsp;&nbsp;Home Delivery &nbsp;&nbsp;
                  <input id="radio_pickup_filter" type="radio" name="delivery_mode_filter" value="2">&nbsp;&nbsp;Pickup&nbsp;&nbsp;
                  <input id="delivery_filter_both" type="radio" name="delivery_mode_filter" value="3" checked>&nbsp;&nbsp;Both
                </div>
              </div>

              <div class="form-group">
                <label>Payment mode</label>
                <div class="mt-2 f-14 dark">
                  <input id="radio_cod_filter" type="radio"  name="payment_mode_filter" value="1" >&nbsp;&nbsp;Cash on Delivery&nbsp;&nbsp;
                  <input id="radio_online_filter" type="radio" name="payment_mode_filter" value="2">&nbsp;&nbsp;Online&nbsp;&nbsp;
                  <input id="shop_payment_both_filter" type="radio" name="payment_mode_filter" value="3" checked>&nbsp;&nbsp;Both
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Delivery area</label>
                <input id="ex2" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="10000" data-slider-step="1" data-slider-value="10000" style="width:100%"/>
                <select id="distance_filter" class="form-control"  style="display: none">
                    <option value="0">No select</option>
                    <option value="5">5 Kilometer</option>
                    <option value="10">10 Kilometer</option>
                    <option value="15">15 Kilometer</option>
                    <option value="20">20 Kilometer</option>
                    <option value="25">25 Kilometer</option>
                </select>
              </div>

              <div class="form-group">
                <label>Minimum Delivery Charges</label>
                <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="1000" data-slider-step="1" data-slider-value="100000" style="width:100%"/>

                <select id="delivery_charge_filter" class="form-control" style="display: none">
                    <option value="0">Free</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                </select>
              </div>

              <div class="form-group">
                <label>Shop Category</label>
                <select id="shop_category_filter" class="form-control">
                  <option value="all">All</option>
                  <?php foreach ($results_categories as $key => $value) { ?>
                    <option value="<?php echo $value['category'];?>"><?php echo $value['category'];?></option>
                    <?php } ?>
                    
                </select>
              </div>

              <div class="form-group">
                <label>Shop Type</label>
                <select id="shop_type_filter" class="form-control">
                  <option value="all">All</option>
                  <option value="1">Retailer</option>
                  <option value="2">Wholesaler</option>
                </select>
              </div>
            </div>

            <div class="col-md-12 text-center">
                <a href="#" class="btn btn-blue p-l-r-50 mt-2 font-weight-bold" onclick="filter_shop();"> Save </a>
            </div>
          </div>

          
          

      </div>
      
    </div>
  </div>
</div>


   

  <div class="tab-content">
    <div id="homePage" class=" tab-pane active">




      <!-- catalog detail page -->

      <div id="catalogdetailSection" style=" display: none ; padding-bottom: 100px;" >
       <header>

           <div class="header-upper">
            <div class="row no-gutters">
                <div class="col-12 f-20">
                   <a  id="backCatelogTab"><img src="img/back.svg" > </a>Catalog Details
               </div>
              
               </div>
           </div>
         
       </header>


       <!-- Offer info -->
       <div  class="page-container ">
       <div class="product-detail">
          <div class="name">
            <label>Catalog name</label>
            <div id="catalog_detail_name" class="value">Maggie Noodles</div>
          </div>

          <div class="product-info">
                 <h4>catalog details</h4>
            <p id="catalog_detail_description"></p>
          </div>


          <div class="last-date" style="display:none;">
             Offer Valid till <b >18/05/2020</b>
          </div>
          <div class="last-date">
            No. of products: <b><span id="catalog_detail_num_products"></span></b>
          </div>
       </div>

       </div>

       <div class="page-container ">
       <div class="secction-heading mt-3">Products in this Catalog</div>
       
       <!-- product-list -->
       <div id="catalog_product_list" class="product-list">
          

         <!-- <div class="theme-card card-cd">
               <div class="row no-gutters">

           <div class="col-2">
             <img src="img/product-1.png" class="full-width">
           </div>
           <div class="col-6">
               <div class="title">Maggie Noodles</div>
               <div class="offer-product-price"><del>Rs.8.00</del> <span class="price">Rs.48.00</span></div>
               <div class="qty">200 ml Pepsi Can</div>
           </div>
           <div class="col-4 my-auto pr-10px">
             <a href="" class="btn-blue btn-block">Add To Cart</a>
           </div>
         </div>
         </div> -->

         
       </div>

       </div>

       </div>
   



     

    <!-- offer detail page -->

      <div id="OfferdetailSection" style="display: none; padding-bottom: 100px;">
       <header>

           <div class="header-upper">
            <div class="row no-gutters">
                <div class="col-12 f-20">
                   <a  id="backOfferTab"><img src="img/back.svg" ></a> Offer Details
               </div>
              
               </div>
           </div>
         
       </header>


       <!-- Offer info -->
       <div class="page-container">
       <div class="product-detail">
          <div class="name">
            <label>Offer name</label>
            <div id="offer_details_name" class="value">Maggie Noodles</div>
          </div>

          <div class="product-info">
                 <h4>Offer details</h4>
            <p id="offer_details_description"></p>
          </div>


          <div class="last-date">
             Offer Valid till <b><span id="offer_detail_end_date"></span></b>
          </div>
          <div class="last-date">
            No. of products: <b><span id="offer_detail_num_products"></span></b>
          </div>
       </div>
       </div>

       <div class="page-container ">
       <div class="secction-heading mt-3">Products in this Offer</div>
       
       <!-- product-list -->
       <div id="offer_products_list" class="product-list">
          

         <!-- <div class="theme-card">
               <div class="row no-gutters">

           <div class="col-2">
             <img src="img/product-1.png" class="full-width">
           </div>
           <div class="col-6">
               <div class="title">Maggie Noodles</div>
               <div class="offer-product-price"><span class="outer"><span class="inner">Rs.60.00</span></span> <span class="price">Rs.48.00</span></div>
               <div class="qty">200 ml Pepsi Can</div>
           </div>
           <div class="col-4 my-auto  pr-10px">
             <a href="" class="btn-blue btn-block ">Add To Cart</a>
           </div>
         </div>
         </div> -->

       </div>

       </div>
</div>

      
      <!-- shop listing -->

       <div id="productDetailSection" style="display: none; padding-bottom: 100px;">
       <header>

           <div class="header-upper">
            <div class="row no-gutters">
              <a  id="backProductTab"><img src="img/back.svg" ></a>&nbsp;
                <div class="col-8 f-20">
                     <div id="product_name_detail_header"></div>
               </div>
              
               </div>
           </div>
         
       </header>

<!-- product img -->

<div class="product-img"> 
 <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
  <a href="https://web.whatsapp.com/send?text=<?php echo $actual_link; ?>" target="_blank"><img src="img/share_circle.png" class="share-circle"></a>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div>
          <div id="product_detail_image_selected">
            <!-- <img src="img/product-1.png" class="w-40"> -->
          </div>
        </div>
    <div>
    <ul id="product_detail_images_ul" class="product-thumbnail">
      <!-- <li class="active">
        <a >
          <img src="img/product-F.png">
        </a>
      </li> -->
      <!-- <li>
        <a href="">
          <img src="img/product-L.png">
        </a>
      </li>
      <li>
        <a href="">
          <img src="img/product-R.png">
        </a>
      </li> -->
      <!-- <div style="clear:both"></div> -->

    </ul>
    </div>
    </div>



</div>










<div class="">
<div class="product-detail text-left">
  <div class="name">
    <label>Product name</label>
    <div id="product_name_detail" class="value f-16"></div>
  </div>

  <div class="product-price">
   <div ><span class="outer"><span id="product_detail_price" class="inner"></span></span></div>
   <div id="product_detail_buying_price" class="price font-weight-bold"></div>
  </div>

  <div class="product-info">
    <h4>Product details</h4>
    <p id="product_detail_description"></p>
  </div>

  <div class="last-date">
    Offer Valid till <b><span id="product_detail_end_date"></span></b>
  </div>
  
  <div class="row btn-area">
  <div class="col-6 pr-5px" style="display:none;">
     <div class="increase-product float-left" >
       <span class="minus t-11" id="minus">-</span><span class="plus t-11" id="plus">+</span>
      <input id="product_detail_quantity" type="" name="" class="increase qtyProduct qty-padding" value="1" >
     </div>
  </div>
  <div id="product_detail_add_cart" class="col-6 my-auto pl-5px" style="padding-left: 25px;" >
    <!-- <a  class=" btn-blue btn-block add-cart-padding font-weight-bold">
      Add TO Cart
    </a> -->
  </div>
</div>
</div>
</div>

</div>
</div>

</div>






       <div id="ShopSection" style="display: none; padding-bottom: 100px;">
       <header>

           <div class="header-upper">
            <div class="row no-gutters">
              <a id="backstoreList"><img src="img/back.svg"></a>
                <div id="shop_name" class="col-7 f-20">
                   Shop Name
               </div>
                <div class="col-4 ">
                   <div class="text-uppercase text-right ">
                      <!-- <a href="#" onclick="shareText();"> -->
                      <a href="#" class="share_link">
                      	<img src="img/share.svg" class="pr-10">
                      </a>
                      <a class="shop_call" ><img src="img/call.svg" class="pr-10"></a>
                      <a class="shop_whatsapp" href="https://api.whatsapp.com/send?phone=918860087716"><img src="img/whatsapp.svg"></a>
                       
                   </div>
               </div>
               </div>
           </div>
          <!-- shop-image -->
          <div class="shop-image">
           <!-- <img src="img/img-1.png" class="full-width"> -->
           </div>
           

           <div class="row no-gutters"> 
            <div class="col-md-12">
              <div class="search-box-container-2 ">
              <img src="img/search.svg" class="input-icon-l mt-neg-1">
                 <input type="text" name="products-search" class="search-box" id="products-search" placeholder="Search Products Or Catalog for Offer"> 
                  <img src="img/mic.svg" class="input-icon-r mt-neg-1" style="display: none">
              </div>
              </div>
           </div>
       </header>

       


<div class="">
  <div class="shop-tabs">
  
  <!-- Nav tabs -->
  <ul class="nav nav-tabs " role="tablist" id="pageHeaderShop" >
    <li class="nav-item ">
      <a class="nav-link active" data-toggle="tab" href="#products">Products</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " data-toggle="tab" href="#offers">offers</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " data-toggle="tab" href="#catalogs">catalogs</a>
    </li>
  </ul>

  

  

  <!-- Tab panes -->
  <div class="tab-content mt-3">
    
    <div id="products" class="container tab-pane active tab-container">
    <span id="product_list_title"></span>
        <!-- <a class="goProductDetail">
       <div class="theme-card">
        <div class="container">
           <div class="row">
             <div class="col-7">
               <h3>Maggie Noodles</h3>
               <b>Get 20% off on 70gm </b>
               <div ><span class="outer"><span class="inner">Rs.500</span></span><span class="price">Rs.400</span></div>
               <div class="row">
                <div class="col-12 ">
                <div class="mt-2">
             <img src="img/share_liner.svg" class="float-left mt-2">
             <div class="btn btn-border addQty ml-12" >Add</div>
                  <div class="increase-product float-left" style="display: none;">
                  <span class="minus" id="minus">-</span><span class="plus" id="plus">+</span>
                  <input type="" name="" class="increase qtyProduct" value="1" >
                 </div>




                 <div class="clearfix"></div>
           </div>
           </div>
           </div>
             </div>
             <div class="col-5">
               <img src="img/product-1.png">
             </div>
           </div>
           </div>

       </div>
       </a> -->

 
    </div>


    <div id="offers" class="container tab-pane  fade tab-container">


      <span id="offer_list_title"></span>
      
      <div id="offersSection" > 

      <!-- <img src="img/like_blank.svg" alt="like" class="like_blank likeThis" >
    <div class="goOfferDetail" >
       <div class="theme-card">
         <div class="container">
             <div class="row">
               <div ></div>
               <div class="col-7 pr-0">
                 <h3>Maggie Noodlesssss</h3>
                 <b>Get 20% off on 70gm </b>
                 <div class="last-date">Offer End Date: 28-06-2020</div>
                  <div>
                <img src="img/share_liner.svg" class="float-left mt-2">
               <a class="btn btn-border addQty ml-12"  style="display: none">Add</a>
                    <div class="increase-product float-left" style="display: none;">
                    <span class="minus" id="minus">-</span><span class="plus" id="plus">+</span>
                    <input type="" name="" class="increase qtyProduct" value="1" >
                   </div>
             </div>
               </div>
               <div class="col-5">
                 <img src="img/product-1.png" >
               </div>
             </div>
           </div>

         </div>

         </div> -->
     
     
       </div>
    </div>
    <div id="catalogs" class="container tab-pane fade tab-container">
   <span id="catalog_list_title"></span>
   <div class="catalogSection">
 <!-- <img src="img/like_blank.svg" alt="like" class="like_blank likeThis">
   <a class="gocatalogDetail">
     <div >
      <div class="theme-card">
        <div class="container">
           <div class="row">
            
             <div class="col-7 pr-0">
               <h3 class="f-16">Grocery Items</h3>
               <b>Get 20% off on the Maggie 70gm pack. Hurry offer... </b>
               <div class="qty-catalogs">60 Products</div>
                <div>
             <img src="img/share_liner.svg">
             
           </div>
             </div>
             <div class="col-5">
               <img src="img/product-1.png" >
             </div>
           </div>
           </div>

       </div>



     </div>

       </a> -->
 
 

     </div>
    </div>
  </div>
  </div>
</div>
</div>


    <!-- stores listing -->
      <div id="storesList" class="pb-80">
         <header id="pageHeader">

           <div class="header-upper">
            <div class="row no-gutters">
                <div class="col-8 ">
                   BajarSe
               </div>
                <div class="col-4 ">
                   <div class="text-uppercase text-right ">
                      <a href="notifications.php" > <img src="img/notification.svg" ></a>
                   </div>
               </div>
               </div>
           </div>
           <div class="row no-gutters mt-9" >
               <div class="col-7">
                   <div class="text-uppercase f-12"><img src="img/location.svg" class="mt-neg-5">&nbsp;&nbsp;
                    <span id="current_address_header"></span></div>
               </div>
                <div class="col-5 align-self-center">
                   <div id="change_location" onclick="changeLocation();" class="text-uppercase f-10 text-right"><img src="img/change_location.svg">&nbsp;&nbsp;change location</div>
               </div>
               <div id="div_search_location" class=" f-14 dark w-100 " style="display: none;">
                <img src="img/search.svg" class="geo-search ">
                  <input id="search_geolocation" type="text" name="geo_location" class="geo-location" placeholder="Search city, area nighbourhood">
                  <div class="mt-2">
                  <img src="img/marker.png" class="w-6"> Use Current Location
                  </div>
                </div>
           </div>

           <div class="row no-gutters"> 
            <div class="col-md-12">
              <div class="search-box-container">
               
               <img src="img/search.svg" class="input-icon-l mt-neg-1">
                 <input id="search_shops" type="text" name="" class="search-box" placeholder="Search Shops">
                  <img src="img/mic.svg" class="input-icon-r" style="display: none;">
              </div>
              </div>
           </div>
       </header>

       <!-- banners -->
        
        <div class="banners-area">
        
        <div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/banner1.jpg" alt="Los Angeles" style="width:100%">
    </div>
    <div class="carousel-item">
      <img src="img/banner2.jpg" alt="Chicago" style="width:100%">
    </div>
    <div class="carousel-item">
      <img src="img/banner3.jpg" alt="New York" style="width:100%">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

</div>
</div>

<!-- tabs -->

<div class="app-container">

  <div class="theme-tabs">
  
  <!-- Nav tabs -->
  <ul class="nav nav-tabs container-85" role="tablist" >
    <li class="nav-item br-right">
      <a class="nav-link active" data-toggle="tab" href="#home">all stores</a>
    </li>
    <li class="nav-item">
      <a class="nav-link " data-toggle="tab" href="#menu1">favourites</a>
    </li>
  </ul>

  <div data-toggle="modal" data-target="#shopFilterModal"><img src="img/filter.svg" class="filter"></div>

  

  <!-- Tab panes -->
  <div class="tab-content">

    <div id="home" class=" tab-pane active"><br>

    <?php foreach($results_data as $key => $value){ ?>

      <?php if($value['fav']!=''){ ?>
        <img src="img/liked.svg" alt="like" class="like_blank likeThis" onclick="addShopFav(<?php echo $value['id']?>);">
      <?php }else{ ?>
        <img src="img/like_blank.svg" alt="like" class="like_blank likeThis" onclick="addShopFav(<?php echo $value['id']?>);">
      <?php } ?>
      <?php
         // $img_arr = array('shopcover','cover_shop'); 
       $img_arr = array('shopcover1','shopcover2','shopcover3','shopcover4');
        $random_keys=array_rand($img_arr);
        $rand_image = $img_arr[$random_keys];
        $exp = $_SERVER['REQUEST_URI'];
        $break_str = explode("/",$exp);
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/BajarSe/".$rand_image.'.png';
        if($value['shop_cover_image'] == ""){
          $shop_cover_image = $rand_image;
        }else{
          $shop_cover_image = $value['shop_cover_image'];
        }
        //echo $actual_link;
      ?>

      <a class="goShop" onclick="selectShop(<?php echo $value['id']?>,'<?php echo $shop_cover_image ?>','<?php echo $value['business_name']?>','<?php echo $value['address']?>','<?php echo $value['mobile']?>');">
        <div class="store-card">
          <div class="row no-gutters">

          
            
            
            <div class="col-4">
              <img src="<?php if($value['shop_image']!=""){ echo 'http://'."{$_SERVER['HTTP_HOST']}".'/BajarSe/'.$value['shop_image']; }else{ echo "$actual_link"; }  ?>" style="height: 100px; width: 100px;" alt="store">
            </div>
            <div class="col-8 store-info">
              <h3><?php echo $value['business_name']; ?></h3>
              <div class="store-info-inner">
                <div class="row no-gutters">
                  <div class="col-6">
                    <label>Shop Category</label>
                    <div class="value"><?php echo $value['category']; ?></div>
                  </div>
                  <div class="col-6">
                    <label>Shop Type</label>
                    <div class="value"><?php if($value['shop_type']==1){ echo 'Retailer';}else{echo 'Wholesaler';}?></div>
                  </div>
                </div>
                <div class="row no-gutters ">
                  <div class="col-6">
                    <label>Min. Order</label>
                    <div class="value">Rs.<?php echo $value['min_order_value']; ?></div>
                  </div>
                  <div class="col-6">
                    <label>Distance</label>
                    <div class="value"><?php echo $value['max_delivery_distance']; ?> km</div>
                  </div>
                </div>

                <div class="row no-gutters ">
                  <div class="col-12">
                    <p class="orange f-12">Delivery Charges: Rs.<?php echo $value['delivery_charge']; ?></p>
                  </div>
                
                </div>
              
              </div>
            </div>
          </div>
          <div class="divider"></div>
          <div class="row no-gutters f-12 p-8 gray-dark plr-0 ">
            <div class="col-6 ">
              Payment mode: <b> <?php if($value['payment_type']==1){ echo 'Cash';}else if($value['payment_type']==2){echo 'Online';}else{echo 'Cash / Online';}  ?></b>
            </div>

              <div class="col-6">
                    Home Delivery <?php if($value['delivery_mode']==1){?> <span class="green font-weight-bold">Available</span> <?php }else if($value['delivery_mode']==3){ ?> <span class="green font-weight-bold">Available</span> <?php }else{ ?><span class="red font-weight-bold">Unavailable</span> <?php } ?>
                  </div>
            
          </div>
        </div>
      </a>

      <?php } ?>

       

    </div>
    <div id="menu1" class=" tab-pane fade"><br>
     
     <?php foreach($results_data as $key => $value){ ?>
      <?php
         // $img_arr = array('shopcover','cover_shop'); 
      $img_arr = array('shopcover1','shopcover2','shopcover3','shopcover4');
        $random_keys=array_rand($img_arr);
        $rand_image = $img_arr[$random_keys];
        $exp = $_SERVER['REQUEST_URI'];
        $break_str = explode("/",$exp);
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/BajarSe/".$rand_image.'.png';
        if($value['shop_cover_image'] == ""){
          $shop_cover_image = $rand_image;
        }else{
          $shop_cover_image = $value['shop_cover_image'];
        }
        //echo $actual_link;
      ?>

      <?php if($value['fav']!=''){ ?>
        <img src="img/liked.svg" alt="like" class="like_blank likeThis" onclick="addShopFav(<?php echo $value['id']?>);">
      
        

      <a class="goShop" onclick="selectShop(<?php echo $value['id']?>,'<?php echo $shop_cover_image?>','<?php echo $value['business_name']?>','<?php echo $value['address']?>','<?php echo $value['mobile']?>');">
        <div class="store-card">
          <div class="row no-gutters">
           
            <div class="col-4">
              <img src="<?php if($value['shop_image']!=""){ echo 'http://'."{$_SERVER['HTTP_HOST']}".'/BajarSe/'.$value['shop_image']; }else{ echo "$actual_link"; } ?>" style="height: 100px; width: 100px;" alt="store">
            </div>
            <div class="col-8 store-info">
              <h3><?php echo $value['business_name']; ?></h3>
              <div class="store-info-inner">
                <div class="row no-gutters">
                  <div class="col-6">
                    <label>Shop Category</label>
                    <div class="value"><?php echo $value['category']; ?></div>
                  </div>
                  <div class="col-6">
                    <label>Shop Type</label>
                    <div class="value"><?php if($value['shop_type']==1){ echo 'Retailer';}else{echo 'Wholesale';}?></div>
                  </div>
                </div>
                <div class="row no-gutters ">
                  <div class="col-6">
                    <label>Min. Order</label>
                    <div class="value">Rs.<?php echo $value['min_order_value']; ?></div>
                  </div>
                  <div class="col-6">
                    <label>Distance</label>
                    <div class="value"><?php echo $value['max_delivery_distance']; ?> km</div>
                  </div>
                </div>
                <p class="orange f-12">Delivery Charges: Rs.<?php echo $value['delivery_charge']; ?></p>
              </div>
            </div>
          </div>
          <div class="divider"></div>
          <div class="row no-gutters f-12 p-8 gray-dark plr-0 ">
            <div class="col-7 ">
              Payment mode: <b> <?php if($value['payment_type']==1){ echo 'Cash';}else if($value['payment_type']==2){echo 'Online';}else{echo 'Cash / Online';}  ?></b>
            </div>
            <div class="col-5 ">
              Home Delivery <span class="green font-weight-bold"><?php if($value['delivery_mode']==1){ echo 'Available';}else if($value['delivery_mode']==3){ echo 'Available';}else{echo 'Unavailable';}?></span>
            </div>
          </div>
        </div>
      </a>
      <?php } ?>
      <?php } ?>

    </div>
  </div>
  </div>
</div>
</div>


    </div>
    <div id="ordersPage" class="tab-pane">

      <div  id='OrderdetailSection' style="display: none; padding-bottom: 100px;">
       <header>

           <div class="header-upper">
            <div class="row no-gutters">
                <div class="col-12 f-20">
                   <a  id="backOrdersList"><img src="img/back.svg" ></a> Order Details
               </div>
              
               </div>
           </div>
         
       </header>


       <!-- Order info -->

        <div class="container">
         <div class="">
            <div class="order-info mt-3">
              <div class="row">
                <div class="col-6">
                  <label>Order ID:</label>
                  <div id="order_id_detail" class="value">
                    
                  </div>
                </div>
                 <div class="col-6">
                  <label>Placed On:</label>
                  <div id="order_date_detail" class="value">
                    
                  </div>
                </div>

                 <div class="col-6 mt-3">
                  <label>No. of Items</label>
                  <div id="order_detail_num_items" class="value">
                    
                  </div>
                </div>

                <div class="col-6 mt-3">
                  <label>Total Cost</label>
                  <div id="order_detail_total_cost" class="value">
                    
                  </div>
                </div>

                <div class="col-6 mt-3">
                  <label>Payment Method</label>
                  <div id="order_detail_payment_type" class="value">
                    
                  </div>
                </div>

                <div class="col-6 mt-3">
                  <label>Contact Seller</label>
                  <div class="value">
                   <a class="shop_call" href="tel:+918770629578"> <img src="img/phone_call.svg"></a>
                   <a class="shop_whatsapp" href="https://api.whatsapp.com/send?phone=918860087716" target="_blank"> <img src="img/whatsapp.svg"></a>

                  </div>
                </div>

                <div class="col-6 mt-3">
                  <label>Delivery Mode</label>
                  <div  class="value">
                     Pickup
                  </div>
                </div>


              </div>
            </div>


            <div class="section-heading mt-5">Order Items List</div>
           
           <div id="order_product_list" class="order-item-list">
            


            <!-- <div class="store-card  p-12px" >
              <div class="row no-gutters">
                 <div class="col-4">
                   <img src="img/product-2.png" alt="store" class="w-70">
                  </div>
                  <div class="col-8 store-info mt-16">
                    <div class="title">Maggie Noodles</div>
                    <div class="item-detail">
                           <div class="f-12">Units: <span class="f-14 font-weight-bold">02</span></div>
                           <div class="f-12">Total Cost: <span class="f-14 font-weight-bold">Rs.24.00</span></div>
                    </div>
                  </div>
              </div>
            </div> -->
            </div>



         </div>

           <div class="">
              <div class="app-section pt-20px">
                <label>Additional Notes:</label>
                <!-- <div  class="value">Add 2 pack of 500gm Boost</div> -->
                <div id="order_detail_note" class="value"></div>
              </div>
           </div>
               



               </div>
               <div>
           <div class="divider"></div>

             <div class="container">
              <div class="app-section">
                  <div class="dark f-16" id="ViewAdditionalbtn"><img src="img/plus.svg">&nbsp;View Additional Products</div>

                  <div class=" f-16 pb-2 mt-1" id="noAdditionalItems" style="display: none;"></div>

                  <div class=" f-16 pb-2 mt-1" id="noItemsDiv" style="display:none;">
                    No additional products have been added in this order by seller
                  </div>

                 <div class="order-info mt-3" id="ViewAdditionalProducts" style="display:none;" >
               
              <!-- <div class="row">
                <div class="col-12">
                  <label>Product Name</label>
                  <div class="value f-14">
                   Maggie Noodles
                  </div>
                </div>
                <div class="col-4 mt-2">
                  <label>Total Qty.</label>
                  <div class="value">
                    20
                  </div>
                </div>
                <div class="col-4 mt-2">
                  <label>Total Cost</label>
                  <div class="value">
                    Rs.120
                  </div>
                </div>
                <div class="col-4 mt-2">
                  <label>Total Price</label>
                  <div class="value">
                    Rs.24,000
                  </div>
                </div>
              </div> -->

            </div>
                  </div>
             </div>
             </div>
             <div >
              <div class="divider"></div>
            <div class="container" >
              <div class="item-summary ">
                <div class="dark f-16 pb-2">Cost Summary</div>
                  <table class="f-14">
                    <tr>
                      <td>Goods Amount</td>
                      <td><b><span id="order_detail_goods_amount"></span></b></td>
                    </tr>

                     <tr>
                      <td>Delivery Charges</td>
                      <td><b><span id="order_detail_delivery_charge"></span></b></td>
                    </tr>

                    <tr>
                      <td class="pb-0">Coupon Discount</td>
                      <td class="pb-0"><b><span id="order_detail_discount_amount"></span></b></td>
                    </tr>
                  </table>
              </div>
            </div>

             <div class="divider"></div>

              <div class="container" >
              <div class="app-section-small"> 
              <div class="row f-14 dark ">
                <div class="col-6 ">Total Goods Amount</div>
                <div id="order_detail_total_goods_amount" class="col-6 text-right"></div>
                <div class="col-6 ">Addtional Items</div>
                <div id="order_detail_additional_amount" class="col-6 text-right"></div>
              </div>
              </div>
            </div>

            <div class="divider"></div>

            <div class="container" >
              <div class="app-section-small"> 
              <div class="row f-14 dark ">
                <div class="col-6 ">Total Pay</div>
                <div id="order_detail_total_pay_amount" class="col-6 text-right"></div>
              </div>
              </div>
            </div>

             <div class="divider"></div>

              <div class="container" >
              <div class="app-section-small"> 
                  <div class="dark f-16">Delivery Address</div>
                  <div id="order_detail_delivery_address" class="address mt-2">
                    
                  </div>
              </div>
               <div class="app-section-small pt-0"> 
                 <div class="dark f-16">Order Status</div>
                  <div id="order_detail_status" class=""></div>
               </div>
             
            </div>

            <div class="" style="display: none;">
              <div class="app-section-small"> 
                  <div class="dark f-16">Order Status</div>
                  <div class="status-completed ml-0"><span class="dot"></span>Completed</div>
              </div>
            </div>
            <div id="order_detail_cancel_button" class="text-center">
            <!-- <button class="btn btn-primary f-13">cancel order</button> -->
            </div>
            </div>
           </div>

       <div id="ordersList" style="padding-bottom: 100px;">
       <header class="pb-0">
        <div class="" style="width:100%; margin: auto; ">
           <div class="row no-gutters">
               <div class="col-12 f-20">
                   Orders
               </div>
                
           </div>

             <div class="row no-gutters"> 
            <div class="col-md-12">
              <div class="search-box-container-2 mt-3">
              
               <img src="img/search.svg" class="input-icon-l mt-neg-1 t-25">
                 <input id="search_order" type="text" name="" class="search-box" placeholder="Search Shops Or Order ID">
              <img src="img/mic.svg" class="input-icon-r mt-neg-1 t-25" style="display: none;">
              </div>
              </div>
           </div>

           <div class="filters ">
               <ul>
                   <li >
                       <a id="orders_all" href="#" onclick="getOrderList(0,'');" class="active">ALL</a>
                   </li>
                   <li>
                       <a id="orders_pending" href="#" onclick="getOrderList(1,'');">pending</a>
                   </li>
                   <li>
                       <a id="orders_ready" href="#" onclick="getOrderList(2,'');">Ready</a>
                   </li>

                    <li>
                       <a id="orders_completed" href="#" onclick="getOrderList(3,'');">Completed</a>
                   </li>

                   <li>
                       <a id="orders_cancelled" href="#" onclick="getOrderList(4,'');">Cancelled</a>
                   </li>
                  
               </ul>
           </div>

           
           </div>

       </header>

        <!-- mid-area -->
    
        <div class="page-container-92">
        <div id="orderList" class="padding-none" >

          <!-- <a class="goToOrders">
            <div class="store-card ">

          <div class="row no-gutters">
           
             <div class="col-3">
               <img src="img/product-1.png" alt="store">
              </div>
              <div class="col-9 store-info pb-10px">
                <h3>Urban Kirana</h3>
                <div class="status-cancelled"><span class="dot"></span>Cancelled</div>
                <div class="store-info-inner">
                <div class="row no-gutters">
                  <div class="col-6">
                    <label>Order ID:</label>
                    <div class="value color-secondary">NA12345678</div>
                  </div>
                  <div class="col-6">
                    <label>Placed On:</label>
                    <div class="value color-secondary">16/03/2020</div>
                  </div>
                  
                </div>

                <div class="row no-gutters">
                  <div class="col-6">
                    <label>No. of Items</label>
                    <div class="value color-secondary">02</div>
                  </div>
                  <div class="col-6">
                    <label>Total Cost:</label>
                    <div class="value color-secondary">Rs.5,000</div>
                  </div>
                  
                </div>
                 
                 



                </div>


              </div>
              


          </div>
          
          
      </div>
      </a> -->


        </div>
        </div>
    </div>
    </div>

     
     <div id="khataPage" class="tab-pane"  >
      <div class="empty-cart">
        <header>

             <div class="no-bg">
              <div class="row no-gutters">
                <a href=""><img src="img/back.svg"></a>
                  <div id="shop_name" class="col-7 f-20"></div>
                  
                 </div>
             </div>
            
         </header>
         <div class="page-container">
          <div class="container">
            <div class="row mt-100">
                  <div class="col-md-12 ">
                      <img src="img/shopping_basket.png" class="no-item">
                  </div>
                <div class="col-md-12 ">
                  <div class="dark f-20 text-center ">No items in basket</div>
                </div>
                <div class="col-md-12 mt-12 text-center ">
                  <a  href="" class="btn btn-primary w-80" >Start Shopping</a>
                </div>
            </div>


            </div>
        </div>
      </div>
    <div class="cart-full">
      <div id="noContactDelivery" style=" display: none; padding-bottom: 100px;">
       <header>
           <div class="row no-gutters">
               <div class="col-12 f-20">
                   <a id="backNCD"><img src="img/back.svg"></a>&nbsp;&nbsp;No Contact Delivery
               </div>
           </div>
       </header>

        <!-- mid-area -->
    
        
         <!-- Banner -->

         <img src="img/delivery.png" class="full-width">

         <div class="container-fluid">
          <div class="f-18 dark mt-3">How it works:</div>
          <div class="row mt-3">
           <div class="col-3 text-center"><img src="img/mob.svg" style="width: 75%;"></div>
           <div class="col-9 pl-0">
             <div class="f-16 dark l-18">Select ‘No Contact Delivery’ at your cart checkout.</div>
             <div class="orange f-12 mt-1">* Not applicable on COD Orders</div>
           </div>
         </div>

         <div class="row mt-4">
           <div class="col-3 text-center"><img src="img/gate.svg" class="full-width"></div>
           <div class="col-9 pl-0">
             <div class="f-16 dark l-18">Your Delivery partner will leave your order at the door and call you to confirm the same.</div>
              
           </div>
         </div>

         <div class="mt-35px">
           <img src="img/thumbs_up.svg">&nbsp;&nbsp;<span class="f-12 maroon mt-2 block">Your order is safe for pickup at your convenience!</span>
         </div>

         </div>

         </div>

    <!-- offers and Coupon page -->
     <div id="offersCouponSection" style=" display: none; padding-bottom: 100px;">
       <header>
           <div class="row">
               <div class="col-12 f-20">
                  <a onclick="backFromCouponSection();" href="#"><img src="img/back.svg"></a>&nbsp;&nbsp;Offers & Coupons
               </div>
                
           </div>

             <div class="row no-gutters"> 
            <div class="col-md-12">
              <div class="search-box-container">
               
                  <img src="img/search.svg" class="input-icon-l mt-neg-1">
                 <input type="text" name="" class="search-box" placeholder="Search the Offers / Coupon Code">
                  
                  
              </div>
              </div>
           </div>
           
       </header>

        <!-- mid-area -->
    
        <div id="discount_coupon_list">
          
        
        <!-- <div class="page-container"> 
          
          <div class="coupon-card">
            <div class="row">
              <div class="col-5 pr-0">
                 <div class="coupon f-14">
                     NAGD235689
                    </div>
              </div>
              <div class="col-6 pl-10px my-auto">
                 <img src="img/applycode_icon_unselect.svg" class="applyCode">
              </div>
            </div>
            <div class="f-14 dark mt-2">Get 15% discount on order above Rs.400</div>
            <div class="contain-divider"></div>
            <div class="f-13">Use code NAGD235689 and get 15% discount up to Rs.75 on order above Rs.400 </div>
           
          </div>
             
        </div>
        <div class="divider"> </div> -->
        </div>
        

        </div>






   <div  id="cartSection" >

    <header class="p-20px">

           <div class="product-details">
             <div class="row no-gutters">
               <div class="col-3" id="shop_image_cart">
                 <!-- <img src="img/store.png" class="full-width"> -->
               </div>

                <div class="col-9 pl-3 my-auto">
                 <div class="dark f-18" id="shop_name_cart">
                   
                 </div>
                 <div class="f-12" id="shop_address_cart"></div>
               </div>
             </div>
             <div id="cart_products" class="products-scroll"></div>
             <!-- <div class="row no-gutters mt-3">
               <div class="col-5">
                 <div class="dark f-16">Maggie Noodles</div>
                 <div class="f-12">10 pieces</div>
               </div>
               <div class="col-4">
                <div class="increase-product float-left w-90px" >
                  <span class="minus f-25" id="minus">-</span><span class="plus f-25" id="plus">+</span>
                  <input type="text" class="increase qtyProduct no-border p-8px f-18 " value="10" >
                </div>
               </div>

               <div class="col-3 f-16 text-center">
                 <span class="outer ml-6-neg"><span class="inner-green">Rs.200</span></span>
                  <div class="dark mt-5-neg">Rs.160</div>
               </div>
             </div> -->
           </div>
         
       </header>


       <!-- mid part -->

        <div class="page-container "  >
          <a class="goNCD">
          <div class="theme-card  mt-4 p-15-5">
            <div class="row no-gutters">
              <div class="col-2 text-center my-auto pl-15px">
                <label class="checkcontainer" id="checkcontainer">
                       <input id="no_contact_delivery_checkbox" type="checkbox" >
                       <span class="checkmark"></span>
                </label>
              </div>

              <div class="col-9">
                <div class="f-16 text-green font-weight-bold" >No-Contact Delivery</div>
             <div class="f-12">Thank you for opting-in. Our delivery excecutive 
            will call you before leaving the order at your door.
             
          </div>
              </div>

              <div class="col-1 my-auto">
                <img src="img/left-arrow.svg" class="float-right m-10-6">
              </div>
            </div>
          </div>
           
           </a>
          <div class="theme-card card-padding">
             <div onclick="getDiscountCoupons();" class="f-16 text-green font-weight-bold" id="OffersCoupons"><img src="img/percent.svg" class="ml-10px">&nbsp;<span class="ml-10px">Avail Offers / Coupons </span> <img src="img/left-arrow.svg" class="float-right m-10-6"></div>
          </div>
         

          
          
          

        </div>

        
       <div class="page-container">
        <div class="app-section-20 pb-18">
            <div class="section-heading-8">Store Bill</div>
               <div class="f-14">
                 <div class="float-left">Item Total</div>
                 <div id="total_item_cost_cart" class="float-right font-weight-bold"></div>
                 <div class="clearfix"></div>
               </div>
          </div>
        </div>
        <div class="divider"></div>

        <div class="page-container">
          <div class="app-section-12">
             <div class="f-14">
                 <div class="float-left">Delivery Fee</div>
                 <div id="delivery_fee_cart" class="float-right font-weight-bold"></div>
                 <div class="clearfix"></div>
                 <div class="float-left mt-2">Coupon Discount</div>
                 <div id="discount_cart" class="float-right font-weight-bold mt-2"></div>
                  <div class="clearfix"></div>
               </div>
          </div>
        </div> 

        <div class="divider"></div> 

         <div class="page-container">
          <div class="app-section-12">
             <div class="f-14">
                 <div class="float-left dark ">To Pay</div>
                 <div id="total_cost_cart" class="float-right dark"></div>
                 <div class="clearfix"></div>
                 
               </div>
          </div>

        <div class="page-container mt-4">
          <div class="theme-card padding-12-10">
            <div class="row no-gutters">

              <div class="col-9">
                <div class="f-16 text-green font-weight-bold" >Delivery Address</div>
             <div id="delivery_address_cart" class="f-14"></div>

              <div id="delivery_time_div" class="orange f-12 mt-1"></div>
              </div>

               <div class="col-3 my-auto">
                    <a class="btn-blue padding-6-14 f-10" data-toggle="modal" data-target="#locationModal">Change</a>

                    <a id="delivery_address_map_link" target="_blank" class="btn-blue padding-6-14 f-10" >Map</a>

               </div>

              
            </div>
          </div>

          <div class="float-right text-uppercase dark f-10" style="display: none;"> <img src="img/plus_small.svg"> add new location</div>
          
          <div class="clearfix"></div>

          <div class="section-heading mt-3 ">
            Delivery Mode
          </div>
            

           <div class="dark f-14 ">
            <div class="row">
              <div  class="col-6" id="radio_home_div">
                <input id="radio_home" type="radio" name="delivery_mode" checked="" value="1">&nbsp;&nbsp; Home Delivery &nbsp;
              </div>
              <div  class="col-5">
              <input id="radio_pickup" type="radio" name="delivery_mode" value="2">&nbsp;&nbsp; Pickup
              </div>
              </div>
          </div>

           <div class="section-heading mt-4">
            Additional Notes
          </div>

          <textarea id="cart_note" class="form-control no-border h-90 no-box-shadow notes-box" placeholder="Enter the additional notes here"></textarea>

          
        </div>
        <div id="min_order_value_cart" class="yellow-note mt-35px" >
            
          </div>
         
         <div class="page-container">
          <div class="row no-gutters mt-4">
            <div class="col-6 my-auto">
              <div id="total_cost_cart_bill" class="f-14 dark">Rs.00.00</div>
              <div class="text-green text-uppercase f-10 font-weight-bold" style="display:none;">view detailed bill</div>
              </div>
               <div class="col-6">
                <a onclick="createOrder();" class="btn btn-blue btn-block font-weight-bold"> Place Order </a>
               </div>
            </div>
          </div>
          <br><br><br><br>
    </div>




<div id="addNewAddressSection" style="display:none;">
         <div class="header-overlay" style="position: absolute;">
           <!-- <a  onClick="history.go(-1); return false;" ><img src="img/back.png"></a> -->
           <a class="backCartSection" ><img src="img/back.png"></a>
         </div>
        <img src="img/map.png" class="full-width" style="display: none;">
        
        <!-- mid-part -->
        <div class="page-container">
          <div class="mt-3">
          <div class="section-heading">Set Delivery Location</div>
          </div>

          <div class="theme-form-second lightplaceholder mt-per-5 ">
                        <form action="add_new_address.php" method="post" onsubmit="return false">
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
                                    <input type="submit" class="btn btn-blue font-weight-bold backCartSection" value="Submit" >
                                </div>
                            </div>
                        </form>
                    </div>
        </div>

        </div>





    </div>
   </div>
  </div>
  <div id="menuPage" class="tab-pane ">

      <!-- profile page -->

       <div id="profileSection" style="display: none; ">
       <header>
           <div class="row no-gutters">
               <div class="col-12">
                   <a  id="backProfile"><img src="img/back.svg"></a>&nbsp;Profile
               </div>
                
           </div>
       </header>

        <!-- mid-area -->
    
        
        <div class="page-container"> 
             <div class="profile f-14">
               <div class="row ">
                 <div class="col-12 mt-3">
                   <label >customer name</label>
                   <div class="value"><?php echo $name;?></div>
                 </div>

                 <div class="col-12 mt-3">
                   <label >Mobile number</label>
                   <div class="value"><?php echo $mobile;?></div>
                 </div>

                 
               </div>
             </div>

             <!-- <a  data-toggle="modal" data-target="#moreAddress">
             <div class="text-green mt-3 f-14"><img src="img/plus_border.svg">&nbsp;&nbsp;Add More Address</div>
             </a> -->
             <div class="profile ">
              <div class="row  ">
                <div class="col-5 mt-3">
                   <label >referral code</label>
                   <div class="value-big"><?php echo $referral_code; ?></div>
                 </div>
                 <div class="col-7 mt-3">
                   <label >&nbsp;</label>
                   <div class=" text-uppercase gray f-11 font-weight-bold"><a href="https://web.whatsapp.com/send?text=<?php echo $referral_code; ?>"><img src="img/share_gray.png"></a>&nbsp;&nbsp;share referral code </div>
                 </div>

                 
              </div>

              <div class="row no-gutters">
                 <div class="col-10 mt-3">
                   <label >Address</label>
                   <div id="address_profile_cust" class="value"></div>
                 </div>
                 <!-- <div class="col-2 my-auto">
                  <label >&nbsp;&nbsp;</label>
                  <div><img src="img/delete.svg"><img class="pencil" src="img/g.svg" ></div>
                  </div> -->
              </div>
            </div>
             <a  id="addMoreAddress" data-toggle="modal" data-target="#moreAddress">
             <div class="text-green mt-3 f-14"><img src="img/plus_border.svg">&nbsp;&nbsp;Add More Address</div>
             </a>

             



        </div>
        </div>
        
        <!-- support page -->

         <div id="supportSection" style="display: none;">
       <header>
           <div class="row no-gutters">
                <div class="col-12 f-20 ">
                   <a  id="backSupport"><img src="img/back.svg"></a>&nbsp;Support
               </div>
                <div class="col-4 ">
                   
               </div>
               </div>
       </header>

        <!-- mid-area -->

        <div class="page-container mt-5 ">
           <div class="f-14 dark">Call us or chat with us if you have any feedback or any new feature request.</div>

           <a href="tel:+6360122726">
             <div class="support-card mt-4">
               <div class="row no-gutters">
                 <div class="col-2 my-auto">
                   <img src="img/calling.svg">
                 </div>
                 <div class="col-8 my-auto">
                   <div class="dark f-20">Call Us</div>
                   <div class="f-12">Office Timing: 10:00 AM - 7:00 PM</div>
                 </div>
                 <div class="col-2 my-auto text-right">
                   <img src="img/arrow.svg"  >
                 </div>
               </div>
             </div>
           </a>
           
          <a href="https://api.whatsapp.com/send?phone=6360122726">
            <div class="support-card padding30-18">
             <div class="row no-gutters">
               <div class="col-2 my-auto">
                 <img src="img/messages.svg">
               </div>
               <div class="col-8 my-auto">
                 <div class="dark f-20">Chat with Us</div>
                
               </div>
               <div class="col-2 my-auto text-right">
                 <img src="img/arrow.svg"  >
               </div>
             </div>
           </div>
          </a>
           
        </div>
       </div>


       <!-- how to use section -->


       <div id="htuSection" style="display: none;">
       <header >
           <div class="row">
               <div class="col-12">
                   <a id="backHTU"><img src="img/back.svg"></a>&nbsp;&nbsp;How to Use
               </div>
                
           </div>

             <div class="row no-gutters"> 
            <div class="col-md-12">
              <div class="search-box-container">
                  <img src="img/search.svg" class="input-icon-l mt-neg-1">
                    <input type="text" name="" class="search-box" placeholder="Search Video here">
                  <img src="img/mic.svg" class="input-icon-r mt-neg-1" style="display: none;">
              </div>
              </div>
           </div>
           
       </header>

        <!-- mid-area -->
    
        
        <div class="page-container"> 
             <div id="tutorial_videos_nums" class="count f-14 mt-3"> 23 Videos</div>

             <div id="tutorial_videos_list">
              <!-- <div class="row mb-1 ">
                <div class="col-6 pl-9">
                  <img src="img/video.png" >
                </div>
                <div class="col-6 my-auto pl-0">
                  <div class="f-14"> Add New Customer <br> in Nagad App</div>
                  <div class="f-12 gray">Nagad App</div>
                </div>
              </div> -->
             </div>
             
        </div>

        </div>

    <div style="" id="menuList">
     <header>
      <div class="page-container">
           <div class="row no-gutters">
                <div class="col-8 f-20">
                   Menu Settings
               </div>
                <div class="col-4 ">
                   <div class="text-uppercase text-right ">
                       <img src="img/language_change.png" style="width:28%;" >
                   </div>
               </div>
               </div>
               </div>
       </header>

        <!-- mid-area -->

        <div class="page-container-92 mt-3 ">
           <div>
               <ul class="list-group list-group-flush  f-14">
                  <li class="list-group-item " id="goProfile"><a ><img src="img/profile.svg" class="mr-3">Profile</a></li>
                  <li class="list-group-item" id="goSupport"><a ><img src="img/support.svg" class="mr-3">Support</a></li>
                  <li class="list-group-item" id="goHTU"><a onclick="getTutorialVideos();"><img src="img/howtouse.svg" class="mr-3">How To Use</a></li>
                  <li class="list-group-item" ><a href="notifications.php"><img src="img/notifications.svg" class="mr-3">Notification</a></li>
                  <li class="list-group-item"><a href="logout.php"><img src="img/logout_2.svg" class="mr-3">Log Out</a></li>
               </ul>
           </div>
        </div>

        <div class="text-center bottom-tag" >
          <img src="img/love_india.png">
        </div>
    </div>
    </div>
  <div class="footer-menu">
  <ul class="nav nav-tabs " role="tablist" >
    <li class="nav-item ">
      <a class="nav-link footer-option active" id="fo_1" data-toggle="tab" href="#homePage">
        <img src="img/home.svg">
      <div>Home</div>
  </a>
    </li>
    <li class="nav-item">
      <a class="nav-link footer-option"  id="fo_2" data-toggle="tab" href="#ordersPage" onclick="getOrderList(0,'');">
        <img src="img/orders.svg">
      <div>Orders</div></a>
    </li>
      <li class="nav-item">
        
      <a class="nav-link footer-option" id="fo_3" data-toggle="tab" href="#khataPage" onclick="getShopSettings();">
        <span id="num_item_cart" class="item-count" autocomplete="off">0</span>
        <img src="img/cart.svg">
        <div>Cart</div></a>
    </li>
      <li class="nav-item">
      <a class="nav-link footer-option" id="fo_4" data-toggle="tab" href="#menuPage">
      <img src="img/menu.svg">
      <div>Settings</div></a>
    </li>
  </ul>
  </div>









<!-- Footer -->


        

       

      

     


       


        
        
        
    
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
        <script src="js/main.js"></script>
        <script src="js/bootstrap-slider.js"></script>
        <script type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApafGQtuvWaTvvHUCdFoGrcRgnsin4n2M&libraries=places"></script>

            <script type="text/javascript"> 

const componentForm = {
  locality: "long_name",
  administrative_area_level_1: "long_name",
  country: "long_name",
  postal_code: "short_name",
};

function initialize() {
  var input = document.getElementById('search_geolocation');
  var options = {
  types: ['geocode'],
  componentRestrictions: {country: 'IN'}
};
  var autocomplete = new google.maps.places.Autocomplete(input,options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lon = place.geometry.location.lng();
        //console.log(place.formatted_address);

        // for (var i = 0; i < place.address_components.length; i++) {
        //   var addressType = place.address_components[i].types[0];
        //   if (componentForm[addressType]) {
        //     var val = place.address_components[i][componentForm[addressType]];
        //     document.getElementById(addressType).value = val;
        //   }
        // }
        
        $("#current_address_header").text(place.formatted_address);
        current_lat = lat;
        current_lon = lon;
        $('#div_search_location').hide();
    });
}
google.maps.event.addDomListener(window, 'load', initialize);


function initialize_1() {
  var input = document.getElementById('search_geoLocation');
  var options = {
  types: ['geocode'],
  componentRestrictions: {country: 'IN'}
};
  var autocomplete = new google.maps.places.Autocomplete(input,options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lon = place.geometry.location.lng();
       // console.log(place.formatted_address);

        // for (var i = 0; i < place.address_components.length; i++) {
        //   var addressType = place.address_components[i].types[0];
        //   if (componentForm[addressType]) {
        //     var val = place.address_components[i][componentForm[addressType]];
        //     document.getElementById(addressType).value = val;
        //   }
        // }
        
        $("#current_address_header").text(place.formatted_address);
        current_lat = lat;
        current_lon = lon;
        
        $('#div_search_location').hide();
    });
}
//$('#moreAddress').modal('show');
$('#moreAddress').on('shown.bs.modal', function() {
    initialize_1();
});
  // window.onbeforeunload = function() {
  //   window.close(); 
  // };

  $(document).ready(function(){
    getLocation();
    function disablePrev() { window.history.forward() }
    window.onload = disablePrev();
    window.onpageshow = function(evt) { if (evt.persisted) disableBack() }

    var pagename = getParameterByName('pagename'); // "lorem"
      if(pagename == 'notifications'){ 
        $(".footer-options").removeClass('active');
        $('#fo_4').addClass('active');
        $(".tab-pane").removeClass('active');
        $('#menuPage').addClass('active');  
      }
  })

  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }



$("#search_order").on('change keyup paste', function () {
    var searchString = $("#search_order").val();
    getOrderList(order_status,searchString);
});

$("#search_shops").on('change keyup paste', function () {
    var searchString = $("#search_shops").val();
    search_shop(searchString,"0","0");
    //getOrderList(order_status,searchString);
});



var cart_array=[];
var selected_shop_id=0;
var delivery_fee=0;
var total_cost_cart=0;
var total_cost_without_discount=0;
var total_cost_after_discount=0;
var discount_cart=0;
var cust_id =0;
var delivery_mode=0;
var delivery_charge=0;
var min_order_value=0;
var selected_delivery_address="";
var order_status=0;
var current_lat=0;
var current_lon=0;
var filter_delivery_distance=0;
var filter_minimum_delivery_charge=0;


function selectShop(shop_id,shop_cover_image,shop_name,address,mobile){
  $('.shop-image').empty();

   var pathName = window.location.pathname;
   mainDirectory = pathName.split("/","2");
   var randImg = window.location.protocol+'//'+window.location.hostname+'/BajarSe/'+'img'+'/shopcover.jpg';
    
    //console.log(mainDirectory['1']);
    $('.shop-image').append('<img src="'+randImg+'" style="width:100%; height:220px;">');
  // if(shop_cover_image!=""){
  //   // console.log("find");
  //   $('.shop-image').append('<img src="http://'+window.location.hostname+'/'+mainDirectory['1']+'/'+shop_cover_image+'" style="width:100%; height:220px;">');
  // }else{
  //   // var items = ['shopcover','cover_shop'];
  //   // var items = ['shopcover1','shopcover2','shopcover3','shopcover4'];
  //   // var item = items[Math.floor(Math.random() * items.length)];
  //   var pathName = window.location.pathname;
  //   mainDirectory = pathName.split("/","2");
  //   //console.log(item);
  //   var randImg = window.location.protocol+'//'+window.location.hostname+'/'+mainDirectory['1']+'/'+'img'+'/shopcover';
    
  //   //console.log(mainDirectory['1']);
  //   $('.shop-image').append('<img src="'+randImg+'" style="width:100%; height:220px;">');
  // }

  $('div#shop_name').text(shop_name);
  $('div#shop_name_cart').text(shop_name);
  $('div#shop_address_cart').text(address);
  $('div#shop_image_cart').append('<img src="http://'+window.location.hostname+'/BajarSe/'+shop_cover_image+'" style="width:100%; ">');


  $(".shop_call").attr("href", "tel:+91"+mobile);
  $(".shop_whatsapp").attr("href", "https://api.whatsapp.com/send?phone=91"+mobile);
  //console.log("ShopID"+shop_id);
  getShopProducts(shop_id);
  getShopOffers(shop_id);
  getShopCataloguess(shop_id);
  selected_shop_id=shop_id;
  //console.log('selectShop');
}
var x = $('.qtyProduct').val();
function minusQuantityCart(product_id){
  // if(x>1){
  //   x--
  //   document.getElementById('itemQty').value=x;
  // }
  for (var i = cart_array.length - 1; i >= 0; i--) {
    if(cart_array[i]['id']==product_id){
      var qtn = parseInt(cart_array[i]['quantity']);
      if(qtn>1){
        cart_array[i]['quantity']=(qtn-1);
        $('#cartItemQty'+product_id).val(cart_array[i]['quantity']);
      }else{
        cart_array.splice([i], 1);
      }
    } 
  }
  //console.log(cart_array);
  calculateCart();
}

function plusQuantityCart(product_id){
   // x++
   // document.getElementById('itemQty').value=x;

  for (var i = cart_array.length - 1; i >= 0; i--) {
    if(cart_array[i]['id']==product_id){
      var qtn = parseInt(cart_array[i]['quantity']);
      cart_array[i]['quantity']=(qtn+1);
      $('#cartItemQty'+product_id).val(cart_array[i]['quantity']);
    } 
  }
  //console.log(cart_array);
  calculateCart();
}

function changeLocation(){
  //alert('test');
  //$("#changeLocationModal").show();
  
  //$('#changeLocationModal').modal('show');
  $('#div_search_location').show();
}

function clearFilter(){
  // filter_minimum_delivery_charge=0;
  // filter_delivery_distance=0;
  // $('#shop_payment_both_filter').attr('checked',true);
  // $('#delivery_filter_both').attr('checked',true);
  // document.getElementById("distance_filter").selectedIndex = 0;
  // document.getElementById("delivery_charge_filter").selectedIndex = 0;
  // //$("#shopFilterModal").hide();
  // alert("cleared");
}

function shareText(){
  if (navigator.share) {
  navigator.share({
    title: 'web.dev',
    text: 'Check out web.dev.',
    url: 'https://web.dev/',
  })
    .then(() => console.log('Successful share'))
    .catch((error) => console.log('Error sharing', error));
}
}

function addItemToCart(product_id,quantity,product_name,detail,price,buying_price,shop_id,e){
  // var n = document.getElementsByclassName('myadd');
  // event.stopPropagation();
  //console.log(shop_id);
  if(!checkItemShop(shop_id)){

    if(!isItemAlreadyInCart(product_id)){
      cart_array.push({"id":product_id,"quantity":quantity,"name":product_name,"detail":detail,"price":price,"buying_price":buying_price,"shop_id":shop_id});
          alert('Item added in cart');
          //n.style.display ="none";

    }else{
      alert('Item already added in cart');
    }
  }else{
    alert('Selected items must be from same shop');
    //event.preventDefault()
    event.stopPropagation();
  }
  $('#num_item_cart').text(cart_array.length);
}

function addItemToCart1(product_id,product_name,detail,price,buying_price,shop_id){
  // console.log(shop_id);
  if(!checkItemShop(shop_id)){

    if(!isItemAlreadyInCart(product_id)){
      var quantity = $("#product_detail_quantity").val();
      cart_array.push({"id":product_id,"quantity":quantity,"name":product_name,"detail":detail,"price":price,"buying_price":buying_price,"shop_id":shop_id});
          alert('Item added in cart');
    }else{
      alert('Item already added in cart');
    }
  }else{
    alert('Selected items must be from same shop');
    event.stopPropagation();
  }
  
}

function isItemAlreadyInCart(product_id){
  var status=false;
  for (var i = cart_array.length - 1; i >= 0; i--) {
    event.preventDefault()
    var id = cart_array[i]['id'];
    if(id==product_id){
      status=true;
    }
  }
  return status;
}

function checkItemShop(shop_id){
  var status=false;
  //console.log(cart_array);
  for (var i = cart_array.length - 1; i >= 0; i--) {
    event.preventDefault()
    var shopId = cart_array[i]['shop_id'];
    if(shopId!=shop_id){
      status=true;
    }
  }
  return status;
}

function createOrder(){

  //console.log('createOrder');
  var cart_note = $('textarea#cart_note').val();
  var delivery_mode=1;
  var no_contact=0;
  if($('#radio_pickup').is(':checked')) {
    delivery_mode=2;
  }
  if($('#no_contact_delivery_checkbox').is(':checked')) {
    no_contact=1;
  }

  
  $.ajax({
    url:"AjaxCreateOrder.php",
    data:{shop_id:selected_shop_id,
      total_cost:total_cost_cart,
      total_payment_amount:total_cost_after_discount,
      discount_amount:discount_cart,
      delivery_charge:delivery_fee,
      cust_id:cust_id,
      note:cart_note,
      delivery_address:selected_delivery_address,
      delivery_mode:delivery_mode,
      no_contact:no_contact,
      products:JSON.stringify(cart_array)},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log(response);
      if(response['status']){
        alert(response['message']);
        //location.reload();
        window.location = 'confirmation.php';
      }
    }
  });
}

function getShopProducts(shop_id){
  $('#storesList').hide();
          $('#ShopSection').show();
  $.ajax({
    url:"AjaxGetShopProducts.php",
    data:{shop_id:shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
     // console.log(response);
      if(response.length>0){
        $("#product_list_title").text('');
      }else{
        $("#product_list_title").text('No products to show');
      }
      $("#products").empty();
      for (var i = response.length - 1; i >= 0; i--) {
        //console.log(response[i]);
        var id=response[i]['id'];
        var product_name=response[i]['product_name'];
        var image=response[i]['image'];
        var product_details=response[i]['product_description'];
        var price=response[i]['price'];
        var buying_price=response[i]['price'];
        var qtn=1;
        var shop_name = response[i]['shop_name'];
        //console.log("shop = "+shop_name);
        if(!shop_name){
          new_shop_name = 'bazarse_store';
        }else{
          replaced_string = shop_name.replace(" ","-");
          new_shop_name = replaced_string;
        }
        // console.log(shop_id);

        if(response[i]['offer_available']==1){
          if(response[i]['offer_type']==1){
            var total_discount = ((response[i]['price']*response[i]['discount'])/100);
            buying_price = response[i]['price']-total_discount;
            product_details='Get '+response[i]['discount']+'% off';
          }else{
            product_details=response[i]['other_detail'];
          }
        }
        $('.share_link').attr("href","https://web.whatsapp.com/send?text="+window.location.href+"?name="+new_shop_name+"?"+shop_id+"");
        if(response[i]['offer_type']==0){
        	
          $('#products').append('<div href="#" onclick="gotoProductDetails('+id+')" class="goProductDetail"><div class="theme-card"><div class="container"><div class="row"><div class="col-7"><h3>'+product_name+'</h3><b>'+product_details+' </b><div><span class="price" style="margin-left:-1px;">Rs.'+buying_price+'</span></div><div class="row"><div class="col-12 "><div class="mt-2"><a href="https://web.whatsapp.com/send?text='+window.location.href+'?name='+new_shop_name+'?'+shop_id+'" target="_blank"><img src="img/share_liner.svg" class="float-left mt-2"></a><div class="increase-product float-left" style="display: none;"><span class="minus" id="minus">-</span><span class="plus" id="plus">+</span><input type="" name="" class="increase qtyProduct" value="1" ></div><div class="clearfix"></div></div></div></div></div><div class="col-5"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 100px; width: 100px;"></div></div></div></div></div><div class="btn btn-border addQty ml-12 btn-big showqtyBox myadd showqtyBox" onclick="addItemToCart('+id+','+qtn+',\''+product_name+'\',\''+product_details+'\',\''+price+'\',\''+buying_price+'\',\''+shop_id+'\');" >Add</div><div class="my-qty-btn qtyBox" style="display:none;"><div class="increase-product float-left w-90px " ><span class="minus"  onclick="minusQuantityCart(36)">-</span><span class="plus" id="plus" onclick="plusQuantityCart(36)">+</span><input type="text" class="increase qtyProduct " value="1" id="cartItemQty'+id+'" pattern="[0-9]*"></div></div>');
        }else{
          $('#products').append('<div href="#" onclick="gotoProductDetails('+id+')" class="goProductDetail"><div class="theme-card"><div class="container"><div class="row"><div class="col-7"><h3>'+product_name+'</h3><b>'+product_details+' </b><div ><span class="outer"><span class="inner">Rs.'+price+'</span></span><span class="price">Rs.'+buying_price+'</span></div><div class="row"><div class="col-12 "><div class="mt-2"><a href="https://web.whatsapp.com/send?text='+window.location.href+'?name='+new_shop_name+'?'+shop_id+'" target="_blank"><img src="img/share_liner.svg" class="float-left mt-2"></a><div class="clearfix"></div></div></div></div></div><div class="col-5"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 100px; width: 100px;"></div></div></div></div></div><div class="btn btn-border addQty ml-12 btn-big myadd showqtyBox" onclick="addItemToCart('+id+','+qtn+',\''+product_name+'\',\''+product_details+'\',\''+price+'\',\''+buying_price+'\',\''+shop_id+'\');" >Add</div><div class="my-qty-btn qtyBox" style="display:none;"><div class="increase-product float-left " ><span class="minus" id="minus">-</span><span class="plus" id="plus">+</span><input type="" name="" class="increase qtyProduct" value="1" ></div></div>');
        }
        
        
      }
    }
  });
}


function gotoCatalogueDetail(id,name,detail){
  $('#catalogdetailSection').show();
  $('#ShopSection').hide();
  $('div#catalog_detail_name').text(name);
  $('#catalog_detail_description').text(detail);
  getCatalogProducts(id);
}


function gotoOfferDetail(id,name,detail,end_date){
  $('#OfferdetailSection').show();
  $('#ShopSection').hide();
  $('div#offer_details_name').text(name);
  $('#offer_details_description').text(detail);
  $('#offer_detail_end_date').text(toddmmyy(end_date));
  getOfferProducts(id);
}

function gotoOrderDetail(id,order_id,num_items,total_cost,payment_type,created_at,note,delivery_charge,discount,address,status){
  $('#OrderdetailSection').show();
  $('#ordersList').hide();
  $('div#order_id_detail').text(order_id);
  $('div#order_date_detail').text(created_at);
  $('div#order_detail_num_items').text(num_items);
  $('div#order_detail_total_cost').text("Rs."+total_cost);
  $('div#order_detail_note').text(note);
  $('#order_detail_delivery_charge').text("Rs."+delivery_charge);
  $('#order_detail_discount_amount').text("Rs."+discount);
  $('div#order_detail_total_pay_amount').text("Rs."+total_cost);
  $('div#order_detail_delivery_address').text(address);

  if(status==1){
    $('#order_detail_status').append('<span class="dot"></span>Pending');
    $('#order_detail_status').addClass("status-pending ml-0");
    $('#order_detail_cancel_button').append('<button onclick="cancelOrder('+id+',4);" class="btn btn-primary f-13">cancel order</button>');
  }else if(status==2){
    $('#order_detail_status').append('<span class="dot"></span>Ready');
    $('#order_detail_status').addClass("status-pending ml-0");
    $('#order_detail_cancel_button').append('<button onclick="cancelOrder('+id+');" class="btn btn-primary f-13">cancel order</button>');
  }else if(status==3){
    $('#order_detail_status').append('<span class="dot"></span>Completed');
    $('#order_detail_status').addClass("status-completed ml-0");
    $('#order_detail_cancel_button').append('');
  }else if(status==4){
    $('#order_detail_status').append('<span class="dot"></span>Cancelled');
    $('#order_detail_status').addClass("status-cancelled ml-0");
    $('#order_detail_cancel_button').append('');
  }
  
  if(payment_type==1){
    $('div#order_detail_payment_type').text("Cash on Delivery");
  }else{
    $('div#order_detail_payment_type').text("Online");
  }

  
  
  
  
  getOrderProducts(id);
}

function cancelOrder(id,status){
  //alert(id);
  $.ajax({
    url:"AjaxChangeOrderStatus.php",
    data:{order_id:id,
      status:status},
    type:'post',
    dataType: 'json',
    success:function(response){
      if(response['status']){
        alert(response['message']);
        $("#order_detail_cancel_button").empty();
        $("#order_detail_status").empty();
        $('#order_detail_status').append('<span class="dot"></span>Cancelled');
        $('#order_detail_status').addClass("status-cancelled ml-0");
      }
    }
  });
}


function getOrderProducts(order_id){
  $.ajax({
    url:"AjaxGetOrderProducts.php",
    data:{order_id:order_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      $("#order_product_list").empty();
      $("#ViewAdditionalProducts").empty();
      var total_goods_amount=0;
      var total_additional_amount=0;
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var quantity=response[i]['quantity'];
        var product_name=response[i]['product_name'];
        var price=response[i]['price'];
        var image=response[i]['image'];
        var additional_item=response[i]['additional_item'];

        if(additional_item==0){
          $("#noAdditionalItems").show();
          var total_cost = price*quantity;
          total_goods_amount=total_goods_amount+total_cost;
          $('#order_product_list').append('<div class="store-card p-12px" ><div class="row no-gutters"><div class="col-4"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 80px; width: 80px;" alt="store" class="w-70"></div><div class="col-8 store-info mt-16"><div class="title">'+product_name+'</div><div class="item-detail"><div class="f-12">Units: <span class="f-14 font-weight-bold">'+quantity+'</span></div><div class="f-12">Total Cost: <span class="f-14 font-weight-bold">Rs.'+total_cost+'</span></div></div></div></div></div>');
        }else{
          $("#noAdditionalItems").hide();
          var total_cost = price*quantity;
          total_additional_amount=total_additional_amount+total_cost;
          $('#ViewAdditionalProducts').append('<div class="row"><div class="col-12"><label>Product Name</label><div class="value f-14">'+product_name+'</div></div><div class="col-4 mt-2"><label>Total Qty.</label><div class="value">'+quantity+'</div></div><div class="col-4 mt-2"><label>Total Cost</label><div class="value">Rs.'+price+'</div></div><div class="col-4 mt-2"><label>Total Price</label><div class="value">Rs.'+total_cost+'</div></div></div>');
        }
        
      }

      $('#order_detail_goods_amount').text("Rs."+total_goods_amount);
      $('div#order_detail_total_goods_amount').text("Rs."+total_goods_amount);
      $('div#order_detail_additional_amount').text("Rs."+total_additional_amount);
      
    }
  });
}





function getOfferProducts(offer_id){
  $.ajax({
    url:"AjaxGetOfferProducts.php",
    data:{offer_id:offer_id,
      shop_id:selected_shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      $("#offer_products_list").empty();
      $('#offer_detail_num_products').text(response.length);
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var catalogue_id=response[i]['catalogue_id'];
        var product_name=response[i]['product_name'];
        var product_details=response[i]['product_description'];
        var price=response[i]['price'];
        var buying_price=response[i]['price'];
        var image=response[i]['image'];
        var qtn=1;
        if(response[i]['offer_available']==1){
          if(response[i]['offer_type']==1){
            var total_discount = ((response[i]['price']*response[i]['discount'])/100);
            buying_price = response[i]['price']-total_discount;
            //product_details='Get '+response[i]['discount']+'% off';
          }else{
            //product_details=response[i]['other_detail'];
          }
        }
        $('#offer_products_list').append('<div class="theme-card"><div class="row no-gutters"><div class="col-2"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 62px; " class="full-width"></div><div class="col-6" style="padding-left:5px;"><div class="title">'+product_name+'</div><div class="offer-product-price"><span class="outer"><span class="inner">Rs.'+price+'</span></span> <span class="price">Rs.'+buying_price+'</span></div><div class="qty">'+product_details+'</div></div><div class="col-4 my-auto "><a href="#" onclick="addItemToCart('+id+','+qtn+',\''+product_name+'\',\''+product_details+'\',\''+price+'\',\''+buying_price+'\',\''+selected_shop_id+'\');" class="btn-blue btn-block showqtyBox p-6" >Add To Cart</a><div class=" qtyBox" style="display:none;"><div class="increase-product float-left w-90px "><span class="minus" >-</span><span class="plus" id="plus" >+</span><input type="text" class="increase qtyProduct " value="1" id="cartItemQty'+id+'" ></div></div></div></div></div>');
      }
    }
  });
}


function getCatalogProducts(catalog_id){
  $.ajax({
    url:"AjaxGetCatalogProducts.php",
    data:{catalog_id:catalog_id,
      shop_id:selected_shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      $("#catalog_product_list").empty();
      $('#catalog_detail_num_products').text(response.length);
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var catalogue_id=response[i]['catalogue_id'];
        var product_name=response[i]['product_name'];
        var product_details=response[i]['product_description'];
        var price=response[i]['price'];
        var buying_price=response[i]['price'];
        var image=response[i]['image'];
        var qtn=1;
        if(response[i]['offer_available']==1){
          if(response[i]['offer_type']==1){
            var total_discount = ((response[i]['price']*response[i]['discount'])/100);
            buying_price = response[i]['price']-total_discount;
            //product_details='Get '+response[i]['discount']+'% off';
          }else{
            //product_details=response[i]['other_detail'];
          }
        }
        $('#catalog_product_list').append('<div class="theme-card"><div class="row no-gutters"><div class="col-2"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 62px; " class="full-width"></div><div class="col-6" style="padding-left:5px"><div class="title">'+product_name+'</div><div class="offer-product-price"><span class="outer"><span class="inner">Rs.'+price+'</span></span> <span class="price">Rs.'+buying_price+'</span></div><div class="qty">'+product_details+'</div></div><div class="col-4 my-auto "><a href="#" onclick="addItemToCart('+id+','+qtn+',\''+product_name+'\',\''+product_details+'\',\''+price+'\',\''+buying_price+'\',\''+selected_shop_id+'\');" class="btn-blue btn-block showqtyBox" >Add To Cart</a><div class=" qtyBox" style="display:none;"><div class="increase-product float-left w-90px "><span class="minus">-</span><span class="plus" id="plus">+</span><input type="text" class="increase qtyProduct " value="1" id="cartItemQty42" pattern="[0-9]*"></div></div></div></div></div>');
      }
    }
  });
}


function gotoProductDetails(id){
  //alert(id);
  
  $('#productDetailSection').show();
  $('#ShopSection').hide();
   
  $.ajax({
    url:"AjaxGetProductDetail.php",
    data:{product_id:id},
    type:'post',
    dataType: 'json',
    success:function(response){
      // console.log('gotoProductDetails:');
      // console.log(response);
      if(response['status']){
        //var id=response['id'];
        var product_name=response['product_name'];
        var images=response['images'];
        var product_description=response['product_description'];
        var price=response['price'];
        var buying_price=response['price'];
        var start_date=response['start_date'];
        var end_date=response['end_date'];
        var qtn=1;
        if(response['offer_available']==1){
          if(response['offer_type']==1){
            var total_discount = ((response['price']*response['discount'])/100);
            buying_price = response['price']-total_discount;
            product_details='Get '+response['discount']+'% off';
          }else{
            product_details=response['other_detail'];
          }
        }

        $("#product_detail_add_cart").empty();
        $("#product_detail_image_selected").empty();
        $("#product_detail_images_ul").empty();

        $('div#product_name_detail_header').text(product_name);
        $('div#product_name_detail').text(product_name);
        $('div#product_detail_buying_price').text("Rs."+buying_price);
        $("#product_detail_price").text("Rs."+price);
        $("#product_detail_description").text(product_details);
        $("#product_detail_end_date").text(toddmmyy(end_date));
        $('#product_detail_add_cart').append('<a onclick="addItemToCart1('+id+',\''+product_name+'\',\''+product_details+'\',\''+price+'\',\''+buying_price+'\',\''+selected_shop_id+'\');" class=" btn-blue btn-block add-cart-padding font-weight-bold showqtyBox">Add TO Cart</a> <div class="increase-product float-left  qtyBox" style="display:none;"><span class="minus t-11" id="minus">-</span><span class="plus t-11" id="plus">+</span><input id="product_detail_quantity" type="" name="" class="increase qtyProduct qty-padding" value="1"  pattern="[0-9]* /><input type="text"/></div>');
        
        for (var i = images.length - 1; i >= 0; i--) {
          var image = images[i]['image'];
          if(i==0){
            $('div#product_detail_image_selected').append('<img src="http://'+window.location.hostname+'/'+image+'" class="w-40">');
            $('#product_detail_images_ul').append('<li class="active"><a ><img src="http://'+window.location.hostname+'/'+image+'"></a></li>');
          }else{
            $('#product_detail_images_ul').append('<li ><a ><img src="http://'+window.location.hostname+'/'+image+'"></a></li>');
          }
        }
        
        
        
        
        //product_detail_quantity
      }
    }
  });
}

function getShopOffers(shop_id){
  $.ajax({
    url:"AjaxGetShopOffers.php",
    data:{shop_id:shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      if(response.length>0){
        $("#offer_list_title").text('');
      }else{
        $("#offer_list_title").text('No offers to show');
      }
      $("#offersSection").empty();
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var products=response[i]['products'];
        var catalogues=response[i]['catalogues'];
        var offer_name=response[i]['offer_name'];
        var offer_detail=response[i]['other_detail'];
        var start_date=response[i]['start_date'];
        var end_date=response[i]['end_date'];
        var active_status=response[i]['active_status'];
        var image=response[i]['image'];
        if(response[i]['offer_type']==1){
          offer_detail='Get '+response[i]['discount']+'% off';
        }

        $('#offersSection').append('<a href="#" onclick="gotoOfferDetail('+id+',\''+offer_name+'\',\''+offer_detail+'\',\''+end_date+'\')" class="goOfferDetail"><div ><div class="theme-card"><div class="container"><div class="row"><div ></div><div class="col-7 pr-0"><h3>'+offer_name+'</h3><b>'+offer_detail+'</b><div class="last-date">Offer End Date: '+toddmmyy(end_date)+'</div><div><a href="https://web.whatsapp.com/send?text='+window.location.href+'" target="_blank"><img src="img/share_liner.svg" class="float-left mt-2"></a><a class="btn btn-border addQty ml-12"  style="display: none">Add</a><div class="increase-product float-left" style="display: none;"><span class="minus" id="minus">-</span><span class="plus" id="plus">+</span><input type="" name="" class="increase qtyProduct" value="1" ></div></div></div><div class="col-5"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 100px; width: 100px;"></div></div></div></div></div></a>');
      }
    }
  });
}


function getShopCataloguess(shop_id){
  $.ajax({
    url:"AjaxGetShopCatalogues.php",
    data:{shop_id:shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      if(response.length>0){
        $("#catalog_list_title").text('');
      }else{
        $("#catalog_list_title").text('No catalogs to show');
      }
      $(".catalogSection").empty();
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var catalog_name=response[i]['catalog_name'];
        var catalog_detail=response[i]['catalog_detail'];
        var products=response[i]['products'];
        var active_status=response[i]['active_status'];
        var views=response[i]['views'];
        var image=response[i]['image'];
        var num_products = products.split(",");

        $('.catalogSection').append('<a href="#" onclick="gotoCatalogueDetail('+id+',\''+catalog_name+'\',\''+catalog_detail+'\')" class="gocatalogDetail"><div ><div class="theme-card"><div class="container"><div class="row"><div class="col-7 pr-0"><h3 class="f-16">'+catalog_name+'</h3><b>'+catalog_detail+'</b><div class="qty-catalogs">'+num_products.length+' Products</div><div><a href="https://web.whatsapp.com/send?text='+window.location.href+'" target="_blank"><img src="img/share_liner.svg"></a></div></div><div class="col-5"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 100px; width: 100px;"></div></div></div></div></div></a>');
      }
    }
  });
}


function getOrderList(status,search){
  cust_id = "<?php echo $user_id; ?>";
  order_status = status;
  
  if(status==0){
    $("#orders_all").addClass("active");
    $("#orders_pending").removeClass("active");
    $("#orders_ready").removeClass("active");
    $("#orders_completed").removeClass("active");
    $("#orders_cancelled").removeClass("active");
  }else if(status==1){
    $("#orders_pending").addClass("active");
    $("#orders_all").removeClass("active");
    $("#orders_ready").removeClass("active");
    $("#orders_completed").removeClass("active");
    $("#orders_cancelled").removeClass("active");
  }else if(status==2){
    $("#orders_ready").addClass("active");
    $("#orders_all").removeClass("active");
    $("#orders_pending").removeClass("active");
    $("#orders_completed").removeClass("active");
    $("#orders_cancelled").removeClass("active");
  }else if(status==3){
    $("#orders_completed").addClass("active");
    $("#orders_all").removeClass("active");
    $("#orders_pending").removeClass("active");
    $("#orders_ready").removeClass("active");
    $("#orders_cancelled").removeClass("active");
  }else if(status==4){
    $("#orders_cancelled").addClass("active");
    $("#orders_all").removeClass("active");
    $("#orders_pending").removeClass("active");
    $("#orders_ready").removeClass("active");
    $("#orders_completed").removeClass("active");
  }

  // console.log("getOrderList: "+cust_id);
  $.ajax({
    url:"AjaxGetOrderList.php",
    data:{cust_id:cust_id,
      status:status,
      search:search},
    type:'post',
    dataType: 'json',
    success:function(response){
      // console.log(response);
      $("#orderList").empty();
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var order_id=response[i]['order_id'];
        var no_items=response[i]['no_items'];
        var total_cost=response[i]['total_cost'];
        var payment_amount=response[i]['payment_amount'];
        var customer_id=response[i]['customer_id'];
        var payment_type=response[i]['payment_type'];
        var note=response[i]['note'];
        var delivery_charge=response[i]['delivery_charge'];
        var discount_amount=response[i]['discount_amount'];
        var address=response[i]['address'];
        
        
        
        var additional_cost=response[i]['additional_cost'];
        var address=response[i]['address'];
        var image=response[i]['image'];
        
        var created_at=toddmmyy(response[i]['created_at'].split(" ")[0]);
        var name=response[i]['name'];
        var mobile=response[i]['mobile'];
        var shop_name=response[i]['business_name'];
        var status1=response[i]['status'];
        var status_icon='status-pending';
        var status="";

        if(status1==1){
          status='Pending';
          status_icon='status-pending';
        }else if(status1==2){
          status='Ready';
          status_icon='status-pending';
        }else if(status1==3){
          status='Completed';
          status_icon='status-completed';
        }else if(status1==4){
          status='Cancelled';
          status_icon='status-cancelled';
        }

        
        $('#orderList').append('<a href="#" onclick="gotoOrderDetail('+id+',\''+order_id+'\',\''+no_items+'\',\''+payment_amount+'\',\''+payment_type+'\',\''+created_at+'\',\''+note+'\',\''+delivery_charge+'\',\''+discount_amount+'\',\''+address+'\',\''+status1+'\')" class="goToOrders"><div class="store-card "><div class="row no-gutters"><div class="col-3"><img src="http://'+window.location.hostname+'/'+image+'" style="height: 100px; width: 100px;" alt="store"></div><div class="col-9 store-info pb-10px"><h3>'+shop_name+'</h3><div class="'+status_icon+'"><span class="dot"></span>'+status+'</div><div class="store-info-inner"><div class="row no-gutters"><div class="col-6"><label>Order ID:</label><div class="value color-secondary">'+order_id+'</div></div><div class="col-6"><label>Placed On:</label><div class="value color-secondary">'+created_at+'</div></div></div><div class="row no-gutters"><div class="col-6"><label>No. of Items</label><div class="value color-secondary">'+no_items+'</div></div><div class="col-6"><label>Total Cost:</label><div class="value color-secondary">Rs.'+payment_amount+'</div></div></div></div></div></div></div></a>');
      }
    }
  });
}


function selectDiscount(id,promo_code,discount,min_order_amount,max_discount){
  if(total_cost_without_discount>min_order_amount){
    discount_cart = (total_cost_without_discount*discount)/100;
    if(discount_cart>max_discount){
      discount_cart=max_discount;
    }
    alert('Discount applied.');
    calculateCart();
    backFromCouponSection();
  }else{
    alert('Minimum order amount should be '+min_order_amount);
  }
}


function calculateCart(){
  // console.log("find");
  if(cust_id==0){
    cust_id = "<?php echo $user_id; ?>";
  }
  //getShopSettings();
  $('#num_item_cart').text(cart_array.length);
  
  var total_cost=0;
  $("#cart_products").empty();
  for (var i = cart_array.length - 1; i >= 0; i--) {
    cart_array[i];
    var id=cart_array[i]['id'];
    var quantity=cart_array[i]['quantity'];
    var name=cart_array[i]['name'];
    var detail=cart_array[i]['detail'];
    var price=cart_array[i]['price'];
    var buying_price=cart_array[i]['buying_price'];
    total_cost = total_cost + (buying_price*quantity);
    $('#cart_products').append('<div class="row no-gutters mt-3"><div class="col-5"><div class="dark f-16">'+name+'</div><div class="f-12">'+quantity+' pieces</div></div><div class="col-4"><div class="increase-product float-left w-90px" ><span class="minus f-25" id="minus" onClick="minusQuantityCart('+id+')">-</span><span class="plus f-25" id="plus" onClick="plusQuantityCart('+id+')">+</span><input type="text" class="increase qtyProduct no-border p-8px f-18 " value="'+quantity+'" id="cartItemQty'+id+'" pattern="[0-9]*"></div></div><div class="col-3 f-16 text-center"><span class="outer ml-6-neg"><span class="inner-green">Rs.'+price+'</span></span><div class="dark mt-5-neg">Rs.'+buying_price+'</div></div></div>');
  }

  $('div#total_item_cost_cart').text("Rs."+total_cost);
  $('div#delivery_fee_cart').text("Rs."+delivery_fee);
  $('div#discount_cart').text("Rs."+discount_cart);



  total_cost_cart=(parseFloat(total_cost)+parseFloat(delivery_fee));
  total_cost_without_discount=total_cost;
  total_cost_after_discount=total_cost_cart-parseFloat(discount_cart);
  $('div#total_cost_cart').text("Rs."+total_cost_after_discount); 
  $('div#total_cost_cart_bill').text("Rs."+total_cost_after_discount); 

  // console.log("Delivery fee: "+delivery_fee);
  // console.log("discount_cart: "+discount_cart);
  // console.log("total_cost_cart: "+total_cost_after_discount);
  // console.log("total_cost: "+total_cost);
  
  
}

function bindCartData(){

}


function getShopSettings(){
  cust_id = "<?php echo $user_id; ?>";
  getCustAddresses(cust_id);
  $.ajax({
    url:"AjaxGetShopDetail.php",
    data:{shop_id:selected_shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      // console.log('getShopSettings:');
     // console.log(response);
      if(response['status']){
        delivery_mode=response['delivery_mode'];
        min_order_value=response['min_order_value'];
        if(response['delivery_free']==0){
          delivery_fee=response['delivery_charge'];
        }else{
          delivery_fee=0;
        }
        if(delivery_mode==2){
          $("#radio_home_div").hide();
          $("#radio_pickup").prop("checked", true);
        }
        
        $('div#delivery_fee_cart').text("Rs."+delivery_fee);
        $('div#min_order_value_cart').text("Minimum order value for this shop is Rs."+min_order_value);
        calculateCart();
        var cart_total = $('div#total_item_cost_cart').html();
        if(cart_total == "Rs.0"){
          $('.cart-full').hide();
          $('.empty-cart').show();
        }else{
          $('.empty-cart').hide();
          $('.cart-full').show();
        }
      }else{
        $('.cart-full').hide();
        $('.empty-cart').show();
      }
    }
  });
}

function calcCrow(lat1, lon1, lat2, lon2){
  var R = 6371; // km
  var dLat = toRad(lat2-lat1);
  var dLon = toRad(lon2-lon1);
  var lat1 = toRad(lat1);
  var lat2 = toRad(lat2);

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c;
  return d;
}

function toRad(Value){
  return Value * Math.PI / 180;
}

function calculateDistanceTime(lat,lon){
  //alert(getLocation());
  if(current_lat!=0 && current_lon!=0){
    var distance = calcCrow(lat,lon,current_lat,current_lon).toFixed(1);
    return "Your order will be delivered in "+distance+" hrs.";
  }else{
    return "Not able to fecth current location.";
  }
  
}

function getLocation() {
  if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(showPosition);
  }else{
    search_shop("",0,0);
  }
}

function showPosition(position){
  current_lat=position.coords.latitude;
  current_lon=position.coords.longitude;
  //$("#current_address_header").text(place.formatted_address);
  getAddressFromLatLng(current_lat,current_lon);

  search_shop("",current_lat,current_lon);
}

function getAddressFromLatLng(lat,lon){
  $.ajax({
    url:"https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lon+"&sensor=true&key=AIzaSyApafGQtuvWaTvvHUCdFoGrcRgnsin4n2M",
    data:{},
    type:'get',
    dataType: 'json',
    success:function(response){
      // console.log(response);
      // console.log(response['plus_code']['compound_code']);
      var addr = response['plus_code']['compound_code'];
      var res = addr.split(" ");
      var address="";
      for (var i=1; i<res.length; i++) {
        address = address+" "+res[i];
      }

      $("#current_address_header").text(address);

      // if(response['results'].length>0){
      //   //console.log(response['results'][0]['address_components']);
      //   if(response['results'][0]['address_components'].length>0){
      //     console.log(response['results'][0]['address_components'][0]['short_name']);
      //     $("#current_address_header").text(response['results'][0]['address_components'][0]['short_name']);
      //   }
      // }
    }
  });
}

function getCustAddresses(cust_id){
  $.ajax({
    url:"AjaxGetCustAddressList.php",
    data:{cust_id:cust_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      // console.log('getCustAddresses: '+cust_id);
      // console.log(response);
      $("#cust_other_locations").empty();
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var lat=response[i]['lat'];
        var lon=response[i]['lon'];
        var address=response[i]['address'];

        if(i==0){
          $('div#delivery_address_cart').text(address); 
          $('div#delivery_time_div').text(calculateDistanceTime(lat,lon));
          $("#delivery_address_map_link").attr("href", "https://www.google.com/maps/dir/?api=1&destination="+lat+","+lon);
          
          selected_delivery_address=address;
        }
        $('#cust_other_locations').append('<div class="divider"></div><a onclick="selectAddress(\''+address+'\',\''+lat+'\',\''+lon+'\')" href="#"><div class="app-section pl-20px"><div class="row no-gutters"><div class="col-1 my-auto"><img src="img/location_border.svg">&nbsp;&nbsp;&nbsp;</div><div class="col-9"><span class="font-15 dark">#Address'+id+'</span><div class="f-14">'+address+'</div><div class="time">2 hrs</div></div><div class="col-2 my-auto"><img src="img/delete.svg"/><img src="img/g.svg" class="pencil"/></div></div></div></a>');

        $('#address_profile_cust').append('<div class="divider"></div><a onclick="selectAddress(\''+address+'\',\''+lat+'\',\''+lon+'\')" href="#"><div class="app-section pl-20px"><div class="row no-gutters"><div class="col-1 my-auto"><img src="img/location_border.svg">&nbsp;&nbsp;&nbsp;</div><div class="col-9"><span class="font-15 dark">#Address'+id+'</span><div class="f-14">'+address+'</div><div class="time"></div></div><div class="col-2 my-auto"><img src="img/delete.svg"/><img src="img/g.svg" class="pencil"/></div></div></div></a>');
      }
    }
  });
}

function selectAddress(address,lat,lon){
  cust_id = "<?php echo $user_id; ?>";

  $('div#delivery_address_cart').text(address); 
  $('div#delivery_time_div').text(calculateDistanceTime(lat,lon));
  $("#delivery_address_map_link").attr("href", "https://www.google.com/maps/dir/?api=1&destination="+lat+","+lon);
          

  selected_delivery_address=address;
  $('#locationModal').modal('hide');
  
  $.ajax({
    url:"AjaxUpdateCustSelectedAddress.php",
    data:{cust_id:cust_id,
      address:address},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log(response);
    }
  });
}

function getDiscountCoupons(){
  //alert('offer');
  $.ajax({
    url:"AjaxGetDiscountCoupons.php",
    data:{cust_id:cust_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log(response);
      $("#discount_coupon_list").empty();
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var promo_code=response[i]['promo_code'];
        var title=response[i]['title'];
        var description=response[i]['description'];
        var discount=response[i]['discount'];
        var min_order_amount=response[i]['min_order_amount'];
        var max_discount=response[i]['max_discount'];

        $('#discount_coupon_list').append('<div class="page-container"><div class="coupon-card"><div class="row"><div class="col-5 pr-0"><div class="coupon f-14">'+promo_code+'</div></div><div onclick="selectDiscount('+id+',\''+promo_code+'\',\''+discount+'\',\''+min_order_amount+'\',\''+max_discount+'\')" class="col-6 pl-10px my-auto"><img src="img/applycode_icon_unselect.svg" class="applyCode"></div></div><div class="f-14 dark mt-2">Get '+discount+'% discount on order above Rs.'+min_order_amount+'</div><div class="contain-divider"></div><div class="f-13">Use code '+promo_code+' and get '+discount+'% discount up to Rs.'+max_discount+' on order above Rs.'+min_order_amount+' </div></div></div><div class="divider"></div>');
      }
    }
  });
}


function backFromCouponSection(){
  $('#offersCouponSection').hide();
  $('#cartSection').show();
}

function getTutorialVideos(){
  //alert('offer');
  $.ajax({
    url:"AjaxGetTutorialVideos.php",
    data:{cust_id:cust_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log(response);
      $("#tutorial_videos_list").empty();
      $('div#tutorial_videos_nums').text(response.length+" Videos"); 
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var title=response[i]['title'];
        var url1=response[i]['url'];
        var description=response[i]['description'];
        var duration=response[i]['duration'];
        
        $('#tutorial_videos_list').append('<div class="row mb-1 "><div class="col-6 pl-9"><img src="img/video.png" ></div><div class="col-6 my-auto pl-0"><div class="f-14"> '+description+'</div><div class="f-12 gray">'+title+'</div></div></div>');
      }
    }
  });
}


function addShopFav(shop_id){
  //alert(shop_id);
  cust_id = "<?php echo $user_id; ?>";
  $.ajax({
    url:"AjaxAddShopFav.php",
    data:{cust_id:cust_id,
      shop_id:shop_id},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log(response);
      //alert(response['message']);
      if(response['status']){

      } 
    }
  });
}

function filter_shop(){
  //alert('filter shop');
  cust_id = "<?php echo $user_id; ?>";
  var delivery_charge = filter_minimum_delivery_charge;
  var distance_filter = filter_delivery_distance;
  var shop_category_filter = $('#shop_category_filter').val();
  var shop_type_filter = $('#shop_type_filter').val();
  
  var payment_type=1;
  var delivery_type=1;

  if($('#radio_online_filter').is(':checked')) {
    payment_type=2;
  }else if($('#shop_payment_both_filter').is(':checked')){
    payment_type=3;
  }
  if($('#radio_pickup_filter').is(':checked')) {
    delivery_type=2;
  }else if($('#delivery_filter_both').is(':checked')) {
    delivery_type=3;
  }
  
//alert(distance_filter);
  $.ajax({
    url:"AjaxGetShopList.php",
    data:{cust_id:cust_id,
      delivery_charge:delivery_charge,
      distance_filter:distance_filter,
      payment_type:payment_type,
      delivery_type:delivery_type,
      shop_category_filter:shop_category_filter,
      shop_type_filter:shop_type_filter,
      lat:current_lat,
      lon:current_lon},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log(response);
      $("#home").empty();
      $("#menu1").empty();
      
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var business_name=response[i]['business_name'];
        var tagline=response[i]['tagline'];
        var category=response[i]['category'];
        var shop_type=response[i]['shop_type'];
        var shop_image=response[i]['shop_image'];
        var shop_cover_image=response[i]['shop_cover_image'];
        var payment_type=response[i]['payment_type'];
        var delivery_mode=response[i]['delivery_mode'];
        var delivery_free=response[i]['delivery_free'];
        var delivery_charge=response[i]['delivery_charge'];
        var min_order_value=response[i]['min_order_value'];
        var max_delivery_distance=response[i]['max_delivery_distance'];
        var distance=response[i]['distance'];
        var delivery_time=response[i]['delivery_time'];
        var active_status=response[i]['active_status'];
        var address=response[i]['address'];
        var mobile=response[i]['mobile'];
        var fav=response[i]['fav'];

        var fav_icon='<img src="img/like_blank.svg" alt="like" class="like_blank likeThis" onclick="addShopFav('+id+');">';
        if(fav==1){
          fav_icon='<img src="img/liked.svg" alt="like" class="like_blank likeThis" onclick="addShopFav('+id+');">'
        }
        if(shop_type==1){
          shop_type='Retailer';
        }else{
          shop_type='Wholesale';
        }

        if(delivery_mode==1){
          delivery_mode='Available';
        }else if(delivery_mode==3){
          delivery_mode='Available';
        }else{
          delivery_mode='Unavailable';
        }

        if(payment_type==1){
          payment_type='Cash';
        }else if(payment_type==2){
          payment_type='Online';
        }else{
          payment_type='Cash/Online';
        }

        if(shop_image==""){
            var items = ['shopcover1','shopcover2','shopcover3','shopcover4'];
            var item = items[Math.floor(Math.random() * items.length)];
            var pathName = window.location.pathname;
            mainDirectory = pathName.split("/","2");
            //console.log(item);
            shop_image = window.location.protocol+'//'+window.location.hostname+'/BajarSe/'+item+'.png';
          //shop_image="https://assets1.progressivegrocer.com/files/styles/content_sm/s3/2020-01/Stop%20%26%20Shop%20MASS.jpg";
        }else{
          shop_image='http://'+window.location.hostname+'/BajarSe/'+shop_image;
        }

        
        $('#home').append(fav_icon+'<a class="goShop" onclick="selectShop('+id+',\''+shop_cover_image+'\',\''+business_name+'\',\''+address+'\',\''+mobile+'\');"><div class="store-card"><div class="row no-gutters"><div class="col-4"><img src="'+shop_image+'" style="height: 100px; width: 100px;" alt="store"></div><div class="col-8 store-info"><h3>'+business_name+'</h3><div class="store-info-inner"><div class="row no-gutters"><div class="col-6"><label>Shop Category</label><div class="value">'+category+'</div></div><div class="col-6"><label>Shop Type</label><div class="value">'+shop_type+'</div></div></div><div class="row no-gutters "><div class="col-6"><label>Min. Order</label><div class="value">Rs.'+min_order_value+'</div></div><div class="col-6"><label>Distance</label><div class="value">'+distance+' km</div></div></div><div class="row no-gutters "><div class="col-6"><p class="orange f-12">Delivery Charges: Rs.'+delivery_charge+'</p></div><div class="col-6">Home Delivery <span class="green font-weight-bold">'+delivery_mode+'</span></div></div></div></div></div><div class="divider"></div><div class="row no-gutters f-12 p-8 gray-dark plr-0 "><div class="col-7 ">Payment mode: <b> '+payment_type+'</b></div></div></div></a>');

        if(fav==1){
          $('#menu1').append(fav_icon+'<a class="goShop" onclick="selectShop('+id+',\''+shop_cover_image+'\',\''+business_name+'\',\''+address+'\',\''+mobile+'\');"><div class="store-card"><div class="row no-gutters"><div class="col-4"><img src="http://'+window.location.hostname+'/'+shop_image+'" style="height: 100px; width: 100px;" alt="store"></div><div class="col-8 store-info"><h3>'+business_name+'</h3><div class="store-info-inner"><div class="row no-gutters"><div class="col-6"><label>Shop Category</label><div class="value">'+category+'</div></div><div class="col-6"><label>Shop Type</label><div class="value">'+shop_type+'</div></div></div><div class="row no-gutters "><div class="col-6"><label>Min. Order</label><div class="value">Rs.'+min_order_value+'</div></div><div class="col-6"><label>Distance</label><div class="value">'+distance+' km</div></div></div><div class="row no-gutters "><div class="col-6"><p class="orange f-12">Delivery Charges: Rs.'+delivery_charge+'</p></div><div class="col-6">Home Delivery <span class="green font-weight-bold">'+delivery_mode+'</span></div></div></div></div></div><div class="divider"></div><div class="row no-gutters f-12 p-8 gray-dark plr-0 "><div class="col-7 ">Payment mode: <b> '+payment_type+'</b></div></div></div></a>');
        }
        
      }
    }
  });


  $('#shopFilterModal').modal('hide');
}


function search_shop(search,lat,lon){
  
  cust_id = "<?php echo $user_id; ?>";
  //alert(search);

  $.ajax({
    url:"AjaxSearchShopList.php",
    data:{cust_id:cust_id,
      search:search,
      lat:lat,
      lon:lon},
    type:'post',
    dataType: 'json',
    success:function(response){
      //console.log("Response = "+response);
      $("#home").empty();
      $("#menu1").empty();
      
      for (var i = response.length - 1; i >= 0; i--) {
        var id=response[i]['id'];
        var business_name=response[i]['business_name'];
        var tagline=response[i]['tagline'];
        var category=response[i]['category'];
        var shop_type=response[i]['shop_type'];
        var shop_image=response[i]['shop_image'];
        var shop_cover_image=response[i]['shop_cover_image'];
        var payment_type=response[i]['payment_type'];
        var delivery_mode=response[i]['delivery_mode'];
        var delivery_free=response[i]['delivery_free'];
        var delivery_charge=response[i]['delivery_charge'];
        var min_order_value=response[i]['min_order_value'];
        var max_delivery_distance=response[i]['max_delivery_distance'];
        var distance=response[i]['distance'];
        var delivery_time=response[i]['delivery_time'];
        var active_status=response[i]['active_status'];
        var address=response[i]['address'];
        var mobile=response[i]['mobile'];
        var fav=response[i]['fav'];
        // console.log(id);
        // console.log(shop_cover_image);
        // console.log(business_name);
        // console.log(address);
        // console.log(mobile);

        var fav_icon='<img src="img/like_blank.svg" alt="like" class="like_blank likeThis" onclick="addShopFav('+id+');">';
        if(fav==1){
          fav_icon='<img src="img/liked.svg" alt="like" class="like_blank likeThis" onclick="addShopFav('+id+');">';
        }
        if(shop_type==1){
          shop_type='Retailer';
        }else{
          shop_type='Wholesale';
        }

        if(delivery_mode==1){
          delivery_mode='Available';
        }else if(delivery_mode==3){
          delivery_mode='Available';
        }else{
          delivery_mode='Unavailable';
        }

        if(payment_type==1){
          payment_type='Cash';
        }else if(payment_type==2){
          payment_type='Online';
        }else{
          payment_type='Cash/Online';
        }

        if(shop_image==""){
           var items = ['shopcover1','shopcover2','shopcover3','shopcover4'];
            var item = items[Math.floor(Math.random() * items.length)];
            var pathName = window.location.pathname;
            mainDirectory = pathName.split("/","2");
            //console.log(item);
            shop_image = window.location.protocol+'//'+window.location.hostname+'/BajarSe/'+item+'.png';
          //shop_image="https://assets1.progressivegrocer.com/files/styles/content_sm/s3/2020-01/Stop%20%26%20Shop%20MASS.jpg";
        }else{
          shop_image='http://'+window.location.hostname+'/BajarSe/'+shop_image;
        }

        
        $('#home').append(fav_icon+'<a class="goShop" onclick="selectShop('+id+',\''+shop_cover_image+'\',\''+business_name+'\',\''+address+'\',\''+mobile+'\');"><div class="store-card"><div class="row no-gutters"><div class="col-4"><img src="'+shop_image+'" style="height: 100px; width: 100px;" alt="store"></div><div class="col-8 store-info"><h3>'+business_name+'</h3><div class="store-info-inner"><div class="row no-gutters"><div class="col-6"><label>Shop Category</label><div class="value">'+category+'</div></div><div class="col-6"><label>Shop Type</label><div class="value">'+shop_type+'</div></div></div><div class="row no-gutters "><div class="col-6"><label>Min. Order</label><div class="value">Rs.'+min_order_value+'</div></div><div class="col-6"><label>Distance</label><div class="value">'+distance+' km</div></div></div><div class="row no-gutters "><div class="col-6"><p class="orange f-12">Delivery Charges: Rs.'+delivery_charge+'</p></div><div class="col-6">Home Delivery <span class="green font-weight-bold">'+delivery_mode+'</span></div></div></div></div></div><div class="divider"></div><div class="row no-gutters f-12 p-8 gray-dark plr-0 "><div class="col-7 ">Payment mode: <b> '+payment_type+'</b></div></div></div></a>');

        if(fav==1){
          $('#menu1').append(fav_icon+'<a class="goShop" onclick="selectShop('+id+',\''+shop_cover_image+'\',\''+business_name+'\',\''+address+'\',\''+mobile+'\');"><div class="store-card"><div class="row no-gutters"><div class="col-4"><img src="http://'+window.location.hostname+'/'+shop_image+'" style="height: 100px; width: 100px;" alt="store"></div><div class="col-8 store-info"><h3>'+business_name+'</h3><div class="store-info-inner"><div class="row no-gutters"><div class="col-6"><label>Shop Category</label><div class="value">'+category+'</div></div><div class="col-6"><label>Shop Type</label><div class="value">'+shop_type+'</div></div></div><div class="row no-gutters "><div class="col-6"><label>Min. Order</label><div class="value">Rs.'+min_order_value+'</div></div><div class="col-6"><label>Distance</label><div class="value">'+distance+' km</div></div></div><div class="row no-gutters "><div class="col-6"><p class="orange f-12">Delivery Charges: Rs.'+delivery_charge+'</p></div><div class="col-6">Home Delivery <span class="green font-weight-bold">'+delivery_mode+'</span></div></div></div></div></div><div class="divider"></div><div class="row no-gutters f-12 p-8 gray-dark plr-0 "><div class="col-7 ">Payment mode: <b> '+payment_type+'</b></div></div></div></a>');
        }
      }
    }
  });
}



function toddmmyy(date){
  var res = date.split("-");
  return res[2]+"/"+res[1]+"/"+res[0];
}

$('#ex2').slider({
  formatter: function(value) {
    filter_delivery_distance=value;
    return  value +' Km';
  }
});

$('#ex1').slider({
  formatter: function(value) {
    filter_minimum_delivery_charge=value;
    return  value+' Rs';
  }
});




$(document).on('click', '.showBox', function(m){
  m.stopPropagation();
  alert('sadasdas');
  
});


$(document).on('click', '#ViewAdditionalbtn', function(){
  
 $('#noItemsDiv').toggle();
  
});


$(document).on('click', '#clearAll', function(){
      
      $('#delivery_filter_both').prop('checked', true);
      $('#shop_payment_both_filter').prop('checked', true);
      
      $('#shop_category_filter').prop("selectedIndex", 0)
      $('#shop_type_filter').prop("selectedIndex", 0)
      
      $("#ex1").slider('setValue', '100000'); 
      $("#ex2").slider('setValue', '10000');
      filter_minimum_delivery_charge=1000;
      filter_delivery_distance=10000;
   });
</script>
<script type="text/javascript">
 
// $('#storesList').hide();
//       $('#ShopSection').show();
  $(document).ready(function(){
    var pageURL = window.location.href;
    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('name');
    //console.log("Params ="+myParam);
    if(myParam){
      var id_params = myParam.split('?');
      var shop_id = id_params['1'];

      $.ajax({
          url:"AjaxGetShopDetail.php",
          data:{shop_id:shop_id},
          type:'post',
          dataType: 'json',
          success:function(response){
        // console.log('getShopSettings:');
        // console.log(response);
        // console.log(response.shop_name);
          $('#storesList').hide();
          $('#ShopSection').show();
        selectShop(shop_id,response.shop_cover_image,response.shop_name,response.shop_address,response.shop_mobile_no);
      }
      });
    }
  });
</script>







    </body>
</html>
