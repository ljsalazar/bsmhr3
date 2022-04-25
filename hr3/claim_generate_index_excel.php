<?php
	$page_title = 'Generate Claim Report';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	$user = current_user();
	$user_level = $user['user_level'];
	if ($user_level <= 1){
		#	header("Location:claim_index_admin.php");
	}
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
				<?php if ($user_level <= '3'): ?>
				<nav class="breadcrumbs">
					<a href="claim_index.php" class="breadcrumbs__item">Request Claims</a>
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item is-active">Claims History</a>
				</nav>
				
				<?php else: ?>
				<nav class="breadcrumbs">
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item is-active">Claims History</a>
				</nav>	
				<?php endif;?>
				
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron text-center">
							<h2>Select Claim Log</h2>	
							<form method="post" action="claim_generate_excel.php" enctype="multipart/form-data">
								<?php if ($user_level <= '2'): ?>
								<div class="form-group">
									<p style="text-align:left">User: </p>
									<select class="form-control" name="user_selected" placeholder="Select User">
										<?php
											$query = $conn->query("SELECT name FROM users");
											$all = "All users";
											echo '<option>'.$all.'</option>';
											
											while($row = mysqli_fetch_array($query)){
												echo '<option>'.$row['name'].'</option>';
											}
											
										?>
									</select>
								</div>
								<?php elseif ($user_level > '2'): ?>
								<input type="hidden" class="form-control" name="user_selected" value="0"> </input>
								<?php endif;?>
								<p style="text-align:left">From: </p>
								<div class="form-group">
									<input type="date" class="form-control" name="fromdate" value="<?php echo date('Y-m-d'); ?>" />
								</div>	
								<p style="text-align:left">To: </p>
								<div class="form-group">
									<input type="date" class="form-control" name="todate" value="<?php echo date('Y-m-d'); ?>" />
								</div>	
								<div class="form-group">
									<p style="text-align:left">Status: </p>
									<select class="form-control" name="status" placeholder="">
										<option name="All" value="All">All</option>
										<option name="Rejected Only" value="Rejected Only">Rejected Only</option>
										<option name="Accepted Only" value="Accepted Only">Accepted Only</option>
									</select>
								</div>
								</br>
								<button type="submit" name="generate" class="btn btn-primary" value="generate">Generate Report</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='claim_history.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
