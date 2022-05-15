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
				<?php if ($user_level <= '3'): ?>
				<nav class="breadcrumbs">
					<a href="claim_index.php" class="breadcrumbs__item">Appoint Claims</a>
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
							<h2>ADD CLAIM TYPES</h2>
							
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
								$conn->query("INSERT INTO `claim` (claim,claim_date,status,accepted,user_id,username,user_level,name) VALUES ('$claim', '$date', '$status', '0', '$add_user_id', '$add_username', '$add_user_level', '$add_fullname')") or die(mysqli_error($conn));
								
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
											$conn->query("INSERT INTO `claim_type_admin` (type) VALUES('$claim_type')") or die(mysqli_error());
											
											$session->msg('s',"Successfully Added Claim Type");
											
											#header("Location:timesheet_index.php");
											echo "<script>window.location.href='claim_type.php';</script>";
										}
									?>
									
									<h6 style="text-align:left">Claim name:</h6>
									<form method="post" action="claim_type.php">
										<div class="form-group">
											<input required type="text" class="form-control" name="claim_type" />
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
											
											<div style="max-height:600px">
												<table id="example" class="table table-bordered data-table" style="width:100%">
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
																echo "<td><a href='claim_type_edit.php?claim_type_id=$user_data[claim_type_id]' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit'><i class='bi bi-pencil-fill'></i></a> <a href='claim_type_delete.php?claim_type_id=$user_data[claim_type_id]' class='btn btn-xs btn-danger' data-toggle='tooltip' title='Remove'><i class='bi bi-eraser-fill'></i></a></td>";
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
				<?php include_once('layouts/footer.php'); ?>
			</body>
		</html>
		