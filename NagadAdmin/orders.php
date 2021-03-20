<?php include('header.php');

$sql="SELECT orders.order_id,orders.id,orders.payment_amount,orders.delivery_charge,orders.discount_amount,orders.status,orders.address,orders.created_at as orderDate,shop_setting.business_name,customers.name,customers.email,customers.mobile FROM `orders` JOIN shop_setting ON shop_setting.id = orders.shop_id JOIN customers ON customers.id = orders.customer_id ORDER BY orders.id DESC";
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
  
  if(isset($_POST['create_csv'])){
    //echo "find";
    $csv_data = [];

    foreach ($data as $key => $item){
        $id = $item['id'];
        $count=$key+1;
        if($item['status']==1){
          $status = 'Pending';
        }elseif($item['status']==2){
          $status = 'Ready';
        }elseif($item['status']==3){
          $status = 'Complete';
        }elseif($item['status']==3){
          $status = 'Cancel';
        }
        $new = [$count,$item['order_id'],$item['business_name'],$item['name'],$item['email'],$item['mobile'],$item['address'],$item['payment_amount'],$item['delivery_charge'],$item['discount_amount'],$item['orderDate'],$status];
        array_push($csv_data,$new);
      }
    ob_end_clean();
    ob_start();

  
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="orders.csv"');
     
    // do not cache the file
    header('Pragma: no-cache');
    header('Expires: 0');
     
    // create a file pointer connected to the output stream
    $file = fopen('php://output', 'w');
    // send the column headers
    fputcsv($file, array('#','Order ID', 'Seller Name', 'Customer Name','Customer Email','Customer mobile no', 'Customer Address', 'Payment Amount','Delivery Charge','Discount','Order Date','Status'));
     
    // output each row of the data
    foreach ($csv_data as $row)
    {
    fputcsv($file, $row);
    }
     
    exit();
    // code 

    ob_end_flush();
  }



?>
<?php include('left_side_bar.php');?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Nagad</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<style type="text/css">
  .content-wrapper{
    height:100% !important;
  }
  input.btn.btn-primary {
    float: right;
  }
</style>



</head>
<body class="hold-transition skin-blue sidebar-mini">



<div class="wrapper">





  
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
        Order Details
      </h1>
      <form method="POST">
       <input type="submit" name="create_csv" class="btn btn-primary" value="Create CSV">
      </form>
      <!-- <button id="show">show</button> -->
     
    </section>

    <!-- Main content -->
    <section class="content">


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="product-table table table-bordered text-center">
          <thead>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Quantity</th>
          </thead>
          <tbody class="tb-body">
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<section class="content">
      <div class="row">
        <div class="">

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class=" table table-bordered table-striped">
                <thead>
                <tr>

                  <th style="width: 10px">#</th>
                  <th>Order ID</th>
                  <th>Seller Name</th>
                  <th>Customer Details</th>
                  <th>Customer Address</th>
                  <th>Payment Amount</th>
                  <th>Delivery Charge</th>
                  <th>Discount</th>
                  <th>Order Date</th>
                  <th>Status</th>
                  <th>View Details</th>
                </tr>
                </thead>
                <tbody>


                <?php
foreach ($data as $key => $item){
        $id = $item['id'];
        $count=$key+1;

        echo'<tr id="'.$id.'">'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$item['order_id'].'</td>';
        echo'<td>'.$item['business_name'].'</td>';
        echo'<td>'.$item['name'].'<br>'.$item['email'].'<br>'.$item['mobile'].'</td>';
        echo'<td>'.$item['address'].'</td>';
        echo'<td>'.$item['payment_amount'].'</td>';
        echo'<td>'.$item['delivery_charge'].'</td>';
        echo'<td>'.$item['discount_amount'].'</td>';
        echo'<td>'.$item['orderDate'].'</td>';
        if($item['status']==1){
          echo'<td>Pending</td>';
        }elseif($item['status']==2){
          echo'<td>Ready</td>';
        }elseif($item['status']==3){
          echo'<td>Complete</td>';
        }elseif($item['status']==4){
          echo'<td>Cancel</td>';
        }
        echo'<td><buttton class="btn btn-primary" onclick="viewDetails('.$id.',this)" data-toggle="modal" data-target="#exampleModal">View</button></td>';
        echo'</tr>';?>
<?php } ?>

              </tbody>
               
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>


     
    </section>

  </div>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jQuery/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="plugins/jQuery/raphael-min.js"></script>

<!-- daterangepicker -->
<script src="plugins/jQuery/moment.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script type="text/javascript">

$(function () {
    $("#example1").DataTable();
  });

</script>

<script type="text/javascript">
  
$('#select_username').on('change', function() {
  if(this.value=="new"){
    $("#div_username").show();
  }else{
    $("#div_username").hide();
    $("#username").val("");
  }
});


function viewDetails(id,parms){
 
  var _this = parms;
  $.ajax({
    url:"OrderProductsDetails.php",
    data:{orderID:id},
    type:'post',
    dataType: 'json',
    success:function(response){
      // console.log(response);
      // console.log(response.length);
      var new_html = '';
      for(var i=0;i<response.length;i++){
        var pathName = window.location.pathname;
         mainDirectory = pathName.split("/","2");
        // console.log(window.location.protocol+'//'+window.location.hostname+'/'+mainDirectory[1]+'/'+response[i].product_image);
        new_html +='<tr><td><img src="'+window.location.protocol+'//'+window.location.hostname+'/'+mainDirectory[1]+'/'+response[i].product_image+'" alt="product image"></td><td>'+response[i].product_name+'</td><td>'+response[i].product_quantity+'</td></tr>';

      }
      $('.product-table').children('.tb-body').html(new_html);
    }
  });
}



</script>
</body>
</html>
