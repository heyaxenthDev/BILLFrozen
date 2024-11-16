<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in

include "includes/conn.php";
include_once 'includes/header.php';
include 'includes/sidebar.php';
include "alert.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bordered Table</h5>
                        <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p>
                        <!-- Bordered Table -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Age</th>
                                    <th scope="col">Start Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Brandon Jacob</td>
                                    <td>Designer</td>
                                    <td>28</td>
                                    <td>2016-05-25</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Bridie Kessler</td>
                                    <td>Developer</td>
                                    <td>35</td>
                                    <td>2014-12-05</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Ashleigh Langosh</td>
                                    <td>Finance</td>
                                    <td>45</td>
                                    <td>2011-08-12</td>
                                </tr>
                                <tr>
                                    <th scope="row">4</th>
                                    <td>Angus Grady</td>
                                    <td>HR</td>
                                    <td>34</td>
                                    <td>2012-06-11</td>
                                </tr>
                                <tr>
                                    <th scope="row">5</th>
                                    <td>Raheem Lehner</td>
                                    <td>Dynamic Division Officer</td>
                                    <td>47</td>
                                    <td>2011-04-19</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Bordered Table -->

                    </div>
                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <div class="row">

                    <!-- Total Products Card -->
                    <div class="col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title-reports">Total Products</h5>

                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6>145</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Total Products Card -->

                    <!-- Total Unit Sold Card -->
                    <div class="col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title-reports">Total Unit Sold</h5>

                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6>$3,264</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Total Unit Sold Card -->

                    <!-- Total Revenue Card -->
                    <div class="col-md-6">

                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title-reports">Total Revenue</h5>

                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6>1244</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Total Revenue Card -->

                    <!-- No. of Item out of stocks Card -->
                    <div class="col-md-6">

                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title-reports">No. of Item out of stocks</h5>

                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <h6>1244</h6>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End No. of Item out of stocks Card -->

                </div>


            </div><!-- End Right side columns -->

        </div>

        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bar Chart</h5>

                        <!-- Bar Chart -->
                        <div id="barChart"></div>

                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#barChart"), {
                                series: [{
                                    data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
                                }],
                                chart: {
                                    type: 'bar',
                                    height: 350
                                },
                                plotOptions: {
                                    bar: {
                                        borderRadius: 4,
                                        horizontal: true,
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                xaxis: {
                                    categories: ['South Korea', 'Canada', 'United Kingdom',
                                        'Netherlands', 'Italy', 'France', 'Japan',
                                        'United States', 'China', 'Germany'
                                    ],
                                }
                            }).render();
                        });
                        </script>
                        <!-- End Bar Chart -->

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Reports -->
                <div class="col-12">
                    <div class="card">

                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Reports <span>/Today</span></h5>

                            <!-- Line Chart -->
                            <div id="reportsChart"></div>

                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#reportsChart"), {
                                    series: [{
                                        name: 'Sales',
                                        data: [31, 40, 28, 51, 42, 82, 56],
                                    }, {
                                        name: 'Revenue',
                                        data: [11, 32, 45, 32, 34, 52, 41]
                                    }, {
                                        name: 'Customers',
                                        data: [15, 11, 32, 18, 9, 24, 11]
                                    }],
                                    chart: {
                                        height: 350,
                                        type: 'area',
                                        toolbar: {
                                            show: false
                                        },
                                    },
                                    markers: {
                                        size: 4
                                    },
                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100]
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth',
                                        width: 2
                                    },
                                    xaxis: {
                                        type: 'datetime',
                                        categories: ["2018-09-19T00:00:00.000Z",
                                            "2018-09-19T01:30:00.000Z",
                                            "2018-09-19T02:30:00.000Z",
                                            "2018-09-19T03:30:00.000Z",
                                            "2018-09-19T04:30:00.000Z",
                                            "2018-09-19T05:30:00.000Z",
                                            "2018-09-19T06:30:00.000Z"
                                        ]
                                    },
                                    tooltip: {
                                        x: {
                                            format: 'dd/MM/yy HH:mm'
                                        },
                                    }
                                }).render();
                            });
                            </script>
                            <!-- End Line Chart -->

                        </div>

                    </div>
                </div><!-- End Reports -->
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>