<?php
	$page_title = 'Support';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());	
	$user = current_user();
	$username = $user['username'];
	$name = $user['name'];
	$user_id = $user['id'];
	$user_level = $user['user_level'];
	
	$query = $conn->query("SELECT complaint_notif FROM users WHERE complaint_notif!=0 AND id='$user_id'");
	$query2 = $conn->query("UPDATE users SET complaint_notif=0 WHERE id=$user_id");
?>

<?php
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	$working = 0;
	$query1 = $conn->query("SELECT working FROM `time_attendance` WHERE `username` = '$username'") or die(mysqli_error());
	while($user_data = mysqli_fetch_array($query1)){
		$working = $user_data['working'];
	}
	if ($working == 1){
		#header("Location:time_index_loggedin.php");  
	} 
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
	<div class="col-md-12">
		<?php echo display_msg($msg); ?>
		<nav class="breadcrumbs">
			<a href="timesheet_index.php" class="breadcrumbs__item">Timesheet Management</a>
			<a href="time_index.php" class="breadcrumbs__item is-active">Time and Attendance</a>
		</nav>
	</div>
	<div class="col-md-12">
		<div class="panel">
			<div class="text-center" style="margin:50px">
				<h4>File a complaint to the admin</h4></br>
				<?php
					if(isset($_POST['submit'])) {
						$complaint = $_POST['type'];
						$complaint_date = date("Y-m-d H:i:s", strtotime("+0 HOURS"));
						$conn->query("INSERT INTO `complaints` VALUES('', '$complaint', '$complaint_date', 'Pending', '0', '$user_id', '$username', '$user_level', '$name')");
						$session->msg('s',"Complaint successfully requested");
						echo "<script>window.location.href='complaint_index.php';</script>"; 
					}
				?>
				<form method="post">
					<input type="text" name="type" class="form-control" value=""></br>
					<input type="submit" name="submit" class="btn btn-primary" value="Submit">
				</form>
				</br><button name="cancel" class="btn" onclick="location.href='time_index.php'">Cancel</button>
			</div>
			
			<div class="jumbotron" style="display:block; margin:auto">
				<div style="max-height:580px; overflow:auto;">
					<table id="datatablesSimple" class="table table-striped data-table" style="width:100%">
						<thead>
							<tr>
								<th>User</th> <th>Complaint</th> <th>Date</th> <th>Status</th> <th>Options</th>
							</tr>
						</thead>
						<?php
							$user = current_user();
							$username = $user['username'];
							$name = $user['name'];
							$user_level = $user['user_level'];
							$conn = new mysqli('localhost', 'root', '', 'bank');
							
							if ($user_level <= 1){
								$query = $conn->query("SELECT * FROM complaints ORDER BY complaint_id DESC");
							}
							else if ($user_level <= 1){
								$query = $conn->query("SELECT * FROM complaints WHERE user_level >= 2 ORDER BY complaint_id DESC");
							}
							else {
								$query = $conn->query("SELECT * FROM complaints WHERE username = '$username' ORDER BY complaint_id DESC");
							}
							while($user_data = mysqli_fetch_array($query)) {
								echo "<tr>";
								echo "<td>".$user_data['name']."</td>";
								echo "<td>".$user_data['complaint']."</td>";
								echo "<td>".$user_data['complaint_date']."</td>";
								echo "<td>".$user_data['status']."</td>";
								
								$accepted = $user_data['accepted'];
								
								if ($user_level <= 1) {
									if ($accepted == 1) {
										echo "<td><a href='complaint_delete.php?complaint_id=$user_data[complaint_id]'>Delete</a></td>";
										} else {
										echo "<td><a href='complaint_delete.php?complaint_id=$user_data[complaint_id]'>Delete</a> | <a href='complaint_accept.php?complaint_id=$user_data[complaint_id]'>Accept</a></td>";
									}
									
									} else {
									echo "<td><a href='complaint_delete.php?complaint_id=$user_data[complaint_id]'>Delete</a></td>";
								}
								echo "</tr>";
							}?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('layouts/table/tablefooter.php');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="dist/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="dist/js/datatables-simple-demo.js"></script>

<?php include_once('layouts/footer.php'); ?>												