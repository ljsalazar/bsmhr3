<?php
	$page_title = 'Claim History';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
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
	
	$query = $conn->query("SELECT claim_notif FROM users WHERE claim_notif!=0 AND id='$user_id'");
	$query2 = $conn->query("UPDATE users SET claim_notif=0 WHERE id=$user_id");
?><?php include_once('layouts/header.php'); ?>
<html>
	<head>
		<meta name="generator"
		content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
		<title>Claim History</title>
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
				<?php if ($user_level <= '3'): ?>
				<nav class="breadcrumbs">
					<a href="claim_index.php" class="breadcrumbs__item">Appoint Claims</a>
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item is-active">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
				</nav>
				
				<?php else: ?>
				<nav class="breadcrumbs">
					<a href="claim_type.php" class="breadcrumbs__item">Types of Claims</a>
					<a href="claim_history.php" class="breadcrumbs__item is-active">Claims History <?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a>
				</nav>	
				<?php endif;?>
				
				<div class="col-md-12">
					<div class="card h-100">
						<div class="card-header">
							<div class="row">
								<div class="col-md-9">
							
									<?php if ($user_level == 1): ?>
									<a href="claim_archive.php" class="btn btn-danger">TRASH <span class="bi bi-trash3-fill"></span></a>
									<?php endif;?>
								</div>
								<div class="col-md-3" style="text-align:right">
									<div class="d-grid gap-2 d-md-flex justify-content-md-end">
										<a href="claim_generate_index.php" class="btn btn-danger">PDF <span class="bi bi-filetype-pdf"></a>
										<a href="claim_generate_index_excel.php" class="btn btn-success">EXCEL <span class="bi bi-filetype-xls"></a>
									</div>
								</div>
							</div>
						</div>
						<?php							
							if(isset($_POST['add_claim'])) {
								$claim = $_POST['claim'];;
								$status = "Pending";
								$date = date("Y-m-d", strtotime("+7 HOURS"));
								
								$q_student = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error());
								$f_student = $q_student->fetch_array();
								$conn->query("INSERT INTO `claim` VALUES('', '$claim', '$date', '$status', '$user_id', '$username', '$user_level', '$fullname')") or die(mysqli_error());
							}
						?>
						<div class="card-body">
							<ul class="nav nav-pills">
								<li role="presentation"><a href="claim_history.php" class="btn" style="margin-bottom:10px">Pending</a></li>
								<li role="presentation" class="active"><a href="claim_history_accepted.php" class="btn btn-primary" style="margin-bottom:10px">Accepted<?php if(!$claim_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$claim_notif; ?></span><?php } ?></a></li>
								<li role="presentation"><a href="claim_history_rejected.php" class="btn" style="margin-bottom:10px">Rejected</a></li>
							</ul>
							
							<div style="">
								<table id="example" class="table table-striped data-table" style="width:100%">
									<thead>
										<tr>
											<th>User</th>
											<th>Claim</th>
										<th>Date</th>
										<th>Status</th>
										<th>Options</th>
										</tr>
									</thead>
									<?php
										$user = current_user();
										$username = $user['username'];
										$name = $user['name'];
										$user_level = $user['user_level'];
										$conn = new mysqli('localhost', 'root', '', 'bank');
										
										if ($user_level <= 1){
											$query = $conn->query("SELECT * FROM claim WHERE accepted = '1' ORDER BY claim_id DESC");
										}
										else if ($user_level <= 2){
											$query = $conn->query("SELECT * FROM claim WHERE accepted = '1' AND user_level >= 2 ORDER BY claim_id DESC");
										}
										else {
											$query = $conn->query("SELECT * FROM claim WHERE username = '$username' && accepted = '1' ORDER BY claim_id DESC");
										}
										while($user_data = mysqli_fetch_array($query)) {
											echo "<tr>";
											echo "<td>".$user_data['name']."</td>";
											echo "<td>".$user_data['claim']."</td>";
											echo "<td>".$user_data['claim_date']."</td>";
											echo "<td>".$user_data['status']."</td>";
											echo "<td><a href='claim_delete.php?claim_id=$user_data[claim_id]' class='btn btn-danger'data-toggle='tooltip' title='Remove'><i class='bi bi-eraser-fill'></i></a></td>";
											echo "</tr>";
										}?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
