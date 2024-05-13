<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'doctor') {
    require_once('model/db_conn.php');
    include 'model/appointment.class.php';
    include 'model/user.class.php';
    include_once('model/patient.class.php');

    $dbh = Database::get_connection();
    $employee = (new Users($dbh))->getAllEmployeeData($_SESSION['user_id']);
    $app_class = new Appointment($dbh);
    $_SESSION['doctor_id'] = $employee["employee_id"];
    $nextApp = ($app_class)->getNextAppointment($employee["employee_id"]);
    $today_schedule = ($app_class)->getTodaysSchedule($employee["employee_id"]);
    $nr_patients = (new Patient($dbh))->getNrPatients();
    ?>

    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
        <?php include('shared-components/includes.php') ?>
        <title>Doctor Dashboard</title>
    </head>
    <body>
    <?php
    include('shared-components/doctor/sidebar.php');
    ?>
    <div class="main-content">

        <header>
            <div class="navbar navbar-dark">
                <a href="doctor-dashboard.php" class="logo me-auto"><img src="assets/images/logo.png" alt="Clinic Logo"
                                                                         class="img-fluid"></a>
                <a><?php echo $_SESSION['user']['username'] ?></a>
            </div>
        </header>

        <main>
            <nav aria-label="breadcrumb" style="margin-top: 30px;">
                <ol class="breadcrumb">
                    <h5 class="text-secondary">
                        Hello, <?php echo $_SESSION['user']['name'] . " ";
                        echo $_SESSION['user']['surname'] ?>
                    </h5>
                </ol>
            </nav>
            <br/>
            <div class="card" style="margin-top: auto">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-9">Your schedule for today</div>
                    </div>
                </div>
                <div class="card-body">
                    <!--  Employee Table-->
                    <div class="w-100">
                        <table id="today_table" class="display table" style="background: #6ca68b">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Visit time</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($today_schedule as $app) { ?>
                                <tr>
                                    <td id="full_name"> <?php echo $app['full_name'] ?> </td>
                                    <td id="full_name"> <?php echo $app['email'] ?> </td>
                                    <td id="full_name"> <?php echo $app['phone'] ?> </td>
                                    <td id="full_name"> <?php echo explode(' ', $app['time'])[1] ?> </td>
                                    <td id="full_name"> <?php echo $app['status'] ?> </td>
                                    <form action="" method="post">
                                        <td>
                                            <button type="submit" class="btn btn-warning btn-sm" value=""> Cancel <i
                                                        class='fas fa-times'></i></button>
                                        </td>
                                    </form>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="viewModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="ti-alarm-clock"></span> Next Appointment </h4>
                    <button type="button" class="close" data-dismiss="modal">&times</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Client</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone" name="phone" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time" class="col-sm-2 col-form-label">Time</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="time" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="desc" class="col-sm-2 col-form-label">Details</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="desc" readonly>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="view" class="btn btn-danger" data-dismiss="modal"> Close</button>
                </div>
            </div>

        </div>
    </div>
    <script>
        // Basic example
        $(document).ready(function () {
            $('#viewButton').on('click', function () {
                document.getElementById('name').value = document.getElementById('next_full_name').value;
                document.getElementById('email').value = document.getElementById('next_email').value;
                document.getElementById('phone').value = document.getElementById('next_phone').value;
                document.getElementById('time').value = document.getElementById('next_time').value;
                document.getElementById('desc').value = document.getElementById('next_desc').value;
            });
        });
    </script>

    </body>
    </html>
<?php } else {
    //Access Forbidden
    header("Location: ./login.php?error=Access Forbidden");
} ?>