<?php
	$page_title = 'Edit Budget';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$user_id = $user['id'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$reimbursement_id = $_GET['reimbursement_id'];
	
	$result = $conn->query("SELECT * FROM users WHERE id=$reimbursement_id");
	while($user_data = mysqli_fetch_array($result))
	{
		$budget = $user_data['reimbursement_budget'];
	}
	
	if ($reimbursement_id == $user_id){
		$session->msg('d',"You can't edit your own budget");
		echo "<script>window.location.href='reimbursement_budget.php';</script>"; 
	}
	
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
					$query = $conn->query("SELECT reimbursement_notif FROM users WHERE id='$user_id'");
					while($user_data = mysqli_fetch_array($query)) {
						$reimbursement_notif = $user_data['reimbursement_notif'];
					}
				?>
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="reimbursement_history.php" class="breadcrumbs__item">Reimbursement History <?php if(!$reimbursement_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$reimbursement_notif; ?></span><?php } ?></a>
					<a href="reimbursement_index.php" class="breadcrumbs__item">Reimburse</a>
					<a href="reimbursement_budget.php" class="breadcrumbs__item is-active">Budget</a>
				</nav>
				<?php endif;?>
				
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron text-center">
							<h2>Edit Budget</h2></br>
							<?php
								if(isset($_POST['update'])) {
									$budget1 = $_POST['type'];
									$conn->query("UPDATE users set reimbursement_budget='$budget1' WHERE id=$reimbursement_id");
									$session->msg('s',"Budget successfully updated");
									echo "<script>window.location.href='reimbursement_budget.php';</script>"; 
								}
							?>
							<form method="post">
								<input type="text" name="type" class="form-control" value="<?= htmlspecialchars($budget) ?>"></br>
								<input type="submit" name="update" class="btn btn-primary" value="Update">
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='reimbursement_budget.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
		</html>
				