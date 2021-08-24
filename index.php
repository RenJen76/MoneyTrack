<!DOCTYPE html>
<html>
<head>
    <?php 
        ini_set('display_errors', 0); 
        require 'Connection/Database.php';
        require 'Connection/Trans.php';
        require 'Service/TransService.php';
        $trans          = new Trans();
        $transService   = new TransService($trans);
    ?>
    
    <?php 
        include 'View/Common/Head.php';
    ?>

</head>
<body>
    <div class="container well">

        <?php 
            require 'View/Common/NavBar.php';
        ?>

        <div class="col-sm-12 main">
            <?php 
                switch ($_GET['route']) {
                    case 'report':
                        require 'View/report.php';
                        break;
                    case 'reportResult':
                        if (isset($_POST['reportDate'])) {
                            $title     = date('Y-m-d', $_POST['reportDate']);
                            $transList = $trans->transOnDate($_POST['reportDate']);
                        } elseif (isset($_POST['reportMonth'])) {
                            $title     = date('Y-m-d', $_POST['reportMonth']);
                            $transList = $trans->transOnMonth($_POST['reportMonth']);
                        } else {
                            header('location: index.php?route=index');
                            exit;
                        }
                        require 'View/reportResult.php';
                        break;
                    case 'create':
                        $categoryList  = $transService->getCateList();
                        require 'View/create.php';
                        break;
                    case 'createCost':
                        $res = $trans->save([
                            'spend_at'       => date('Y-m-d H:i:s', $_POST['spendAt']),
                            'vendor_id'      => $_POST['Vendor'],
                            'subcategory_id' => $_POST['Category'],
                            'amount'         => $_POST['Cost'],
                            'description'    => $_POST['Description']
                        ]);
                        break;
                    case 'analysisVendor':
                        if (isset($_POST['vendor'])) {
                            $title     = htmlentities($_POST['vendor']);
                            $transList = $transService->transByVendor($_POST['vendor']);
                            require 'View/analysisVendor.php';
                        } 
                        break;
                    default:
                        $totalSpend     = $transService->getTotalSpend();
                        $mostCostDay    = $trans->mostCostDay();
                        $mostCostTrans  = $trans->transOnDate($mostCostDay['spend_at']);
                        $costVendorRank = $trans->costVendorRank();
                        include 'View/index.php';
                        break;
                }
            ?>
        </div>
    </div>
</body>
</html>