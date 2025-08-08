<?php 
    header('Content-Type: application/json; charset=utf-8');
    ini_set('display_errors', 1); 
    error_reporting(E_ALL & ~E_NOTICE);

    require '../Connection/Database.php';
    require '../Connection/Trans.php';
    require '../Connection/ApiLogs.php';
    require '../Connection/Vendor.php';
    require '../Connection/Account.php';
    require '../Connection/Category.php';
    require '../Connection/SubCategory.php';
    require '../Service/TransService.php';

    $postData = json_decode(file_get_contents("php://input"), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'error' => '格式異常'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    switch ($postData['action']) {
        case 'createCategory':
            if (!isset($postData['category_name']) || empty($postData['category_name'])) {
                die(json_encode(['success' => false, 'error' => '分類名稱不可為空'], JSON_UNESCAPED_UNICODE));
            }
            if (!isset($postData['parent_category']) || empty($postData['parent_category'])) {
                $category = new Category();
                $result   = $category->create($postData['category_name']);
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => '分類建立失敗'], JSON_UNESCAPED_UNICODE);
                } 
            } else {
                $category       = new Category();
                $subCategory    = new SubCategory();
                $parentCategory = $category->findById($postData['parent_category']);
                if (!$parentCategory) {
                    echo json_encode(['success' => false, 'error' => '父分類不存在'], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                $result         = $subCategory->create($postData['category_name'], $postData['parent_category']);
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => '分類建立失敗'], JSON_UNESCAPED_UNICODE);
                }
            }                                                                                                                                                                                                                        
            
        break;
        
        case 'createVendor':
            if (!isset($postData['vendor_name']) || empty($postData['vendor_name'])) {
                die(json_encode(['success' => false, 'error' => '店家名稱不可為空'], JSON_UNESCAPED_UNICODE));
            }
            $vendor = new Vendor();
            $result = $vendor->findVendorByName($postData['vendor_name']);

            if ($result) {
                echo json_encode(['success' => false, 'error' => '店家名稱已存在']);
                exit;
            } 

            if ($vendor->createVendor($postData['vendor_name'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => '店家建立失敗'], JSON_UNESCAPED_UNICODE);
            }
        break;
        case 'createAccount':
            if (!isset($postData['account_name']) || empty($postData['account_name'])) {
                die(json_encode(['success' => false, 'error' => '帳戶名稱不可為空'], JSON_UNESCAPED_UNICODE));
            }
            $account = new Account();
            $result = $account->findAccountByName($postData['account_name']);

            if ($result) {
                echo json_encode(['success' => false, 'error' => '帳戶名稱已存在']);
                exit;
            } 

            if ($account->createAccount($postData['account_name'])) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => '帳戶建立失敗'], JSON_UNESCAPED_UNICODE);
            }
        break;
        case 'createSpend':
            $trans  = new Trans;
            $vendor = new Vendor();
            if ($postData['is_createCategory']){
                $vendor_id = $vendor->findOrCreate($postData['vendorId'])['vendor_id'];  
            } else {
                $vendor_id = intval($postData['vendorId']);
            }   
            $trans->createTrans([
                'accountId'     => $postData['accountId'],
                'spendAt'       => date('Y-m-d H:i:s', strtotime($postData['spendAt'])),
                'vendorId'      => $vendor_id,
                'subcategoryId' => $postData['categoryId'],
                'amount'        => $postData['amount'],
                'description'   => $postData['description']
            ]);
            if ($trans) {     
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => '建立失敗'], JSON_UNESCAPED_UNICODE);
            }
        break;

        case 'getDailyCostByDate':
            if (!isset($postData['date']) || empty($postData['date'])) {
                echo json_encode(['success' => false, 'error' => '日期不可為空'], JSON_UNESCAPED_UNICODE);
                exit;
            }
            $trans       = new Trans();
            $transRecord = $trans->transBetweenDays($postData['date'],$postData['date']);
            if ($transRecord) {
                echo json_encode(['success' => true, 'data' => $transRecord]);
            }
        default:
            echo json_encode(['success' => false, 'error' => '參數異常'], JSON_UNESCAPED_UNICODE);

    }
?>