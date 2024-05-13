<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    include_once('model/db_conn.php');
    include_once('model/patient.class.php');
    include_once('model/employee.class.php');
    include_once('model/user.class.php');
    $dbh = Database::get_connection();
    $nr_employee = (new Employee($dbh))->get_total_all_records();
    $nr_patients = (new Patient($dbh))->getNrPatients();
    $nr_online = (new Users($dbh))->getNrOnline();
    ?>


    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Admin Dashboard</title>
</head>
<body>
<?php
include('shared-components/admin/sidebar1.php');
?>
<div class="main-content">

    <header>
        <div class="navbar navbar-dark">
            <a href="index.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo"
                                                          class="img-fluid"></a>
            <a><?php echo $_SESSION['user']['username'] ?></a>
        </div>
    </header>

    <main>

        <nav aria-label="breadcrumb" style="margin-top: 60px;">
            <ol class="breadcrumb">
                <h4 class="text-secondary">
                    Hello, <?php echo $_SESSION['user']['name'];
                    echo $_SESSION['user']['surname'] ?>
                </h4>
            </ol>
        </nav>

        <div class="dash-cards">
            <div class="card-single">
                <div class="card-body">
                    <span class="ti-briefcase" style="color: #FFA7A7"></span>
                    <div>
                        <h5>Active Employees</h5>
                        <h4><?php echo $nr_employee . ' Active Employees' ?></h4>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="admin-employees.php">View all</a>
                </div>
            </div>
        </div>
        <br/>

    </main>
</div>
</body>

<?php } else {
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>