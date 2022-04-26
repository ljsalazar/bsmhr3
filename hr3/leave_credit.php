<?php
	$page_title = 'Credits';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(2);
	
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
	//$reimbursement_budget = $user['reimbursement_budget'];
	$credits = $user['leave_token'];
	$user_level = $user['user_level'];
	$user_id = $user['id'];
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
				<!-- <?php 
					$query = $conn->query("SELECT reimbursement_notif FROM users WHERE id='$user_id'");
					while($user_data = mysqli_fetch_array($query)) {
						$reimbursement_notif = $user_data['reimbursement_notif'];
					}
				?>
				<?php if ($user_level <= '2'): ?>
				<nav class="breadcrumbs">
					<a href="reimbursement_index.php" class="breadcrumbs__item">Reimburse</a>
					<a href="reimbursement_history.php" class="breadcrumbs__item">Reimbursement History <?php if(!$reimbursement_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$reimbursement_notif; ?></span><?php } ?></a>
					<a href="reimbursement_budget.php" class="breadcrumbs__item is-active">Budget</a>
				</nav>		
				<?php endif;?> -->
			</div>
			<div class="col-md-12">
				<div class="card h-100">
					<div class="card-header">
						<h2>Leave Credits</h2>
						<?php
							echo "<p>Hello, <b>".$name."!</b></p>";
							echo "<p>Current Leave Credits: <b>".$credits."</b></p>";
						?>
					</div>
					<div class="row">
					<div class="col-md-5">
						<div class="card-body">
							<h6 style="text-align:left">Provide Credits</h6>
							<div style="max-height:300px; overflow:auto;">
								<?php
									$fullname = $user['name'];
									
									if(isset($_POST['add_budget'])) {
										$user_selected = $_POST['user_selected'];
										$credit_leaves = $_POST['credit_leaves'];
										
										$q_student = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error());
										$f_student = $q_student->fetch_array();



										if($user_selected == "All users"){
											$conn->query("UPDATE users SET leave_token= leave_token + '$credit_leaves' ") or die(mysqli_error());
										}else{
											$conn->query("UPDATE users SET leave_token= leave_token + '$credit_leaves' WHERE name='$user_selected'") or die(mysqli_error());	
										}
										$session->msg('s',"Successfully Added");
										
										#header("Location:timesheet_index.php");
										echo "<script>window.location.href='leave_credit.php';</script>";
									}
								?>
								
								<form method="post" action="">
									<div class="form-group">
										<p>Select User:</p>
										<select class="form-control" name="user_selected" placeholder="Claim Type">
											<?php
											$query = $conn->query("SELECT name FROM users");
											$all = "All users";
											echo '<option>'.$all.'</option>';
											
											while($row = mysqli_fetch_array($query)){
												echo '<option>'.$row['name'].'</option>';
											}
										?>
										</select>
									</div></br>
									<div class="form-group">
										<input required type="number" class="form-control" name="credit_leaves" placeholder="0" min="0" value="10" readonly />
									</div></br>
									<button type="submit" name="add_budget" class="btn btn-primary" value="add_budget">Add</button>
								</form>
							</div>
						</div>
					</div>
					
					<div class="col-md-7">
						<div class="card-body">
							<h6 style="text-align:left">Credits Table</h6>
							<table id="example" class="table table-striped data-table" style="width:100%">
								<thead>
									<tr>
										<th>Name</th>
										<th>Leave Credits</th>
										<th>Action</th>
									</tr>
								</thead>
								<?php								
									$query = $conn->query("SELECT * FROM users ORDER BY id DESC");
									
									while($user_data = mysqli_fetch_array($query)) {
										echo "<tr>";
										echo "<td>".$user_data['name']."</td>";
										echo "<td>".$user_data['leave_token']."</td>";
										if ($user_level <= 2) {
											echo "<td><a href='leave_credit_edit.php?credit_id=$user_data[id]' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit'><i class='bi bi-pencil-fill'></i></a></td>";
										}
										echo "</tr>";
									}?>
							</table>
						</div>
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
