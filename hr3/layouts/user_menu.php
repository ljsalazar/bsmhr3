<ul class="navbar-nav">
  <li>
    <div class="text-muted small fw-bold text-uppercase px-3">
      CORE
    </div>
  </li>
  <li>
    <a href="../index.php" class="nav-link px-3 active">
      <span class="me-2"><i class="bi bi-speedometer2"></i></span>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
  <li>
    <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
      Interface
    </div>
  </li>
<!-- All Sub modules Side Nav Bar -->

<!-- HR3 -->
  <li>
    <a
      class="nav-link px-3 sidebar-link"
      data-bs-toggle="collapse"
      href="#hr3"
    >
      <span class="me-2"><i class="bi bi-receipt"></i></span>
		<span>Human Resource 3</span>
     


      <span class="ms-auto">
        <span class="right-icon">
          <i class="bi bi-chevron-down"></i>
        </span>
      </span>
    </a>
    <div class="collapse" id="hr3">
      <ul class="navbar-nav ps-3">
        <li>
          <a href="claim_index.php" class="nav-link px-3">
            <span class="me-2"
              ><i class="bi bi-credit-card-fill"></i
            ></span>
            <span>Claims</span>
          </a>
        </li>
        <li>
          <a href="reimbursement_index.php" class="nav-link px-3">
            <span class="me-2"
              ><i class="bi bi-bag"></i
            ></span>
            <span>Reimbursements</span>
          </a>
        </li>
        <li>
          <a href="time_index.php" class="nav-link px-3">
            <span class="me-2"
              ><i class="bi bi-cone-striped"></i
            ></span>
            <span>Time and Attendance</span>
          </a>
        </li>
        <li>
          <a href="schedule.php" class="nav-link px-3">
            <span class="me-2"
              ><i class="bi bi-calendar-week-fill"></i
            ></span>
            <span>Shift and Scheduling</span>
          </a>
        </li>
		<li>
          <a href="apply_leave.php" class="nav-link px-3">
            <span class="me-2"
              ><i class="bi bi-calendar2-check"></i
            ></span>
            <span>Leave Management</span>
          </a>
        </li>
      </ul>
    </div>
  </li>
  <!-- End of HR3 -->


    <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
      Addons
    </div>
  </li>
  <li>
    <!-- <a href="#" class="nav-link px-3">
      <span class="me-2"><i class="bi bi-graph-up"></i></span>
      <span>Charts</span>
    </a>
  </li>
  <li>
    <a href="#" class="nav-link px-3">
      <span class="me-2"><i class="bi bi-table"></i></span>
      <span>Tables</span>
    </a> 
    <a href="../users.php" class="nav-link px-3">
      <span class="me-2"><i class="bi bi-people-fill"></i></span>
      <span>Manage Users</span>
    </a>-->
    <a href="" class="nav-link px-3">
      <span class="me-2"><i class="bi bi-clock-fill"></i></span>
      <span>: <span class="badge rounded bg-secondary"><?php echo date("F j, Y, g:i a");?></span></span>
    </a>
    <a href="#" class="nav-link px-3">
      <span class="me-2"><i class="bi bi-back"></i></span>
      <span><button class="btn-toggle btn-secondary background"><i class="bi bi-moon-fill"></i></button></span>
    </a>
  </li>
  </ul>
