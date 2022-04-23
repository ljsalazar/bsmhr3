<?php
	$page_title = 'Edit Creadit';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$user_id = $user['id'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$credit_id = $_GET['credit_id'];
	
	$result = $conn->query("SELECT * FROM users WHERE id=$credit_id");
	while($user_data = mysqli_fetch_array($result))
	{
		$token = $user_data['leave_token'];
	}
	
	if ($credit_id == $user_id){
		$session->msg('d',"You can't edit your own leave credit");
		echo "<script>window.location.href='leave_credit.php';</script>"; 
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
				
				
				<div class="card h-100">
					<div class="card-header">
						<div class="card-body">
							<h3>Edit Leave Credit</h3></br>
							<?php
								if(isset($_POST['update'])) {
									$credit = $_POST['type'];
									$conn->query("UPDATE users SET leave_token='$credit' WHERE id=$credit_id");
									$session->msg('s',"Successfully updated");
									echo "<script>window.location.href='leave_credit.php';</script>"; 
								}
							?>
							<form method="post">
								<input type="number" min="0" name="type" class="form-control" value="<?= htmlspecialchars($token) ?>"></br>
								<input type="submit" name="update" class="btn btn-primary" value="Update">
							<a href="leave_credit.php" name="cancel" class="btn btn-danger">Cancel</a>
							</form>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
		</html>
				