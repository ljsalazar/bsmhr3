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
				
								<?php if ($user_level == 1): ?>
								<!-- <form class="form-inline" method="post" action="reimbursement_archive.php">
									<button type="submit" id="pdf" name="generate_pdf" class="btn">Archive</button>
								</form> -->
								<a href="reimbursement_archive.php" class="btn btn-danger">TRASH <span class="bi bi-trash3-fill"></span></a>
									<?php endif;?>
							</div>
							<div class="col-md-3" style="text-align:right">
								<div class="d-grid gap-2 d-md-flex justify-content-md-end">
									<a href="reimbursement_generate_index.php" class="btn btn-danger">PDF <span class="bi bi-filetype-pdf"></a>
									<a href="reimbursement_generate_index_excel.php" class="btn btn-success">EXCEL <span class="bi bi-filetype-xls"></a>
								</div>
								
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
								<li role="presentation"><a href="reimbursement_history.php" class="btn" style="margin-bottom:10px">Pending</a></li>
								<li role="presentation" class="active"><a href="reimbursement_history_accepted.php" class="btn btn-primary" style="margin-bottom:10px">Accepted<?php if(!$reimbursement_notif==0){ ?><span class="badge" style="background-color: red;"><?php echo (int)$reimbursement_notif; ?></span><?php } ?></a></li>
								<li role="presentation"><a href="reimbursement_history_rejected.php" class="btn" style="margin-bottom:10px">Rejected</a></li>
							</ul>
							
								<table id="example" class="table table-striped data-table" style="width:100%">
									<thead>
										<tr>
											<th>User</th>
											<th>Reimbursement Description</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Status</th>
											<th>Download</th>
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
											$imageURL = 'uploads/'.$user_data["picture"];
										?>
										<td class="text-center"><a href="reimbursement_download.php?picture=<?php echo $user_data['picture'] ?>" class="btn btn-outline-danger"><i class="bi bi-download"></i></a></td>
										<?php
											
											echo "<td><a href='reimbursement_delete.php?reimbursement_id=$user_data[reimbursement_id]' class='btn btn-danger'data-toggle='tooltip' title='Remove'><i class='bi bi-eraser-fill'></i></a></td>";
											echo "</tr>";
										}?>
								</table>
						</div>
						
					</div>
				</div>
			</div><?php include_once('layouts/footer.php'); ?>
		</body>
	</html>
