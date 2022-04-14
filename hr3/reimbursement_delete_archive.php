<?php
	$page_title = 'Reimbursement Delete Prompt';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$reimbursement_id = $_GET['reimbursement_id'];
	
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
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="reimbursement_budget.php" class="breadcrumbs__item">Budget</a>
					<a href="reimbursement_index.php" class="breadcrumbs__item">Reimburse</a>
					<a href="reimbursement_history.php" class="breadcrumbs__item is-active">Reimbursement History</a>
				</nav>
				
				<?php else: ?>
				<nav class="breadcrumbs">
					<a href="reimbursement_index.php" class="breadcrumbs__item">Reimburse</a>
					<a href="reimbursement_history.php" class="breadcrumbs__item is-active">Reimbursement History</a>
				</nav>		
				<?php endif;?>
				
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron text-center">
							<?php
								if(isset($_POST['yes'])) {
									$query = $conn->query("DELETE FROM reimbursements_archive WHERE reimbursement_id=$reimbursement_id");
									$session->msg('s',"Successfully Deleted");
									
									#header("Location:timesheet_index.php");
									echo "<script>window.location.href='reimbursement_archive.php';</script>";
								}
							?>
							<h2>Are you sure you want to delete?</h2>	
							<form method="post" action="">
								</br>
								<button type="submit" name="yes" class="btn btn-primary" value="yes">Yes</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='reimbursement_archive.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
