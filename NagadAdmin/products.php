<?php
  include('header.php');


  $sql="SELECT products.*,shop_setting.business_name,users.name,offers.offer_name FROM `products` JOIN shop_setting ON shop_setting.id = products.shop_id JOIN users ON users.id = products.user_id JOIN offers ON offers.id = products.offer_id ORDER BY products.id DESC";
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
  
   if(isset($_POST['create_csv'])){
    //echo "find";
    $csv_data = [];

    foreach ($data as $key => $item){
        $id = $item['id'];
        $count=$key+1;
        if($item['active_status']==1){
          $status = 'Active';
        }elseif($item['active_status']==2){
          $status = 'Inactive';
        }elseif($item['active_status']==3){
          $status = 'Archieve';
        }
        $new = [$count,$item['product_name'],$item['product_description'],$item['price'],$item['offer_name'],$item['business_name'],$status];
        array_push($csv_data,$new);
      }
    ob_end_clean();
    ob_start();

  
    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="products.csv"');
     
    // do not cache the file
    header('Pragma: no-cache');
    header('Expires: 0');
     
    // create a file pointer connected to the output stream
    $file = fopen('php://output', 'w');
     
    // send the column headers
    fputcsv($file, array('#','Product Name', 'Description', 'Price', 'Offer Applied', 'Seller Details','Status'));
     
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
        Products 
      </h1>
      <form method="POST">
       <input type="submit" name="create_csv" class="btn btn-primary" value="Create CSV">
      </form>
      <!-- <button id="show">show</button> -->
     
    </section>

    <!-- Main content -->
    <section class="content">
      
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
                  <th>Product Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Offer Applied</th>
                  <th>Seller Details</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>


                <?php
foreach ($data as $key => $item){
        $id = $item['id'];
        $count=$key+1;

        echo'<tr id="'.$id.'">'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$item['product_name'].'</td>';
        echo'<td>'.$item['product_description'].'</td>';
        echo'<td>'.$item['price'].'</td>';
        echo'<td>'.$item['offer_name'].'</td>';
        echo'<td>'.$item['business_name'].'</td>';
        if($item['active_status']==1){
          echo'<td>Active</td>';
        }elseif($item['active_status']==2){
          echo'<td>Inactive</td>';
        }elseif($item['active_status']==3){
          echo'<td>Archieve</td>';
        }
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
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });

</script>

<script type="text/javascript">
  

</script>
</body>
</html>
