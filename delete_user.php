<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  if(isset($_POST['btn_delete_users'])){
  
    $delete_l_id = $_POST['id'];
       $query  = "DELETE FROM users WHERE id = '{$delete_l_id}'";
       if($db->query($query)){

      $session->msg("s","User deleted.");
      redirect('users.php');
  } else {
      $session->msg("d","User deletion failed Or Missing Prm.");
      redirect('users.php');
  }
}
?>




<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="card h-100">
      <div class="card-header">
         <h2>Delete User</h2>
        <form action="delete_user.php" method="POST">
            <div class="card-body">
              <p>Are you sure you want to delete this Account ?</p>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                
                </div>
                <input type="submit" name="btn_delete_users" value="Yes" class="btn btn-primary">
                <a href="users.php" class="btn btn-danger">Cancel</a>  
          </form>
      </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>