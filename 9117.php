<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hardware - Storage Inventory</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">Hardware - Storage Inventory</a>
            </div>
            <!-- /.navbar-header -->
           
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a>Server</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="hardware-list.php">Hardware List</a>
                                </li>
                                <li>
                                    <a href="lpar.php">LPAR List</a>
                                </li>
                                <li>
                                    <a href="hardware-lpar.php">Hardware-LPAR</a>
                                </li>
                                <li>
                                <a>Machine Type</a>
                                    <ul class="nav nav-second-level">
                                    
                                    <li>
                                        <a href="9117.php">9117</a>
                                    </li>
                                </ul>

                                </li>
                                
                            </ul>

                        </li>
                        <li>
                            <a>Storage</a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="storage-base.php">Storage-Base</a>
                                </li>
                                <li>
                                    <a href="storage-expansion.php">Storage-Expansion</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<!-- Table -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Hardware and LPAR</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table  class="table table-hover" style="border: solid 1px black">
                    <thead class="thead-inverse">
                        <tr>
                            <th style='width:120px;border:3px solid black;'>Hardware Full S/N</th>
                            <th style='width:120px;border:3px solid black;'>S/N</th>
                            <th style='width:120px;border:3px solid black;'>Rack_No</th>
                            <th style='width:120px;border:3px solid black;'>HMC</th>
                            <th style='width:120px;border:3px solid black;'>LPAR_Name</th>
                            <th style='width:120px;border:3px solid black;'>Status</th>
                            <th style='width:120px;border:3px solid black;'>IP_Address</th>
                            <th style='width:120px;border:3px solid black;'>HMC_IP</th>
                        </tr>
                    </thead>
                        <?php

                        $Query = "SELECT Hardware.Server_Full_SN,Hardware.Serial_Number,Hardware.Rack_No,Hardware.HMC,LPAR.LPAR,LPAR.Status,LPAR.IP_Address,LPAR.HMC_IP FROM Hardware LEFT JOIN LPAR ON Hardware.Serial_Number=LPAR.Hardware_Serial_Number WHERE Hardware.Machine_Type="9117" ";

                        class TableRows extends RecursiveIteratorIterator {
                            function __construct($it) {
                                parent::__construct($it, self::LEAVES_ONLY);
                            }

                            function current() {
                                return "<td style='width:120px;border:2px solid black;'>" . parent::current(). "</td>";
                            }

                            function beginChildren() {
                                echo "<tr>";
                            }

                            function endChildren() {
                                echo "</tr>" . "\n";
                            }
                        }

                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "Inventory_HMC_test";

                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $conn->prepare($Query);
                            $stmt->execute();

                            // set the resulting array to associative
                            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                                echo $v;
                            }
                        }
                        catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        $conn = null;
                        echo "</table>";
                        ?> 
                </div>
                <!-- /.col-lg-8 -->
                
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
