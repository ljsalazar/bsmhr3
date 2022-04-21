<?php
  $page_title = 'Users Log';
  require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
//pull out all user form database
 $all_users = find_all_user();
 $ip = $_SERVER['REMOTE_ADDR']; //client IP
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
        <h2>Users Log</h2>
         <div class="pull-right">
         
         </div>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered"> datatablesSimple-->
          <table id="datatablesSimple" class="table table-striped data-table" style="width:100%"">
            <thead>
              <tr>
              <th class="text-center" style="width: 50px;">#</th>
                <th>Name </th>
                <th>Username</th>
                <th class="text-center">User Role</th>
                <th class="text-center">Last Login </th>
                <th>IP Address </th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($all_users as $a_user): ?>
          <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
                <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
                <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name']))?></td>
                <td class="text-center"><?php $posting_date = date("F j, Y - g:i a", strtotime($a_user['last_login'])); echo $posting_date; ?></td>
                <td><?php echo remove_junk($ip)?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>

      </div>
    </div>
  </div>
  <!--This script is for the datagrid tables...-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="dist/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="dist/js/datatables-simple-demo.js"></script>

  <?php include_once('layouts/footer.php'); ?>