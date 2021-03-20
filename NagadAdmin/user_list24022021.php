<?php include('header.php');?>
<?php include('left_side_bar.php');?>

<?php

  $sql="SELECT id,name,business_name,category,address,mobile,email,active,created_at FROM users";
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Election</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">





</head>
<body class="hold-transition skin-blue sidebar-mini">



<div class="wrapper">





  
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
        User List
      </h1>

      <!-- <button id="show">show</button> -->

      <button style="display: none" type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#send_notification" style="margin-right: 10px;">Send Notification<i class="fa fa-plus-circle"></i></button>
     
    </section>

    <!-- Main content -->
    <section class="content">




  <div class="modal fade" id="send_notification" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Notification Detail</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">

          <div class="row">
            <div class="col-md-1"><i class="fa fa-user"></i></div>
            <div class="col-md-9"><input type="text" name="title" id="title" placeholder="Title"></div>
          </div>
          <hr/>
           <div class="row">
            <div class="col-md-1"><i class="fa fa-user"></i></div>
            <div class="col-md-9"><input type="text" name="message" id="message" placeholder="Message"></div>
          </div>
          <!-- <hr/>
          <div class="row">
            <div class="col-md-1"><i class="fa fa-user"></i></div>
            <div class="col-md-9">
              <select style="width:150px;" class="form-control" id="user_type" name="user_type">
                <option value="0">All Users</option>
                <option value="1">Vendors</option>
                <option value="2">Customers</option>
              </select>
            </div>
          </div> -->

        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn" onclick="sendNotification();">Submit</button>
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
                  <th>Name</th>
                  <th>Business Name</th>
                  <th>Category</th>
                  <th>Address</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Active</th>
                  <th>Create Time</th>
                </tr>
                </thead>
                <tbody>


                <?php
foreach ($data as $key => $item){
        $id = $item['id'];
        $count=$key+1;

        echo'<tr id="'.$id.'">'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$item['name'].'</td>';
        echo'<td>'.$item['business_name'].'</td>';
        echo'<td>'.$item['category'].'</td>';
        echo'<td>'.$item['address'].'</td>';
        echo'<td>'.$item['mobile'].'</td>';
        echo'<td>'.$item['email'].'</td>';
        if($item['active']==1){
          echo'<td>Active</td>';
        }else{
          echo'<td>Deactive</td>';
        }
        
        echo'<td>'.$item['created_at'].'</td>';
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
  
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
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
  
$('#select_username').on('change', function() {
  if(this.value=="new"){
    $("#div_username").show();
  }else{
    $("#div_username").hide();
    $("#username").val("");
  }
});


function showAssemblyUserModal(assemblyNumber){
  $("#assembly_number").val(assemblyNumber);
  $('#select_username').empty();
  $('#select_username').append("<option value='new'>New</option>");
  $.ajax({
    url:"AjaxGetAssemblyUserList.php",
    data:{AssemblyNumber:assemblyNumber},
    type:'post',
    success:function(response){
      console.log(response);
      var arr = JSON.parse(response);
      if(arr.length>0){
         arr.forEach(function(data){
            $('#select_username').append($("<option/>", {value: data.username,text: data.username}));
         });
      }
    }
  });
}

function sendNotification(){
  var title = $("#title").val();
  var message = $("#message").val();

  if(title==""){
    alert('Please Enter Title');
    return false;
  }
  if(message==""){
    alert('Please Enter Message');
    return false;
  }

  $.ajax({
    url:"AjaxSendNotification.php",
    data:{title:title,
      message:message},
    type:'post',
    dataType: 'json',
    success:function(response){
      var message = response['message'];
      var status = response['status'];
      alert(message);
      if(status){
        location.reload();
      }
    }
  });
}

function changeUserActive(userid,active_status){
  $.ajax({
    url:"AjaxChangeUserActive.php",
    data:{UserId:userid,
      ActiveStatus:active_status},
    type:'post',
    dataType: 'json',
    success:function(response){
      console.log(response);
      var message = response['Message'];
      var status = response['Status'];
    }
  });
}

function updateUser(){
  var username = $("#update_username").val();
  var password = $("#update_password").val();
  var userType = $( "#update_user_type" ).val();
  var userid = $("#update_userid").val();

  if(username==""){
    alert('Please Enter Username');
    return false;
  }
  if(password==""){
    alert('Please Enter Password');
    return false;
  }

  $.ajax({
    url:"AjaxUpdateUser.php",
    data:{UserName:username,
      Password:password,
      UserType:userType,
      UserId:userid},
    type:'post',
    dataType: 'json',
    success:function(response){
      var message = response['Message'];
      var status = response['Status'];
      alert(message);
      //$('#update_user_model').modal('hide');

      $("#update_user_model").hide();
      $('body').css('overflow-y', 'scroll')
    }
  });

}

function editUser(userid, username, userType){
  $("#update_username").val(username);
  $("#update_userid").val(userid);
  $("#update_user_type").val(userType);
  showUpdateUserModal();
}

function deleteUser(userid){
  $.ajax({
    url:"AjaxDeleteUser.php",
    data:{UserId:userid},
    type:'post',
    dataType: 'json',
    success:function(response){
      var message = response['Message'];
      var status = response['Status'];
      alert(message);
      $('#'+userid).remove();
    }
  });
}


$("#show").click(function(){
  $("#shubham").show();
  $('body').css('overflow-y', 'hid')
});

$("#hide").click(function(){
  $("#create_user_model").hide();
  $('body').css('overflow-y', 'scroll')
});

$("#hide2").click(function(){
  $("#update_user_model").hide();
  $('body').css('overflow-y', 'scroll')
});


function showCreateUserModal(){
  $("#create_user_model").show();
  $('body').css('overflow-y', 'hid')
}

function showUpdateUserModal(){
  $("#update_user_model").show();
  $('body').css('overflow-y', 'hid')
}


</script>
</body>
</html>
