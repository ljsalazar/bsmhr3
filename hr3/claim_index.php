<?php
	$page_title = 'Request Claims';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
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
		<title></title>
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
				<?php if ($user_level <= '3'): ?>
				<nav class="breadcrumbs">
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
					<a href="claim_index.php" class="breadcrumbs__item is-active">Appoint Claims</a>
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
						<?php if ($user_level <= '2'): ?>
							<h2 style="text-align:center;">CLAIM FORM</h2>
						
						<?php else: ?>
							<h2>Payable Leaves</h2>
							<p>Suitable payable leaves</p>
						<?php endif;?>
						</div>
						<?php
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
								$conn->query("INSERT INTO `claim` (claim,claim_date,status,accepted,user_id,username,user_level,name) VALUES ('$claim', '$date', '$status', '0', '$add_user_id', '$add_username', '$add_user_level', '$add_fullname')") or die(mysqli_error($conn));
								$session->msg('s',"Claim Request Successfully Added");
								echo "<script>window.location.href='claim_index.php';</script>";
							}
						?>
						<div class="card-body">
							<form method="post" action="claim_index.php">
								<?php if ($user_level <= '2'): ?>
								<p>Select Claim: </p>
								<div class="form-group">
									<select required class="form-select form-select-md" name="claim">
										  <option value="">Choose type</option>
										<?php
											$query = $conn->query("SELECT type FROM claim_type_admin");
											
											while($row = mysqli_fetch_array($query)){
												echo '<option>'.$row['type'].'</option>';
											}
										?>
									</select>
								</div>
								</br>
								<div class="form-group">
									<p>Select Employee:</p>
									<select class="form-select form-select-md" name="user_selected" >
										 
										<?php
										$query = $conn->query("SELECT name FROM users");
										
										while($row = mysqli_fetch_array($query)){
											echo '<option>'.$row['name'].'</option>';
										}
									?>
									</select>
								</div>
								</br>
								<button type="submit" name="add_claim" class="btn btn-primary" value="add_claim">Add</button>
								</br></br></br>

								<h4 style="text-align:center;">PAYABLE LEAVES</h4>
								<div class="panel-body">
									<div style="max-height:600px">
										<table id="example" class="table table-bordered data-table" style="width:100%">
											<thead>
												<tr>
													<th class="text-left" style="width: 50px;">User</th>
													<th class="text-left" style="width: 50px;">Leave Type</th>
													<th class="text-left" style="width: 50px;">Posting Date</th>
													<th class="text-left" style="width: 50px;">From-To</th>
													<?php if ($user_level <= 2){?>
														<th class="text-left" style="width: 50px; ">Options</th>
													<?php }?>
												</tr>
											</thead>
											<tbody>
												<?php 
													
													//Query Statement for leave history
													$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
													$user = current_user();
													$userid = (int)$user['id'];
													
													if ($user_level <= 2){
														$sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid,l.amount_of_days,l.remaining_days,u.name";
														$sql .=" FROM tblleaves l";
														$sql .=" LEFT JOIN users u ON l.empid = u.id";
														$sql .=" WHERE l.Status = 1 AND paid = 0";
														// $sql .=" WHERE l.empid= '{$userid}'";
														$sql .=" ORDER BY id DESC";
														} else {
														$sql  =" SELECT l.id,l.LeaveType,l.FromDate,l.ToDate,l.Description,l.PostingDate,l.AdminRemarkDate,l.AdminRemark,l.Status,l.empid,l.amount_of_days,l.remaining_days,u.name";
														$sql .=" FROM tblleaves l";
														$sql .=" LEFT JOIN users u ON l.empid = u.id";
														$sql .=" WHERE l.Status = 1 AND paid = 0 AND empid='{$userid}'";
														$sql .=" ORDER BY id DESC";
													}
													if($result = $conn->query($sql)){
														while ($row = $result -> fetch_row()) {
														?>
														<tr>
															<td class="text-left"> <?php echo remove_junk($row[12]); ?></td>
															<td class="text-left"><?php echo remove_junk($row[1]); ?></td>                   
															<td class="text-left"><?php echo read_date($row[5]); ?></td>
															<td class="text-left"><?php echo remove_junk("From:".$row[2]." To:".$row[3]); ?></td>
															<?php if ($user_level <= 2){?>
																<td class="text-center"><a href="payable_option.php?id=<?php echo remove_junk($row[0]);?>"class="btn btn-xs btn-success" data-toggle="tooltip" title="View"><i class="bi bi-check-circle-fill"></i></a></td>
															<?php }?>
														</tr>
														<?php } 
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<?php else: ?>
								<div class="panel-body">
									<div style="max-height:600px; overflow:auto;">
										<table id="example" class="table table-bordered data-table" style="width:100%">
											<thead>
												<tr>
													<th class="text-center" style="width: 50px;">User</th>
													<th class="text-center" style="width: 50px;">Leave Type</th>
													<th class="text-center" style="width: 50px;">Posting Date</th>
													<th class="text-center" style="width: 50px;">From-To</th>
													<th class="text-center" style="width: 50px;">Options</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													
													//Query Statement for leave history
													$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());
													$user = current_user();
													$userid = (int)$user['id'];
													
													if ($user_level <= 2){
														$sql  =" SELECT id,LeaveType,FromDate,ToDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status,empid,amount_of_days,remaining_days,emp_name";
														$sql .=" FROM tblleaves";
														// $sql .=" LEFT JOIN users u ON l.empid = u.id";
														$sql .=" WHERE Status = 1 AND paid = 0";
														// $sql .=" WHERE l.empid= '{$userid}'";
														$sql .=" ORDER BY id DESC";
														} else {
														$sql  =" SELECT id,LeaveType,FromDate,ToDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status,empid,amount_of_days,remaining_days,emp_name";
														$sql .=" FROM tblleaves";
														// $sql .=" LEFT JOIN users u ON l.empid = u.id";
														$sql .=" WHERE Status = 1 AND paid = 0 AND empid='{$userid}'";
														$sql .=" ORDER BY id DESC";
													}
													if($result = $conn->query($sql)){
														while ($row = $result -> fetch_row()) {
														?>
														<tr>
															<td class="text-center"> <?php echo remove_junk($row[12]); ?></td>
															<td class="text-center"><?php echo remove_junk($row[1]); ?></td>                   
															<td class="text-center"><?php echo read_date($row[5]); ?></td>
															<td class="text-center"><?php echo remove_junk("From:".$row[2]." To:".$row[3]); ?></td>
															<td class="text-center"><a href="payable_option.php?id=<?php echo remove_junk($row[0]);?>" class="btn" style="background-color:steelblue; color: whitesmoke;"> Action </a></td>
														</tr>
														<?php } 
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<?php endif;?>
							</form>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
			
			
			<!--from startbootstrap.com this is for Datatables...
				<link href="dist/css/styles.css" rel="stylesheet" />
			-->
		</body>
	</html>
