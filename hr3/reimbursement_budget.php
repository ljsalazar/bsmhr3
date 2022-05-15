<?php
	$page_title = 'Budget';
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
				<?php 
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
				<?php endif;?>
			</div>
			<div class="col-md-12">
				<div class="card h-100">
					<div class="card-header">
						<h2>Provide Budget</h2>
									</div>
					<div class="row">
					<div class="col-md-5">
						<div class="card-body">
						
							<div style="max-height:600px; overflow:auto;">
								<?php
									$fullname = $user['name'];
									
									if(isset($_POST['add_budget'])) {
										$user_selected = $_POST['user_selected'];
										$budget_amount = $_POST['budget_amount'];
										
										$q_student = $conn->query("SELECT * FROM `users` WHERE `username` = '$username'") or die(mysqli_error());
										$f_student = $q_student->fetch_array();
										$conn->query("UPDATE users SET reimbursement_budget=reimbursement_budget + '$budget_amount' WHERE name='$user_selected'") or die(mysqli_error());
										
										$session->msg('s',"Successfully Added Budget");
										
										#header("Location:timesheet_index.php");
										echo "<script>window.location.href='reimbursement_budget.php';</script>";
									}
								?>
								
								<form method="post" action="">
									<div class="form-group">
										<p>Select User:</p>
										<select class="form-control" name="user_selected" placeholder="Claim Type">
										
											<?php
											$query = $conn->query("SELECT name FROM users");
											
											while($row = mysqli_fetch_array($query)){
												echo '<option>'.$row['name'].'</option>';
											}
										?>
										</select>
									</div></br>
									<div class="form-group">
										<input required type="text" class="form-control" name="budget_amount" placeholder="Amount" />
									</div></br>
									<button type="submit" name="add_budget" class="btn btn-primary" value="add_budget">Add</button>
								</form>
							</div>
						</div>
					</div>
					
					<div class="col-md-7">
						<div class="card-body">
							<h6 style="text-align:left">Allocated Budget</h6>
							<table id="example" class="table table-bordered data-table" style="width:100%">
								<thead>
									<tr>
										<th>Name</th>
										<th>Reimbursement Budget</th>
										<?php if ($user_level <= 1):?>
										<th>Option</th>
										<?php endif;?>
									</tr>
								</thead>
								<?php								
									$query = $conn->query("SELECT * FROM users ORDER BY id DESC");
									
									while($user_data = mysqli_fetch_array($query)) {
										echo "<tr>";
										echo "<td>".$user_data['name']."</td>";
										echo "<td>".$user_data['reimbursement_budget']."</td>";
										if ($user_level <= 1) {
											echo "<td><a href='reimbursement_budget_edit.php?reimbursement_id=$user_data[id]' class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit'><i class='bi bi-pencil-fill'></i></a></td>";
										}
										echo "</tr>";
									}?>
							</table>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div><?php include_once('layouts/footer.php'); ?>
	</body>
</html>
