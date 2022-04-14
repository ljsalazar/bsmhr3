<?php
	$page_title = 'Shift Type Retrieve Prompt';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(1);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$shift_type_id = $_GET['shifttype_id'];
	
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
				<!-- <?php if ($user_level <= '1'): ?>
				<ul class="nav nav-pills">
					
					<li role="presentation"><a href="claim_index.php" class="btn" style="margin-bottom:10px">Request Claims</a></li>
					<li role="presentation"><a href="claim_type.php" class="btn" style="margin-bottom:10px">Types of Claims</a></li>
					<li role="presentation" class="active"><a href="claim_history.php" class="btn" style="margin-bottom:10px">Claims History</a></li>
				</ul>
				
				<?php else: ?>
				<ul class="nav nav-pills">
					
					<li role="presentation"><a href="claim_index.php" class="btn" style="margin-bottom:10px">Request Claims</a></li>
					<li role="presentation" class="active"><a href="claim_history.php" class="btn" style="margin-bottom:10px">Claims History</a></li>
				</ul>		
				<?php endif;?> -->
				
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron text-center">
							<?php
								if(isset($_POST['yes'])) {
						// $l_id = $_POST['id'];
						$s_types = $_POST['shift_name'];
     					$s_fromTime  = $_POST['fromTime'];
     					$s_toTime  = $_POST['toTime'];
									$query1 = $conn->query("INSERT INTO tblshift_type (name,fromTime,toTime)VALUES('{$s_types}', '{$s_fromTime}', '{$s_toTime}') ");
									
									$query = $conn->query("DELETE FROM tblshifttype_archive WHERE id=$shift_type_id");									
									$session->msg('s',"Successfully Retrieved");
									
									#header("Location:timesheet_index.php");
									echo "<script>window.location.href='shift_type_archive.php';</script>";
								}
							?>
							<h2>Are you sure you want to retreive?</h2>	
							<form method="post" action="">
							</br>
							<?php
							$query2 = $conn->query("SELECT * FROM tblshifttype_archive WHERE id=$shift_type_id");
							while($row = $query2->fetch_row()){
							?>
							<input type="hidden" name="id" value="<?php echo $row[0];?>">
							<input type="hidden" name="shift_name" value="<?php echo $row[1];?>">
							<input type="hidden" name="fromTime" value="<?php echo $row[2];?>">
							<input type="hidden" name="toTime" value="<?php echo $row[3];?>">
						<?php }?>
								<button type="submit" name="yes" class="btn btn-primary" value="yes">Yes</button>
							</form></br>
							<button name="cancel" class="btn" onclick="location.href='shift_type_archive.php'">Cancel</button>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
