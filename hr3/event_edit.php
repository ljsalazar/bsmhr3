<?php
	$page_title = 'Edit Event';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$user = current_user();
	$user_level = $user['user_level'];
	$user_id = $user['id'];
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());       
	$event_id = $_GET['event_id'];
	
	$result = $conn->query("SELECT * FROM events WHERE event_id=$event_id");
	while($user_data = mysqli_fetch_array($result))
	{
		$event = $user_data['event'];
		$fromdate = $user_data['fromdate'];
		$todate = $user_data['todate'];
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
				
				<nav class="breadcrumbs">
					<a href="timesheet_index.php" class="breadcrumbs__item">Timesheet Management</a>
					<a href="time_index.php" class="breadcrumbs__item is-active">Time and Attendance</a>
				</nav>
				
				<div class="col-md-12">
					<div class="panel">
						<div class="jumbotron">
							<h2 style="text-align:center">Edit Event</h2></br>
							<form method="post">
								<div class="form-group">
									<h4>Description</h4>
									<input required type="text" class="form-control" name="editevent" value="<?php echo $event; ?>" />
								</div>
								<div class="form-group">
									<h4>Beginning Date</h4>
									<input type="date" class="form-control" name="editfromdate" value="<?php echo $fromdate; ?>" />
								</div>
								<div class="form-group">
									<h4>Ending Date</h4>
								<input type="date" class="form-control" name="edittodate" value="<?php echo $todate ?>" />
								</div>
								<div class="form-group">
								<h4>Minimum User Level</h4>
								<select required class="form-control" name="min_user_level" placeholder="Show events for: "><?php
								$query = $conn->query("SELECT group_name FROM user_groups");
								echo '<option value="" disabled selected hidden>Select your option</option>';
								while($row = mysqli_fetch_array($query)){
								echo '<option>'.$row['group_name'].'</option>';
								}
								?>
								</select>
								</div></br>
								<div class="text-center">
								<button type="submit" name="edit_event" class="btn btn-primary" value="edit_event">Edit Event</button>
								</form>
								<?php
								if(isset($_POST['cancel'])) {
								echo "<script>window.location.href='time_index.php';</script>"; 
								}
								
								if(isset($_POST['edit_event'])) {
								$editevent = $_POST['editevent'];
								$editfromdate = $_POST['editfromdate'];
								$edittodate = $_POST['edittodate'];
								$editmin_user_level = $_POST['min_user_level'];	
								
								$query = $conn->query("SELECT * FROM user_groups WHERE group_name='$editmin_user_level'");
								while($row = mysqli_fetch_array($query)){
								$group_level = $row['group_level'];
								}
								
								$conn->query("UPDATE events SET event='$editevent' WHERE event_id='$event_id'");
								$conn->query("UPDATE events SET fromdate='$editfromdate' WHERE event_id='$event_id'");
								$conn->query("UPDATE events SET todate='$edittodate' WHERE event_id='$event_id'");
								$conn->query("UPDATE events SET min_user_level='$group_level' WHERE event_id='$event_id'");
								
								$session->msg('s',"Event successfully updated");
								echo "<script>window.location.href='time_index.php';</script>"; 
								}
								?>
								<form method="post">
								</br><button type="submit" name="cancel" class="btn" value="cancel">Cancel</button>
								</form>
								</div>
								</div>
								</div>
								</div>
								</div><?php include_once('layouts/footer.php'); ?>
								</body>
								</html>
																