<?php
	$page_title = 'Types of Claims';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	?><?php
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());    
	
	$claim;$currency;$amount;
	$user = current_user();
	$user_level = $user['user_level'];
	$user_id = $user['id'];
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
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="claim_index.php" class="breadcrumbs__item">Request Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
					<a href="claim_type.php" class="breadcrumbs__item is-active">Types of Claims</a>
				</nav>
				
				<?php else: ?>
				<nav class="breadcrumbs">
					<a href="claim_history.php" class="breadcrumbs__item">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
					<a href="claim_type.php" class="breadcrumbs__item is-active">Types of Claims</a>
				</nav>	
				<?php endif;?>
				
				<div class="col-md-12">
					<div class="card h-100">
						<div class="card-header">
							<h2>Types</h2>
							<p>Add an additional type of claim available</p>
						</div>
						<?php
							$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
							$user = current_user();
							$username = $user['username'];
							$user_id = $user['id'];
							$user_level = $user['user_level'];
							$fullname = $user['name'];
							
							if(isset($_POST['add_claim'])) {
								$claim = $_POST['claim'];;
								$status = "Pending";
								$date = date("Y-m-d", strtotime("+7 HOURS"));
								
								$q_student = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error());
								$f_student = $q_student->fetch_array();
								$conn->query("INSERT INTO `claim` VALUES('', '$claim', '$date', '$status', '$user_id', '$username', '$user_level', '$fullname')") or die(mysqli_error());
								
								$session->msg('s',"Successfully Added Claim Type");
								
								#header("Location:timesheet_index.php");
								echo "<script>window.location.href='claim_type.php';</script>";
							}
						?>
						
						<div class="row">
							<?php if($user['user_level'] <= '2'): ?>
							<div class="col-md-5">
								<div class="card-body">
									<?php
										$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
										$user = current_user();
										$username = $user['username'];
										$user_id = $user['id'];
										$user_level = $user['user_level'];
										
										if(isset($_POST['add_claim_type'])) {
											$claim_type = $_POST['claim_type'];
											$conn->query("INSERT INTO `claim_type_admin` VALUES('', '$claim_type')") or die(mysqli_error());
											
											$session->msg('s',"Successfully Added Claim Type");
											
											#header("Location:timesheet_index.php");
											echo "<script>window.location.href='claim_type.php';</script>";
										}
									?>
									
									<h6 style="text-align:left">Add a Type of Claim</h6>
									<form method="post" action="claim_type.php">
										<div class="form-group">
											<input required type="text" class="form-control" name="claim_type" placeholder="Claim Type" />
										</div>
										</br>
										<button type="submit" name="add_claim_type" class="btn btn-primary">Add</button>
									</form>
									
								</div>
							</div>
							<?php endif;?>
							<?php if($user['user_level'] <= '2'): ?>
							<div class="col-md-7">
								<div class="card-body">
									<?php else: ?>
									<div class="col-md-12">
										<div class="card-body">
											<?php endif;?>
											<h6 style="text-align:left">Types of Claim</h6>
											<div style="max-height:600px; overflow:auto;">
												<table id="datatablesSimple" class="table table-striped data-table" style="width:100%">
													<thead>
														<tr>
															<th>Type</th>
															<?php if($user['user_level'] <= '2'): ?>
															<th>Options</th>
															<?php endif;?>
														</tr>
													</thead>
													<?php
														$user = current_user();
														$username = $user['username'];
														$user_level = $user['user_level'];
														$conn = new mysqli('localhost', 'root', '', 'bank');
														
														$query = $conn->query("SELECT * FROM claim_type_admin ORDER BY claim_type_id DESC");
														
														while($user_data = mysqli_fetch_array($query)) {
															echo "<tr>";
															echo "<td>".$user_data['type']."</td>";
															if ($user_level <= 2) {
																echo "<td><a href='claim_type_edit.php?claim_type_id=$user_data[claim_type_id]'>Edit | </a><a href='claim_type_delete.php?claim_type_id=$user_data[claim_type_id]'>Delete</a></td>";
															}
															echo "</tr>";
														}?>
												</table>
											</div>
										</div>
									</div>
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
			</body>
		</html>
		