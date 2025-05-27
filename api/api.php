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
        default:
                echo json_encode(['success' => false, 'error' => '參數異常'], JSON_UNESCAPED_UNICODE);
    }
?>