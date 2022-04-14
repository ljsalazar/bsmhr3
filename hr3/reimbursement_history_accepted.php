<?php
	$page_title = 'Reimbursement History';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	$user = current_user();
	$user_level = $user['user_level'];
	/**if ($user_level <= 1){
		header("Location:reimbursement_index_admin.php");
	}**/
	?><?php
	require_once("includes/load.php");
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	
	$claim;$currency;$amount;
	$conn = new mysqli('localhost', 'root', '', 'bank') or die(mysqli_error());   
	$user = current_user();
	$username = $user['username'];
	$name = $user['name'];
	$reimbursement_budget = $user['reimbursement_budget'];
	
	$user_level = $user['user_level'];
	$user_id = $user['id']; 
	
	$query = $conn->query("SELECT reimbursement_notif FROM users WHERE reimbursement_notif!=0 AND id='$user_id'");
	$query2 = $conn->query("UPDATE users SET reimbursement_notif=0 WHERE id=$user_id");
	
	include_once('layouts/header.php'); 
?>
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
			</div>
			<div class="col-md-12">
				<div class="card h-100">
					<div class="card-header">
						<div class="row">
							<div class="col-md-9">
								<h2>Reimbursements</h2>
								<?php
									echo "<p>Hello, ".$name."!</p>";
									echo "<p>Current Reimbursement budget: ".$reimbursement_budget." PHP</p>";
									
									if(isset($_POST['add_claim'])) {
										$claim = $_POST['claim'];;
										$status = "Pending";
										$date = date("Y-m-d", strtotime("+7 HOURS"));
										
										$q_student = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error());
										$f_student = $q_student->fetch_array();
										$conn->query("INSERT INTO `claim` VALUES('', '$claim', '$date', '$status', '$user_id', '$username', '$user_level', '$fullname')") or die(mysqli_error());
									}
								?>
							</div>
							<div class="col-md-3" style="text-align:right">
								<form class="form-inline" method="post" action="reimbursement_generate_index.php">
									<button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary">Generate history logs</button>
								</form>
								<?php if ($user_level == 1): ?>
								<!-- <form class="form-inline" method="post" action="reimbursement_archive.php">
									<button type="submit" id="pdf" name="generate_pdf" class="btn">Archive</button>
								</form> -->
								<a href="reimbursement_archive.php" class="btn btn-outline-danger"><span class="bi bi-trash3-fill"></a>
								<?php endif;?>
							</div>
						</div>
					</div>
					
					<div class="card-body" id="pending">
						<?php
							$query = $conn->query("SELECT reimbursement_notif FROM users WHERE id='$user_id'");
							while($user_data = mysqli_fetch_array($query)) {
								$reimbursement_notif = $user_data['reimbursement_notif'];
							}
							?>
							<ul class="nav nav-pills">
								<li role="presentation" class="active"><a href="reimbursement_history.php" class="btn" style="margin-bottom:10px">Pending Reimbursements</a></li>
							<li role="presentation"><a href="reimbursement_history_accepted.php" class="btn" style="margin-bottom:10px">Accepted Reimbursements <?php if(!$reimbursement_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$reimbursement_notif; ?></span><?php } ?></a></li>
						</ul>
						
						<div style="max-height:300px; overflow:auto;">
							<table id="datatablesSimple" class="table table-striped data-table" style="width:100%">
								<thead>
								<tr>
									<th>User</th>
									<th>Reimbursement Description</th>
									<th>Date</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Options</th>
								</tr>
							</thead>
							<?php
								if ($user_level <= 1){
									$query = $conn->query("SELECT * FROM reimbursements WHERE accepted=1 ORDER BY reimbursement_id DESC");
								} 
								else if ($user_level <= 2){
									$query = $conn->query("SELECT * FROM reimbursements WHERE accepted=1 AND user_level >= 2 ORDER BY reimbursement_id DESC");
								} 
								else {
									$query = $conn->query("SELECT * FROM reimbursements WHERE username='$username' && accepted=1 ORDER BY reimbursement_id DESC");
								}
								
								while($user_data = mysqli_fetch_array($query)) {
									echo "<tr>";
									echo "<td>".$user_data['name']."</td>";
									echo "<td>".$user_data['reimbursement']."</td>";
									echo "<td>".$user_data['reimbursement_date']."</td>";
									echo "<td>".$user_data['amount']."</td>";
									echo "<td>".$user_data['status']."</td>";
									if ($user_level <= 2){
										echo "<td><a href='reimbursement_delete.php?reimbursement_id=$user_data[reimbursement_id]'>Delete</a> | <a href='reimbursement_accept.php?reimbursement_id=$user_data[reimbursement_id]'>Accept</a></td>";
										} else {
										echo "<td><a href='reimbursement_delete.php?reimbursement_id=$user_data[reimbursement_id]'>Delete</a></td>";
									}
									echo "</tr>";
								}?>
						</table>
					</div>
				</div>
				
				</div>
			</div>
			
			<?php include('layouts/table/tablefooter.php');?>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
			<script src="dist/js/scripts.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
			<script src="dist/js/datatables-simple-demo.js"></script>
			
		</div><?php include_once('layouts/footer.php'); ?>
	</body>
</html>
