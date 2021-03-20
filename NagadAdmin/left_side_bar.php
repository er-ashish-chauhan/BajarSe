<style>
  body {
    padding: 0px !important;
}
</style>
<?php 


$classUsers = "treeview";
$classCustomers = "treeview";
$classBankDetail = "treeview";
$classTransactions = "treeview";
$classOffers = "treeview";
$classNotifications = "treeview";



if($_SERVER['PHP_SELF']=="/user_list.php"){
  $classUsers="treeview active";
}
else if($_SERVER['PHP_SELF']=="/customers.php"){
  $classCustomers="treeview active";
}
else if($_SERVER['PHP_SELF']=="/bank_details.php"){
  $classBankDetail="treeview active";
}
else if($_SERVER['PHP_SELF']=="/transactions.php"){
  $classTransactions="treeview active";
}
else if($_SERVER['PHP_SELF']=="/offers.php"){
  $classOffers="treeview active";
}
else if($_SERVER['PHP_SELF']=="/notifications.php"){
  $classNotifications="treeview active";
}


?>


<div class="container">
 
 
  <div class="modal fade" id="change-password-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Your Password</h4>
        </div>
        <div class="modal-body">
          <div class="theme-form">

          <div class="row mt-15">
           
            <div class="col-md-12">
             <label>Current Password</label>
             <i class="fa fa-lock form-inner-icon"></i>
             <input type="text" class="form-control" id="old_password">
            </div>

             <div class="col-md-12">
             <label>New Password</label>
             <i class="fa fa-lock form-inner-icon"></i>
             <input type="text" class="form-control" id="new_password">
            </div>

            <div class="col-md-12">
             <label>Re-enter New Password</label>
             <i class="fa fa-lock form-inner-icon"></i>
             <input type="text" class="form-control" id="new_password_confirm">
            </div>


          </div>
        
          </div>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn theme-btn btn-default" id="password_submit">Save Changes</button></center>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


<aside class="main-sidebar">
   
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image admin-img " style="">
          
          <!-- <img src="dist/img/mobile.png" /> -->
          <div class="admin-name">
          <p>Nagad</p>
         
        </div>
        </div>

        <hr/>

        <div ></div>

      </div>
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      
        
        


        <li class="<?php echo $classUsers; ?>">
          <a href="user_list.php">
            <i class="fa fa-check-circle-o"></i> 
            <span>Users</span>
          </a>
        </li>
        <li class="<?php echo $classCustomers; ?>">
          <a href="customers.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Customers</span>
          </a>
        </li>
        <li class="<?php echo $classBankDetail; ?>">
          <a href="bank_details.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Bank Details</span>
          </a>
        </li>
        <li class="<?php echo $classTransactions; ?>">
          <a href="transactions.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Transactions</span>
          </a>
        </li>
        <li class="<?php echo $classOffers; ?>">
          <a href="offers.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Offers</span>
          </a>
        </li>
        <li class="<?php echo $classNotifications; ?>">
          <a href="notifications.php">
            <i class="fa fa-check-circle-o"></i>
            <span>Notifications</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
