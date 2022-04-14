<?php
  $page_title = 'Admin | Leave Details ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php
//code for update the read notification status...// 
// $isread=1;
// $did=intval($_GET['id']);  
// date_default_timezone_set('Asia/Manila');
// $l_admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
// $sql="UPDATE tblleaves SET IsRead='{$isread}' WHERE id='{$did}'";
// $result = $db->query($sql);


    // code for action taken on leave
    if(isset($_POST['update']))
    { 
      $req_fields = array('remarks','status');
      validate_fields($req_fields);
      if(empty($errors)){
     $l_remarks  = remove_junk($db->escape($_POST['remarks']));
     $l_status = remove_junk($db->escape($_POST['status']));
     $l_id = remove_junk($db->escape($_POST['id']));
    date_default_timezone_set('Asia/Manila');
    $l_admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));

    //SQL statement....
    $query ="UPDATE tblleaves SET";
    $query.=" AdminRemark='{$l_remarks}',Status='{$l_status}',AdminRemarkDate='{$l_admremarkdate}'";
    $query.=" WHERE id = '{$l_id}'";

    

      if($db->query($query)){    
    $session->msg('s',"Leave updated Successfully!");
    redirect('leave_management.php', false);
     } else {
       $session->msg('d',' Sorry failed to update!');
       redirect('leaves.php', false);
     }
     
   } else{
     $session->msg("d", $errors);
     redirect('leave_management.php',false);
   }

 }


 ?>

<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<?php echo display_msg($msg); ?>
    <div class="col-md-12" style="width:90%">
      <div class="card h-100">
        <div class="card-header">
        <h2>Leave take action</h2>
        <form action="leave_approval_form.php?id=<?php echo (int)$_GET['id'] ?>" method="POST">
          <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" name="id" value="<?php echo (int)$_GET['id'] ?>" readonly>
          <select class="form-control btn-primary" name="status" required>
                                            <option value="">Choose your option</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Not Approved</option>
                                        </select>
                                        </div>
                                        </div>
                  

                  <div class="card-body">
                  <p>Remarks</p>
                    <div class="input_group">
                    <textarea rows="4" class="form-control" name="remarks" placeholder="" length="500" maxlength="500" required></textarea>
                     </div>
                  </div>
                </div>
    <div class="" style="width:90%">
       <input type="submit" class="btn btn-primary" style="font-size:15px" name="update" value="Submit">
       <a href="leave_view.php?id=<?php echo (int)$_GET['id'] ?>" class="btn btn-danger">Cancel</a>
    </div>

        </div>
      </div>
    </form>
  </div>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>