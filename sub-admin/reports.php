<?php
include 'authentication.php';
checkLogin(); // Call the function to check if the user is logged in

include "includes/conn.php";
include_once 'includes/header.php';
include 'includes/sidebar.php';
include "alert.php";

$getCurrentMonth = date('F');

?>

<main id="main" class="main">

    <style>
    @media print {
        body * {
            visibility: hidden !important;
        }

        h1 {
            padding-bottom: 10px;
        }

        #printArea,
        #printArea * {
            visibility: visible !important;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100vw;
            background: #fff;
            z-index: 9999;
        }

        .filter-print-btns {
            display: none !important;
        }

        .breadcrumb {
            display: none !important;
        }
    }
    </style>

    <div id="printArea">

        <div class="pagetitle row align-items-center">
            <!-- Left side: Page Title -->
            <div class="col-md-6">
                <h1>Reports</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </nav>
            </div>

            <!-- Right side: Filters -->
            <div class="col-md-6 d-flex justify-content-end">
                <form method="GET" action="" class="w-100">
                    <div class="row align-items-end gap-2">
                        <!-- Month Filter -->
                        <div class="col-md-4 col-4">
                            <label for="month" class="form-label">Select Month:</label>
                            <select name="month" id="month" class="form-control">
                                <option value="">All Months</option>
                                <?php
                        for ($m = 1; $m <= 12; $m++) {
                            $monthName = date("F", mktime(0, 0, 0, $m, 1));
                            $selected = (isset($_GET['month']) && $_GET['month'] == $m) ? "selected" : "";
                            echo "<option value='$m' $selected>$monthName</option>";
                        }
                        ?>
                            </select>
                        </div>

                        <!-- Year Filter -->
                        <div class="col-md-4 col-4">
                            <label for="year" class="form-label">Select Year:</label>
                            <select name="year" id="year" class="form-control">
                                <option value="">All Years</option>
                                <?php
                        $currentYear = date("Y");
                        for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
                            $selected = (isset($_GET['year']) && $_GET['year'] == $y) ? "selected" : "";
                            echo "<option value='$y' $selected>$y</option>";
                        }
                        ?>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-2 col-2 filter-print-btns">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-1 col-1 filter-print-btns">
                            <button type="button" class="btn btn-secondary" onclick="printReport()"><i
                                    class="bi bi-printer"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Page Title -->


        <section class="section dashboard mt-3">

            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sales</h5>
                            <!-- Bordered Table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price per Unit</th>
                                        <th scope="col">Unit Sold</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <?php

                            // Get selected month and year from URL parameters
                            $selectedMonth = isset($_GET['month']) ? $_GET['month'] : "";
                            $selectedYear = isset($_GET['year']) ? $_GET['year'] : "";

                            // Build WHERE clause dynamically
                            $whereConditions = [];

                            if (!empty($selectedMonth)) {
                                $whereConditions[] = "MONTH(date_created) = " . intval($selectedMonth);
                            }
                            if (!empty($selectedYear)) {
                                $whereConditions[] = "YEAR(date_created) = " . intval($selectedYear);
                            }

                            // Combine conditions into a single WHERE clause
                            $whereSQL = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

                            // Fetch Sales Data based on filters
                            $filteredSalesQuery = "SELECT product_name, price, sold, (price * sold) AS total 
                                                FROM inventory $whereSQL";
                            $filteredSales = $conn->query($filteredSalesQuery);
                            ?>

                                <tbody>
                                    <?php
                                $count = 1;
                                while ($row = $filteredSales->fetch_assoc()) {
                                    echo "<tr>
                                            <th scope='row'>{$count}</th>
                                            <td>{$row['product_name']}</td>
                                            <td>$" . number_format($row['price'], 2) . "</td>
                                            <td>{$row['sold']}</td>
                                            <td>$" . number_format($row['total'], 2) . "</td>
                                        </tr>";
                                    $count++;
                                }
                                ?>
                                </tbody>

                            </table>
                            <!-- End Bordered Table -->

                        </div>
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">

                    <div class="row">

                        <?php 
                $selectedMonth = isset($_GET['month']) ? $_GET['month'] : "";
                $selectedYear = isset($_GET['year']) ? $_GET['year'] : "";
                
                $whereConditions = [];
                if (!empty($selectedMonth)) {
                    $whereConditions[] = "MONTH(date_created) = " . intval($selectedMonth);
                }
                if (!empty($selectedYear)) {
                    $whereConditions[] = "YEAR(date_created) = " . intval($selectedYear);
                }
                
                $whereSQL = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";
                $totalProductsQuery = "SELECT COUNT(id) AS total_products FROM inventory";
                $totalProductsResult = $conn->query($totalProductsQuery);
                $totalProducts = ($totalProductsResult->fetch_assoc())['total_products'];
                $totalUnitsSoldQuery = "SELECT SUM(sold) AS total_units FROM inventory $whereSQL";
                $totalUnitsSoldResult = $conn->query($totalUnitsSoldQuery);
                $totalUnitsSold = ($totalUnitsSoldResult->fetch_assoc())['total_units'] ?? 0;
                $totalRevenueQuery = "SELECT SUM(price * sold) AS total_revenue FROM inventory $whereSQL";
                $totalRevenueResult = $conn->query($totalRevenueQuery);
                $totalRevenue = ($totalRevenueResult->fetch_assoc())['total_revenue'] ?? 0;
                $outOfStockQuery = "SELECT COUNT(id) AS out_of_stock FROM inventory WHERE quantity = 0";
                $outOfStockResult = $conn->query($outOfStockQuery);
                $outOfStock = ($outOfStockResult->fetch_assoc())['out_of_stock'];
                                                                                
                ?>
                        <!-- Total Products Card -->
                        <div class="col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title-reports">Total Products</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="ps-3">
                                            <h6><?= $totalProducts ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Units Sold Card -->
                        <div class="col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title-reports">Total Units Sold</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="ps-3">
                                            <h6><?= number_format($totalUnitsSold) ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Revenue Card -->
                        <div class="col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title-reports">Total Revenue</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="ps-3">
                                            <h6>₱<?= number_format($totalRevenue, 2) ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Out of Stock Items Card -->
                        <div class="col-md-6">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title-reports">Out of Stock Items</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="ps-3">
                                            <h6><?= $outOfStock ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div><!-- End Right side columns -->

            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Best Sellers</h5>

                            <?php 
                        // Fetch top 10 selling products
                        $topProductsQuery = "SELECT product_name, sold FROM inventory ORDER BY sold DESC LIMIT 10";
                        $topProducts = $conn->query($topProductsQuery);

                        $productNames = [];
                        $salesData = [];

                        while ($row = $topProducts->fetch_assoc()) {
                            $productNames[] = $row['product_name'];
                            $salesData[] = $row['sold'];
                        }

                        $productNamesJson = json_encode($productNames);
                        $salesDataJson = json_encode($salesData);
                        ?>

                            <!-- Best Sellers -->
                            <div id="barChart"></div>

                            <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#barChart"), {
                                    series: [{
                                        data: <?= $salesDataJson ?>
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 350
                                    },
                                    plotOptions: {
                                        bar: {
                                            borderRadius: 4,
                                            horizontal: true
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    xaxis: {
                                        categories: <?= $productNamesJson ?>
                                    }
                                }).render();
                            });
                            </script>
                            <!-- End Best Sellers -->

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <?php 
                        $salesForecastQuery = "SELECT DATE(date_created) AS sale_date, SUM(sold) AS units_sold, SUM(price * sold) AS revenue 
                        FROM inventory $whereSQL
                        GROUP BY DATE(date_created)
                        ORDER BY sale_date ASC";
                        $salesForecastResult = $conn->query($salesForecastQuery);
                        
                        $salesData = [];
                        $revenueData = [];
                        $dateLabels = [];
                        
                        while ($row = $salesForecastResult->fetch_assoc()) {
                            $dateLabels[] = $row['sale_date'];
                            $salesData[] = $row['units_sold'];
                            $revenueData[] = $row['revenue'];
                        }
                        
                        $salesDataJson = json_encode($salesData);
                        $revenueDataJson = json_encode($revenueData);
                        $dateLabelsJson = json_encode($dateLabels);

                    ?>


                            <div class="card-body">
                                <h5 class="card-title">Sales Forecast <span>/Today</span></h5>

                                <!-- Line Chart -->
                                <div id="reportsChart"></div>

                                <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#reportsChart"), {
                                        series: [{
                                                name: 'Sales',
                                                data: <?= $salesDataJson ?>, // Units sold per day
                                            },
                                            {
                                                name: 'Revenue',
                                                data: <?= $revenueDataJson ?>, // Revenue per day
                                            },
                                        ],
                                        chart: {
                                            height: 350,
                                            type: 'area',
                                            toolbar: {
                                                show: false
                                            }
                                        },
                                        markers: {
                                            size: 4
                                        },
                                        colors: ['#4154f1', '#2eca6a'], // Customize colors
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
                                            categories: <?= $dateLabelsJson ?>, // Display dates on the x-axis
                                        },
                                        tooltip: {
                                            x: {
                                                format: 'dd/MM/yy'
                                            }, // Format the date in the tooltip
                                        }
                                    }).render();
                                });
                                </script>


                            </div>

                        </div>
                    </div><!-- End Sales Forecast -->
                </div>

            </div>
        </section>

    </div> <!-- End #printArea -->

</main><!-- End #main -->

<?php
include 'includes/footer.php';
?>

<script>
function printReport() {
    window.print();
}
</script>