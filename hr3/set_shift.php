<?php
	$page_title = 'Shifting';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);
	
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php 
	if(isset($_POST['btn_save_shift'])){
		$req_fields = array('shift_name','fromTime','toTime');
		validate_fields($req_fields);
		if(empty($errors)){
			$shift_name = remove_junk($db->escape($_POST['shift_name']));
			$fromTime  = remove_junk($db->escape($_POST['fromTime']));
			$toTime = remove_junk($db->escape($_POST['toTime']));
			
			$query  = "INSERT INTO tblshift_type (";
			$query .=" name,fromTime,toTime";
			$query .=") VALUES (";
			$query .=" '{$shift_name}', '{$fromTime}', '{$toTime}'";
			$query .=")";
			$query .=" ON DUPLICATE KEY UPDATE name='{$shift_name}'";
			
			if($fromTime == $toTime){
                $session->msg('w', 'From time and To time should should not be the same');
                redirect('set_shift.php', false);
			}
			
			if($db->query($query)){
				
				$session->msg('s',"Shift saved! ");
				redirect('set_shift.php', false);
				} else {
				$session->msg('d',' Sorry failed to added!');
				redirect('shiftscheduling_index.php', false);
			}
			} else{
			$session->msg("d", $errors);
			redirect('set_shift.php',false);
		}
		
	}
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
			$empread=0;
			$totalEmpUnread=0;
			$totalAdminUnread=0;
			$status=1;
			$sql = "SELECT id FROM tblschedule WHERE emp_read='{$empread}' AND empid='{$userid}' AND Status='{$status}'";
			$result = $conn->query($sql);
			while($unreadcount = $result -> fetch_row()){
				$totalEmpUnread++;
			}
			$sql = "SELECT id FROM tblschedule WHERE IsRead='{$isread}'";
			$result = $conn->query($sql);
			while($unreadcount = $result -> fetch_row()){
				$totalAdminUnread++;
			}
		?>
		<?php if($user['user_level'] === '1'): ?>
        <!-- admin menu -->
        <nav class="breadcrumbs">
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule<?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
		<a href="set_shift.php" class="breadcrumbs__item is-active">Set Shift</a>
        </nav>

  <?php elseif($user['user_level'] === '2'): ?>
        <!-- Special menu -->
        <nav class="breadcrumbs">
        <a href="schedule_management.php" class="breadcrumbs__item">Manage Schedule<?php if(!$totalAdminUnread==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$totalAdminUnread; ?></span><?php } ?></a>
        <a href="scheduling.php" class="breadcrumbs__item">Scheduling</a>
        <a href="set_shift.php" class="breadcrumbs__item is-active">Set Shift</a>
        </nav>


      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
        <nav class="breadcrumbs">
        <a href="schedule.php" class="breadcrumbs__item">Your Schedule</a>
        </nav>
      
    <?php endif;?>		
	</div>
	
	<div class="col-md-6">
		<div class="card h-100">
			<div class="card-header">
				<h2>Shift and Scheduling</h2>
				<p>create shift:</p>
				<form method="post" action="set_shift.php">
					
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
							<label>Name:</label>
							<input type="text" name="shift_name" class="form-control" required>
							</div>
						</div>
					</div>
					
					<div class="card-body">
						<label>From:</label>
						<div class="input-group col-md-2">
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-time"></i>
							</span>
							<input type="time" class="form-control" name="fromTime" required>
						</div>
					</div>
					
					<div class="card-body">
						<label>To:</label>
						<div class="input-group col-md-2">
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-time"></i>
							</span>
							<input type="time" class="form-control" name="toTime" required>
						</div>
					</div>

					
					
					<input type="submit" name="btn_save_shift" value="SAVE" class="btn btn-primary" style="font-size:15px">
				</form>
			</div>
		</div>
		
		
	</div>
	<!-- ==============MINI TABLE FOR SHIFT RECORDS============== -->
	<div class="col-md-6">
		<div class="card h-100">
			<div class="card-header">
				<div class="panel" style="width:100%; display:block; margin:auto">
					<h4 style="text-align:left; margin-bottom:10px; margin-left:20px">Shifting Records:
					<div class="pull-right">
		            <a href="shift_type_archive.php" class="btn btn-outline-danger" style="margin-bottom: 10px; margin-right: 10px;"><span class="bi bi-trash3-fill"></span></a>
		          </div>
		          </h4>
					
					<div style="max-height:300px">
						<table class="table" style="table-layout: auto;">
							<tr>
								<th>#</th> <th>Shift Name</th> <th>From</th> <th>To</th> <th>Action</th>
							</tr>
						</table>
					</div>
					<div style="max-height:300px; overflow:auto;">
						<table class="table" style="table-layout: auto;">
							<?php 
								
								//Query Statement for leave history
								$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
								$user = current_user();
								$userid = (int)$user['id'];
								$sql ="SELECT id,name,fromTime,toTime FROM tblshift_type";
								$sql.=" ORDER BY id DESC";
								if($result = $conn->query($sql)){
									while ($row = $result -> fetch_row()) {
									?>
									<tr>
										<td class="text-center"> <?php echo count_id(); ?></td>
										<td class="text-center"> <?php echo remove_junk($row[1]); ?></td>
										<td class="text-center"><?php $f_time = date("g:i a", strtotime($row[2])); echo $f_time; ?></td>                   
										<td class="text-center"><?php $f_time = date("g:i a", strtotime($row[3])); echo $f_time; ?></td>
										<td class="text-center">
											<a href="edit_shift.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
											<a href="delete_shift.php?id=<?php echo remove_junk($row[0]);?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-remove"></i></a>
										</td>  
									</tr>
								<?php } }?>
						</table>
					</div>
				</div>
				<!-- ==================== ==============-->
				
				
			</div>
		</div>
	</div>
	
	
</div>


<?php include_once('layouts/footer.php'); ?>