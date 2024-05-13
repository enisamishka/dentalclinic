<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'receptionist') {
    include_once('model/db_conn.php');
    include_once('model/patient.class.php');
    $dbh = Database::get_connection();
    $nr_patients = (new Patient($dbh))->getNrPatients();

    ?>

    <html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include('shared-components/includes.php') ?>
    <title>Receptionist Dashboard</title>
</head>
<body>
<?php
include('shared-components/receptionist/sidebar.php');
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
                    Hello, <?php echo $_SESSION['user']['name'] . " ";
                    echo $_SESSION['user']['surname'] ?>
                </h4>
            </ol>
        </nav>

        <div class="dash-cards">

            <div class="card-single">
                <div class="card-body">
                    <span class="ti-time"></span>
                    <div>
                        <h5>Schedule Appointment</h5>
                        <h4>New</h4>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="receptionist-scheduleAppointment.php"> <i class="fa fa-plus-circle fa-2x"
                                                                       style="color: #68a186"></i></a>
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