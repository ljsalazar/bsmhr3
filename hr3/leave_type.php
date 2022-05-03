<?php
  $page_title = 'Leave Types ';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   // $leave_history = tblleave();

   if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php include_once('layouts/header.php'); ?>
<!-- This will be the body -->
<div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
       <?php
    //Query Statement for unread leave===
    $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
    $user = current_user();
    $userid = (int)$user['id'];
    //====================================
    $isread=0;
    $totalAdminUnread=0;
    $sql = "SELECT id FROM tblleaves WHERE IsRead='{$isread}'";
    $result = $conn->query($sql);
    while($unreadcount = $result -> fetch_row()){
      $totalAdminUnread++;
    }
    ?>
    <?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item is-active">Leave Types</a>
        </nav>
      
    <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="leave_report.php" class="breadcrumbs__item">Leave Report</a>
        <a href="leave_management.php" class="breadcrumbs__item">Leave Management <?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>
        <a href="leave_history.php" class="breadcrumbs__item">Leave History</a>
        <a href="leave_type.php" class="breadcrumbs__item is-active">Leave Types</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="apply_leave.php" class="breadcrumbs__item">Apply Leave</a>        
        <!--This Line of codes show for all leaves responded by admin -->
        <a href="all_leaves.php" class="breadcrumbs__item">All Leaves <?php if(!$totalEmpUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalEmpUnread; ?></span><?php } ?></a>
        <a href="leave_history.php" class="breadcrumbs__item is-active">Leave History</a>
        </nav>
    <?php endif;?>
    
      </div>
    <div class="col-md-12">
      <div class="card h-100">
        <div class="card-header">
          <!-- <h2>Manage Leave Type</h2> -->
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <!-- MODAL BUTTON add -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">ADD <span class="bi bi-clipboard-plus-fill"></button>
           <!-- <a href="add_leave_type.php" class="btn btn-success me-md-2">ADD <span class="bi bi-clipboard-plus-fill"></a> -->
           <a href="leave_type_archive.php" class="btn btn-danger">TRASH <span class="bi bi-trash3-fill"></a>
          </div>
        </div>
        <div class="card-body">
          <!--<table class="table table-bordered" class="table table-sm table-striped table-bordered table-hover" style="width:100%">-->
            <table id="example" class="table table-striped data-table" style="width:100%">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 50px;">Leave Type</th>
                <th class="text-center" style="width: 10%;"> Description </th>
                <th class="text-center" style="width: 10%;"> Creation Date </th>
                <th class="text-left" style="width: 100px;"> Action </th>
              </tr>
            </thead>
            <tbody>
              <?php 

              //Query Statement for leave history
              $conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
              $user = current_user();
              $userid = (int)$user['id'];

              $sql  =" SELECT * FROM tblleavetype";
              $sql .=" ORDER BY id DESC";
              if($result = $conn->query($sql)){
              while ($row = $result -> fetch_row()) {
              ?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center" style="width:20%"><?php echo remove_junk($row[1]); ?></td> 
                <td class="text-left" style="width:30%"><?php echo remove_junk($row[2]); ?></td>
                <td class="text-center" style="width:30%"><?php echo read_date($row[3]); ?></td>
                <td>
                  <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" data-bs-whatever="<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-warning editbtn" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-fill"></i></button>

                  <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-danger deletebtn" data-toggle="tooltip" title="Remove"><i class="bi bi-eraser-fill"></i></button>

                  <!-- <a href="edit_leave_type.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="bi bi-pencil-fill"></i>
                   </a>
                   <a href="delete_leave_type.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                   <i class="bi bi-eraser-fill"></i>
                   </a> -->
              </td>
              </tr>
             <?php } }?>
            </tbody>
          </table>

          <!-- Modal for ADD LEAVE TYPE -->
              <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-secondary">
                      <h5 class="modal-title" id="exampleModalLabel" style="Color:white">Apply Leave Type</h5>
                      <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close">
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="add_leave_type.php" method="POST">
                      <div class="form-group">
                            <label for="leavetypes" class="control-label">TYPES OF LEAVE</label>
                            <input type="text" name="leavetypes" class="form-control" required>
                      </div>
                      <br>
                      <div class="form-group">
                            <label for="description" class="control-label">DESCRIPTION</label>
                            <textarea rows="4" class="form-control" name="description" placeholder="" length="500" maxlength="500" required></textarea>
                      </div>
                    </div>
                    <div class="modal-footer bg-secondary">
                      <!-- <input type="hidden" name="id" value="<?php echo (int)$_GET['id'] ?>" readonly> -->
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cancel</button>
                       <button type="Submit" name="btn_add_leave_type" class="btn btn-success"><i class="bi bi-check-circle-fill"></i> OK</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF MODAL -->

              <!-- START of EDIT LEAVETYPE MODAL -->
              <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-warning">
                      <h5 class="modal-title" id="exampleModalLabel" style="Color:white">Edit Leave Type</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="edit_leave_type.php" method="POST">
                        <!-- <label for="leavetypes_id" class="col-form-label">LEAVE TYPE ID:</label> -->
                          <input type="hidden" class="form-control" id="leavetypes_id" name="leavetypes_id">
                        <div class="form-group">
                          <label for="leavetypes" class="control-label">TYPES OF LEAVE</label>
                          <input type="text" id="leavetypes" name="leavetypes" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label for="description" class="control-label">DESCRIPTION</label>
                            <textarea rows="4" id="description" class="form-control" name="description" placeholder="" length="500" maxlength="500" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-warning">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cancel</button>
                       <button type="Submit" name="btn_edit_leave_type" class="btn btn-success"><i class="bi bi-check-circle-fill"></i> SAVE</button>
                       </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- SCRIPT FOR EDIT MODAL POMPING PUMP IT -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
            <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                // $('#recipient-name').val(data[0]);
                $('#leavetypes').val(data[1]);
                $('#description').val(data[2]);
            });
        });
        var editModal = document.getElementById('editModal')
                editModal.addEventListener('show.bs.modal', function (event) {
                  // Button that triggered the modal
                  var button = event.relatedTarget
                  // Extract info from data-bs-* attributes
                  var recipient = button.getAttribute('data-bs-whatever')
                  // If necessary, you could initiate an AJAX request here
                  // and then do the updating in a callback.
                  //
                  // Update the modal's content.
                  //var modalTitle = editModal.querySelector('.modal-title')
                  var modalBodyInput = editModal.querySelector('.modal-body input')


                  //modalTitle.textContent = 'New message to ' + recipient
                  modalBodyInput.value = recipient

                })
              </script>
              <!-- END -->

              <!-- START of DELETE LEAVETYPE MODAL -->
              <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-danger">
                      <h5 class="modal-title" id="exampleModalLabel" style="Color:white">Delete Leave Type</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="delete_leave_type.php" method="POST">
                        
                          <input type="hidden" class="form-control" id="leavetypes_id" name="leavetypes_id">
                        <div class="form-group">
                          <label for="leavetypes" class="control-label">Are you sure you want to delete this Leave Type ?</label>
                        </div>
                        <div class="form-group">
                          <!-- <label for="leavetypes" class="control-label">TYPES OF LEAVE</label> -->
                          <input type="hidden" id="d_leavetypes" name="leavetypes" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <!-- <label for="description" class="control-label">DESCRIPTION</label> -->
                            <textarea hidden rows="4" id="d_description" class="form-control" name="description" placeholder="" length="500" maxlength="500" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-default">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> CANCEL</button>
                       <button type="Submit" name="btn_delete_leave_type" class="btn btn-success"><i class="bi bi-check-circle-fill"></i> YES</button>
                       </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- SCRIPT FOR DELETE MODAL POMPING PUMP IT -->
              <script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#deleteModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                // $('#recipient-name').val(data[0]);
                $('#d_leavetypes').val(data[1]);
                $('#d_description').val(data[2]);
            });
        });
        var deleteModal = document.getElementById('deleteModal')
                deleteModal.addEventListener('show.bs.modal', function (event) {
                  // Button that triggered the modal
                  var button = event.relatedTarget
                  // Extract info from data-bs-* attributes
                  var recipient = button.getAttribute('data-bs-whatever')
                  // If necessary, you could initiate an AJAX request here
                  // and then do the updating in a callback.
                  //
                  // Update the modal's content.
                  //var modalTitle = deleteModal.querySelector('.modal-title')
                  var modalBodyInput = deleteModal.querySelector('.modal-body input')


                  //modalTitle.textContent = 'New message to ' + recipient
                  modalBodyInput.value = recipient

                })
              </script>
              <!-- END -->

              

        </div>
      </div>
    </div>
  </div>


<!--from startbootstrap.com this is for Datatables...
    <link href="dist/css/styles.css" rel="stylesheet" />
    -->
    <?php include('layouts/table/tablefooter.php');?>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="dist/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="dist/js/datatables-simple-demo.js"></script> -->

<?php include_once('layouts/footer.php'); ?>