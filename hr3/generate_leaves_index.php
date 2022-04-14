<?php
	$page_title = 'Admin Generate Report';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);
	
	$user = current_user();
	$user_level = $user['user_level'];
	if ($user_level <= 1){
		#	header("Location:claim_index_admin.php");
	}
	?><?php
	$page_title = 'Home Page';
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$claim;$currency;$amount;
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$user = current_user();
	$username = $user['username'];
	$user_id = $user['id'];
	$user_level = $user['user_level'];
	$fullname = $user['name'];
	
?>
<?php include_once('layouts/header.php'); ?>
<html>
	<head>
		<meta name="generator"
		content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
		<title></title>
	</head>
	<body>
		<div class="row">
			<div class="col-md-12"><?php echo display_msg($msg); ?>
				
				<div class="col-md-12">
					<div class="card h-100">
						<div class="card-header text-center">
							<h2>Generate Leaves</h2>	
							<form method="post" action="generate_leaves.php" enctype="multipart/form-data">
								<p style="text-align:left">From: </p>
								<div class="card-body">
									<input type="date" class="form-control" name="fromdate" value="<?php echo date('Y-m-d'); ?>" />
								</div>	
								<p style="text-align:left">To: </p>
								<div class="card-body">
									<input type="date" class="form-control" name="todate" value="<?php echo date('Y-m-d'); ?>" />
								</div>	
								<button type="submit" name="generate" class="btn btn-primary" value="generate">Generate Report</button>
								<a href="leave_report.php" class="btn btn-danger">Cancel</a>
							</form>
						</div>
					</div>
				</div>
			</div>
<?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
