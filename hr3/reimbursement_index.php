<?php
	$page_title = 'Reimburse';
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
	$name = $user['name'];
	$reimbursement_budget = $user['reimbursement_budget'];
	
	$user_level = $user['user_level'];
	$user_id = $user['id'];
	
	include_once('layouts/header.php'); 
?>
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
					$query = $conn->query("SELECT reimbursement_notif FROM users WHERE id='$user_id'");
					while($user_data = mysqli_fetch_array($query)) {
						$reimbursement_notif = $user_data['reimbursement_notif'];
					}
				?>
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="reimbursement_budget.php" class="breadcrumbs__item">Budget</a>
					<a href="reimbursement_history.php" class="breadcrumbs__item">Reimbursement History <?php if(!$reimbursement_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$reimbursement_notif; ?></span><?php } ?></a>
					<a href="reimbursement_index.php" class="breadcrumbs__item is-active">Reimburse</a>
				</nav>
				
				<?php else: ?>
				<nav class="breadcrumbs">
					<a href="reimbursement_history.php" class="breadcrumbs__item">Reimbursement History <?php if(!$reimbursement_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$reimbursement_notif; ?></span><?php } ?></a>
					<a href="reimbursement_index.php" class="breadcrumbs__item is-active">Reimburse</a>
				</nav>		
				<?php endif;?>
			</div>
			<div class="col-md-12">
				<div class="card h-100">
					<div class="card-header">
						<h2>Reimbursements</h2>
						<?php
							echo "<p>Hello, ".$name."!</p>";
							echo "<p>Current Reimbursement budget: ".$reimbursement_budget." PHP</p>";
							
							if(isset($_POST['add_reimbursement'])) {    
								$reimbursement = $_POST['reimbursement'];
								$amount = $_POST['amount'];
								$status = "Pending";
								$date = $_POST['date'];
								$one = 1;
								
								$q_student = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error());
								$f_student = $q_student->fetch_array();
								$conn->query("INSERT INTO `reimbursements` VALUES('', '$username', '$name', '$user_level', '$user_id', '$reimbursement', '$date', '$amount', '$status', '0')") or die(mysqli_error());
								$conn->query("UPDATE users SET reimbursement_notif = reimbursement_notif + '$one' WHERE 'username' = '$username'") or die(mysqli_error());
								
								$session->msg('s',"Successfully Added Request");
								
								#header("Location:timesheet_index.php");
								echo "<script>window.location.href='reimbursement_index.php';</script>";
							}
						?>
					</div>
					<div class="card-body" style="margin:50px">
						<form method="post" action="reimbursement_index.php" enctype="multipart/form-data">
							<div class="form-group">
								<p>Reimbursement Description</p>
								<input required type="text" class="form-control" name="reimbursement" placeholder="Reimbursement" />
							</div></br>
							<div class="form-group">
								<p>Date Reimbursed</p>
								<input type="date" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" />
							</div>	</br>
							<div class="form-group">
								<p>Reimbursement Amount (PHP)</p>
								<input required type="text" class="form-control" name="amount" placeholder="Amount" />
							</div></br>
							<button type="submit" name="add_reimbursement" class="btn btn-primary" value="add_reimbursement">Add</button>
						</form>
					</div>
				</div>
			</div>
		</div><?php include_once('layouts/footer.php'); ?>
	</body>
</html>
