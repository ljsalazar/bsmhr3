1<?php
	$page_title = 'Request Claims';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);
	
	$user = current_user();
	$user_level = $user['user_level'];
	?><?php
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$claim;$currency;$amount;
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$user = current_user();
	$username = $user['username'];
	$user_id = $user['id'];
	$user_level = $user['user_level'];
	$fullname = $user['name'];
?><?php include_once('layouts/header.php'); ?>
<html>
	<head>
		<meta name="generator"
		content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
		<title>Request Claims</title>
	</head>
	<body>
		<div class="row">
			<div class="col-md-12"><?php echo display_msg($msg); ?>
				<?php 
					$query = $conn->query("SELECT claim_notif FROM users WHERE id='$user_id'");
					while($user_data = mysqli_fetch_array($query)) {
						$claim_notif = $user_data['claim_notif'];
					}
				?>
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
					<a href="claim_index.php" class="breadcrumbs__item is-active">Request Claims</a>
				</nav>
				
				<?php else: ?>
				<nav class="breadcrumbs">
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item is-active">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
				</nav>	
				<?php endif;?>
				
				<div class="col-md-12">
					<div class="card h-100">
						<div class="card-header">
							<h2>Request Claims</h2>
							<p>Provided as for Payable Leaves</p>
							</div><?php
							$id = $_GET['id'];
							$bruh = $id;
							
							if(isset($_POST['add_claim'])) {
								$claim = $_POST['claim'];
								$user_selected = $_POST['user_selected'];
								$status = "Pending";
								$date = date("Y-m-d", strtotime("+0 HOURS"));
								
								#$q_student = $conn->query("SELECT * FROM `users` WHERE `name` = '$user_selected'") or die(mysqli_error());
								#$f_student = $q_student->fetch_array();
								
								$query = $conn->query("SELECT * FROM users WHERE name = '$user_selected'");
								while($user_data = mysqli_fetch_array($query)) {
									$add_user_id = $user_data['id'];
									$add_username = $user_data['username'];
									$add_user_level = $user_data['user_level'];
									$add_fullname = $user_data['name'];
								}
								$conn->query("UPDATE tblleaves SET paid = 1 WHERE id = '$bruh'");
								$conn->query("INSERT INTO `claim` VALUES('', '$claim', '$date', '$status', '0', '$add_user_id', '$add_username', '$add_user_level', '$add_fullname')") or die(mysqli_error());
								$session->msg('s',"Claim Request Successfully Added");
								echo "<script>window.location.href='claim_index.php';</script>";
							}
						?>
						<div class="panel-body" style="margin:50px">
							<form method="post" action="">
								<p>Selected Claims: </p>
								<div class="form-group">
								<?php 
													
													//Query Statement for leave history
													$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
													$user = current_user();
													$userid = (int)$user['id'];
													
													
													if ($user_level <= 2){
														$sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid,l.amount_of_days,l.remaining_days,u.name";
														$sql .=" FROM tblleaves l";
														$sql .=" LEFT JOIN users u ON l.empid = u.id";
														$sql .=" WHERE l.Status = 1 AND l.id ='{$id}' ";
														// $sql .=" WHERE l.empid= '{$userid}'";
														$sql .=" ORDER BY id DESC";
													} else {
														$sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid,l.amount_of_days,l.remaining_days,u.name";
														$sql .=" FROM tblleaves l";
														$sql .=" LEFT JOIN users u ON l.empid = u.id";
														$sql .=" WHERE l.Status = 1 AND empid='{$userid}' AND l.id ='{$id}' ";
														$sql .=" ORDER BY id DESC";
													}
													// if($result = $conn->query($sql)){
													// 	while ($row = $result -> fetch_row()) {
														$result = $conn->query($sql);
														$row = $result->fetch_row();
														?>
									<input type="text" class="form-control" name="claim" value="<?php echo "Payable Leaves( ".($row[1]).")"; ?>" readonly>
									
								</div>
								</br>
								<div class="form-group">
									<p>Selected User:</p>
									<input type="text" class="form-control" name="user_selected" value="<?php echo $row[12]; ?>" readonly>

								</div>
								</br>
								<button type="submit" name="add_claim" class="btn btn-primary" value="add_claim">Add</button>
								<a href="claim_index.php" class="btn btn-danger">Cancel</a>
								</br></br></br>
								
							</form>
						</div>
					</div>
				</div>
				</div><?php include_once('layouts/footer.php'); ?>
			
			
			<!--from startbootstrap.com this is for Datatables...
				<link href="dist/css/styles.css" rel="stylesheet" />
			-->
			<?php include('layouts/table/tablefooter.php');?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
			<script src="dist/js/scripts.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
			<script src="dist/js/datatables-simple-demo.js"></script>
		</body>
	</html>