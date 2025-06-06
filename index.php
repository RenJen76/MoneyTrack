<!DOCTYPE html>
<html>
<head>
    <?php 
        ini_set('display_errors', 1); 
        error_reporting(E_ALL & ~E_NOTICE);
        require 'Connection/Database.php';
        require 'Connection/Trans.php';
        require 'Connection/ApiLogs.php';
        require 'Connection/Vendor.php';
        require 'Connection/Account.php';
        require 'Connection/Category.php';
        require 'Connection/SubCategory.php';
        require 'Service/TransService.php';
        $trans          = new Trans();
        $transService   = new TransService($trans);
    ?>
    
    <?php include 'View/Common/Head.php';?>

</head>
<body>
    <div class="container well" style="height: 100vh">

        <?php 
            require 'View/Common/NavBar.php';
        ?>

        <div class="main">
            <?php 
                switch ($_GET['route']) {
                    case 'report':
                        require 'View/report.php';
                        break;
                    case 'reportResult':
                        if (isset($_POST['reportDate'])) {
                            $title     = date('Y-m-d', strtotime($_POST['reportDate']));
                            $transList = $trans->transOnDate($_POST['reportDate']);
                        } elseif (isset($_POST['reportMonth'])) {
                            $title     = date('Y-m-d', strtotime($_POST['reportMonth']));
                            $transList = $trans->transOnMonth($_POST['reportMonth']);
                        } else {
                            header('location: index.php?route=index');
                            exit;
                        }
                        require 'View/reportResult.php';
                        break;
                    case 'create':
                        $Account      = new Account();
                        $AccountList  = $Account->getAll();
                        $categoryList = $transService->getCateList();
                        $Vendor       = new Vendor();
                        $vendorList   = $Vendor->getAll();
                        require 'View/create.php';
                        break;
                    case 'createCategory':
                        $categoryList  = $transService->getCateList();
                        require 'View/createCategory.php';
                        break;
                    case 'createVendor':
                        $Vendor      = new Vendor();
                        $vendorList  = $Vendor->getAll();
                        require 'View/createVendor.php';
                        break;
                    case 'createAccount':
                        $Account      = new Account();
                        $AccountList  = $Account->getAll();
                        require 'View/createAccount.php';
                        break;
                    case 'analysisVendor':
                        if (isset($_POST['vendor'])) {
                            $title     = htmlentities($_POST['vendor']);
                            $transList = $transService->transByVendor($_POST['vendor']);
                            require 'View/analysisVendor.php';
                        } 
                        break;
                    case 'import':
                        if ($_SERVER['REQUEST_METHOD']=='POST') {
                            $import = $transService->import();
                            exit;
                        } else {
                            require 'View/importFile.php';
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