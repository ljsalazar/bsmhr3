<?php
	$page_title = 'Claim Reject Prompt';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$claim_id = $_GET['claim_id'];
	$name = $user['name'];
	$username = $user['username'];
	
	$result = $conn->query("SELECT * FROM claim WHERE claim_id='$claim_id'");
	while($user_data = mysqli_fetch_array($result))
	{
		$id = $user_data['user_id'];
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
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="claim_index.php" class="breadcrumbs__item">Appoint Claims</a>
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
							<?php
								if(isset($_POST['yes'])) {
								$read = 1;
								$remarks = $_POST['remarks'];
								
									$query1 = $conn->query("SELECT * FROM claim WHERE claim_id='$claim_id'");
									while($user_data = mysqli_fetch_array($query1)){
										$getusername = $user_data['username'];
										
										if ($getusername == $username){
											$session->msg('d',"You can't reject your own claims");
											echo "<script>window.location.href='claim_history.php';</script>";
											} else {
											$conn->query("UPDATE claim SET status='Rejected by $name' WHERE claim_id='$claim_id'") or die(mysqli_error());
											$conn->query("UPDATE claim SET remarks='$remarks' WHERE claim_id='$claim_id'") or die(mysqli_error());
											$conn->query("UPDATE claim SET accepted=2 WHERE claim_id='$claim_id'") or die(mysqli_error());
											#$conn->query("UPDATE users SET claim_notif=claim_notif+$read WHERE id=$id");
											$session->msg('s',"Claim Successfully Rejected");
										}
									}
									echo "<script>window.location.href='claim_history.php';</script>";
								}
							?>
							<h2>Are you sure you want to reject?</h2>	
							<form method="post" action="">
								</br>
								<textarea placeholder="Remarks" rows="4" class="form-control" name="remarks" placeholder="" length="500" maxlength="500" required></textarea>
								</br>
								<button type="submit" name="yes" class="btn btn-primary" value="yes">Yes</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='claim_history.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
