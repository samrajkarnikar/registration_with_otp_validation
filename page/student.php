<?php
session_start();
include('connect/connection.php');
$errors = [];



// Retrieve registration details from registrationdetail table using mysqli
$sql_registration = "SELECT * FROM registrationdetails";
$result_registration = mysqli_query($connect, $sql_registration);
$registration_details = [];

if ($result_registration) {
    while ($row = mysqli_fetch_assoc($result_registration)) {
        $registration_details[] = $row;
    }
}

// Retrieve registration details from URL parameters if available
$registration_no = isset($_GET['registration_no']) ? $_GET['registration_no'] : '';
$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
$lastname = isset($_GET['lastname']) ? $_GET['lastname'] : '';
$college_name = isset($_GET['college_name']) ? $_GET['college_name'] : '';

$errors = [];
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profile Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="https://rawcdn.githack.com/Loopple/loopple-public-assets/ad60f16c8a16d1dcad75e176c00d7f9e69320cd4/argon-dashboard/css/nucleo/css/nucleo.css">
    <link rel="stylesheet" href="../style/theme.css">
    <link rel="stylesheet" href="../style/student.css">
</head>

<body>
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white loopple-fixed-start" id="sidenav-main">
        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:">
                            <i class="fa fa-desktop text-primary"></i>
                            <span class="nav-link-text">Profile</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="migration_form.php">
                            <i class="fa fa-lock text-danger"></i>
                            <span class="nav-link-text">Migration Certificate Form</span>
                        </a>
                    </li>

    
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark border-bottom bg-warning" id="navbarTop">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark active" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
                            </a>
                          
                        </li>
                       
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="https://demos.creative-tim.com/argon-dashboard/assets-old/img/theme/team-4.jpg">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">John Snow</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="#!" class="dropdown-item">
                                    <i class="fa fa-user"></i>
                                    <span>My profile</span>
                                </a>
                                <a href="reset_psw.php" class="dropdown-item">
                                    <i class="fa fa-tools"></i>
                                    <span>Change Password</span>
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a href="index.php" class="dropdown-item">
                                    <i class="fa fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid pt-3">
            <div class="row removable">
                <div class="col-lg-4">
                    <div class="card card-profile">
                        <img src="data:image/jpeg;base64,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" alt="Image placeholder" class="card-img-top">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="https://demos.creative-tim.com/argon-dashboard/assets-old/img/theme/team-4.jpg" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="btn btn-sm mr-4 btn-default">Connect</a>
                                <a href="#" class="btn btn-sm float-right btn-warning">Message</a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center text center">
                                    
                        
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                        <?php if(isset($student)) { ?>
                        <h5 class="h3">Student Name :<?php echo $student['firstname'] . ' ' . $student['lastname']; ?></h5>
                        <h5 class="h3">Email: :<?php echo $student['email']; ?></h5>
                       
                        <h5 class="h3">Current Address:<?php echo $student['current_address']; ?></h5>
                        <h5 class="h3">TU Registration Number: <?php echo $student['TU_registration_number']; ?></h5>
                        <h5 class="h3">College Name: <?php echo $student['college_name']; ?></h5>
                        <h5 class="h3">College Roll Number: <?php echo $student['college_roll_number']; ?></h5>

                    <?php } else { ?>
                       
                            <h5 colspan="6">No student details found.</h5>
                   
                    <?php } ?>
                                <h5 class="h3">
                                    Jessica Jones<span class="font-weight-light">, 27</span>
                                </h5>
                                <h5 class="font-weight-300">
                                    Bucharest, Romania
                                </h5>
                                <h5 class="h5 mt-4">
                                    Solution Manager - Creative Tim Officer
                                </h5>
                                <h5>
                                    University of Computer Science
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <div class="row removable">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Social traffic</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="#!" class="btn btn-sm btn-primary">See all</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Referral</th>
                                        <th scope="col">Visitors</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                               <tbody>
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Followers</h5>
                                    <span class="h2 font-weight-bold mb-0">2,356</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape text-white rounded-circle shadow bg-gradient-warning">
                                        <i class="fa fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
</div>
        
    </div>
    
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/jquery.min.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/js.cookie.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/5cef8f62939eeb089fa26d4c53a49198de421e3d/argon-dashboard/js/vendor/chart.extension.js"></script>
    <script src="https://rawcdn.githack.com/Loopple/loopple-public-assets/7bb803d2af2ab6d71d429b0cb459c24a4cd0fbb4/argon-dashboard/js/argon.min.js"></script>
    <script>
        if (document.querySelector(".chart-bar")) {
         var chartsBar = document.querySelectorAll(".chart-bar");
            
        chartsBar.forEach(function(chart) {
            new Chart(chart, {
               type: "bar",
               data: {
                 labels: ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                 datasets: [
                   {
                     label: "Sales",
                     tension: 0.4,
                     borderWidth: 0,
                     pointRadius: 0,
                     backgroundColor: "#fb6340",
                     data: [25, 20, 30, 22, 17, 29],
                     maxBarThickness: 10,
                   },
                 ],
               },
               options: {
                 responsive: true,
                 maintainAspectRatio: false,
                 legend: {
                   display: false,
                 },
                 tooltips: {
                   enabled: true,
                   mode: "index",
                   intersect: false,
                 },
                 scales: {
                   yAxes: [
                     {
                       gridLines: {
                         borderDash: [2],
                         borderDashOffset: [2],
                         drawTicks: false,
                         drawBorder: false,
                         lineWidth: 1,
                         zeroLineWidth: 0,
                         zeroLineBorderDash: [0],
                         zeroLineBorderDashOffset: [2],
                       },
                       ticks: {
                         beginAtZero: true,
                         padding: 10,
                         fontSize: 13,
                         lineHeight: 5,
                         fontColor: "#8898aa",
                         fontFamily: "Open Sans",
                       },
                     },
                   ],
                   xAxes: [
                     {
                       gridLines: {
                         display: false,
                         drawBorder: false,
                         drawOnChartArea: false,
                         drawTicks: false,
                       },
                       ticks: {
                         padding: 20,
                         fontSize: 13,
                         fontColor: "#8898aa",
                         fontFamily: "Open Sans",
                       },
                     },
                   ],
                 },
               },
            }); 
        });
        }
        
        if (document.querySelector(".chart-line")) {
        
            var chartsLine = document.querySelectorAll(".chart-line");
        
            chartsLine.forEach(function(chart) {
              
                new Chart(chart, {
                    type: "line",
                    data: {
                        labels: ["May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Performance",
                            tension: 0.4,
                            borderWidth: 4,
                            borderColor: "#5e72e4",
                            pointRadius: 0,
                            backgroundColor: "transparent",
                            data: [0, 20, 10, 30, 15, 40, 20, 60, 60],
                        }, ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            display: false,
                        },
                        tooltips: {
                            enabled: true,
                            mode: "index",
                            intersect: false,
                        },
                        scales: {
                            yAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: false,
                                    color: "rgba(29,140,248,0.0)",
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 0,
                                    fontColor: "#8898aa",
                                    fontSize: 13,
                                    fontFamily: "Open Sans",
                                },
                            }, ],
                            xAxes: [{
                                barPercentage: 1.6,
                                gridLines: {
                                    drawBorder: false,
                                    color: "rgba(29,140,248,0.0)",
                                    zeroLineColor: "transparent",
                                },
                                ticks: {
                                    padding: 10,
                                    fontColor: "#8898aa",
                                    fontSize: 13,
                                    fontFamily: "Open Sans",
                                },
                            }, ],
                        },
                        layout: {
                            padding: 0,
                        },
                    },
                });
              
            });
        }
    </script>
</body>