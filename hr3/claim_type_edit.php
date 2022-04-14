<?php
	$page_title = 'Edit Claim Type';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$user_id = $user['id'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$claim_type_id = $_GET['claim_type_id'];
	
	$result = $conn->query("SELECT * FROM claim_type_admin WHERE claim_type_id=$claim_type_id");
	while($user_data = mysqli_fetch_array($result))
	{
		$type = $user_data['type'];
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
					<div class="panel">
						<div class="jumbotron text-center">
							<h2>Edit Claim Type</h2></br>
							<?php
								if(isset($_POST['update'])) {
									$type = $_POST['type'];
									$conn->query("UPDATE claim_type_admin set type='$type' WHERE claim_type_id=$claim_type_id");
									$session->msg('s',"Claim type successfully updated");
									echo "<script>window.location.href='claim_type.php';</script>"; 
								}
							?>
							<form method="post">
								<input type="text" name="type" class="form-control" value="<?= htmlspecialchars($type) ?>"></br>
								<input type="submit" name="update" class="btn btn-primary" value="Update">
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='claim_type.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
