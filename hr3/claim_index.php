1<?php
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
							<h2>Request</h2>
							<p>Provide a type of claim for a user</p>
						</div><?php
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
								$conn->query("INSERT INTO `claim` VALUES('', '$claim', '$date', '$status', '0', '$add_user_id', '$add_username', '$add_user_level', '$add_fullname')") or die(mysqli_error());
								$session->msg('s',"Claim Request Successfully Added");
								echo "<script>window.location.href='claim_index.php';</script>";
							}
						?>
						<div class="panel-body" style="margin:50px">
							<form method="post" action="claim_index.php">
								<p>Select Claim: </p>
								<div class="form-group">
									<select required class="form-control" name="claim" placeholder="Claim Type">
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
									<p>Select User:</p>
									<select class="form-control" name="user_selected" placeholder="Claim Type"><?php
										$query = $conn->query("SELECT name FROM users");
										
										while($row = mysqli_fetch_array($query)){
											echo '<option>'.$row['name'].'</option>';
										}
										
									?>
									</select>
								</div>
								</br>
								<button type="submit" name="add_claim" class="btn btn-primary" value="add_claim">Add</button>
							</form>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
