<?php
	$page_title = 'Claim Archive';
	require_once('includes/load.php');
	// Checkin What level user has permission to view this page
	page_require_level(3);
	
	$user = current_user();
	$user_level = $user['user_level'];
	if ($user_level <= 1){
		#	header("Location:claim_index_admin.php");
	}
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
					<div class="card h-100">
						<div class="card-header">
							<h2>Deleted Claim Logs</h2>
							<p>Archived items you can retrieve or permanently delete</p>
							<button name="cancel" class="btn btn-primary" onclick="location.href='claim_history.php'">Back</button>
						</div>
						<div class="card-body">
							<div style="max-height:600px">
								<table id="example" class="table table-striped data-table" style="width:100%">
									<thead>
										<tr>
											<th>User</th>
											<th>Claim</th>
											<th>Date</th>
											<th>Status</th>
											<th>Remarks</th>
											<th>Options</th>
										</tr>
									</thead>
									<?php
										$query = $conn->query("SELECT * FROM claim_archive ORDER BY claim_id DESC");
										
										while($user_data = mysqli_fetch_array($query)) {
											echo "<tr>";
											echo "<td>".$user_data['name']."</td>";
											echo "<td>".$user_data['claim']."</td>";
											echo "<td>".$user_data['claim_date']."</td>";
											echo "<td>".$user_data['status']."</td>";
											echo "<td>".$user_data['remarks']."</td>";
											echo "<td><a href='claim_retrieve_archive.php?claim_id=$user_data[claim_id]'class='btn btn-secondary'data-toggle='tooltip' title='Retrieve'><i class='bi bi-folder-symlink-fill'></i></a> <a href='claim_delete_archive.php?claim_id=$user_data[claim_id]' class='btn btn-danger'data-toggle='tooltip' title='Remove'><i class='bi bi-eraser-fill'></i></a></td>";
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
		