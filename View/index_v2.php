<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/home.css?v=<?php echo md5_file('assets/css/home.css')?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/2.0.1/chartjs-plugin-zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="assets/js/home.js?v=<?php echo md5_file('assets/js/home.js')?>"></script>
<script>    
    let tempRecord   = [];
    let fromDate     = "<?php echo $fromDate?>";
    let toDate       = "<?php echo $toDate?>";
    const spend_rows = <?php echo json_encode($dailyCosts)?>;
    const categorys  = <?php echo json_encode($categoryList)?>;
    const dailyCostByCategory = <?php echo json_encode($dailyCostByCategory)?>;
    const accountList = <?php echo json_encode($AccountList)?>;
</script>

<div class="container mt-4 pt-4 shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">

    <!-- 篩選器 -->
    <div class="filter-section bg-secondary bg-gradient">
        <h5 class="mb-3">
            <i class="fas fa-filter me-2"></i>篩選器
        </h5>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label text-white">開始日期</label>
                <input type="date" id="startDate" class="form-control" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">結束日期</label>
                <input type="date" id="endDate" class="form-control" value="">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">分類</label>
                <select id="categoryFilter" class="form-control">
                    <option value="">全部分類</option>
                    <?php 
                        foreach ($categoryList as $category) {
                            $categoryId     = $category['categoryId'];
                            $categoryName   = $category['categoryName'];
                            echo "<option value='$categoryId'>$categoryName</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">&nbsp;</label>
                <button class="btn btn-dark d-block w-100" onclick="applyFilters()">
                    <i class="fas fa-search me-2"></i>篩選
                </button>
            </div>
        </div>
    </div>

    <!-- 統計摘要 -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <div class="stat-value">$<?php echo number_format($thisMonthIncome)?></div>
                <div>收入</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card expense">
                <i class="fas fa-credit-card fa-2x mb-2"></i>
                <div class="stat-value">$<?php echo number_format($thisMonthSpend)?></div>
                <div>支出</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card budget">
                <i class="fas fa-piggy-bank fa-2x mb-2"></i>
                <div class="stat-value">$<?php echo number_format($thisMonthIncome+$thisMonthSpend)?></div>
                <div>結餘</div>
            </div>
        </div>
    </div>

    <!-- 圖表區域 -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>消費趨勢圖表
                    </h5>
                </div>
                <div class="card-body mb-3">
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-success"></i>分類分佈
                    </h5>
                </div>
                <div class="card-body mb-3">
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 當日消費明細 -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2 text-primary"></i>消費明細
                    </h5>
                    <div class="ms-auto">
                        <span id="recordCountFields" class="badge bg-primary">共 <?php echo count($lastTransRecord)?> 筆</span>
                        <span id="recordAmountFields" class="badge bg-info">共 <?php echo number_format($thisMonthIncome+$thisMonthSpend)?> 元</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <div class="btn-toolbar" role="toolbar" aria-label="排序工具">
                                <div class="btn-group btn-group-sm me-2" role="group" aria-label="金額排序">
                                    <button class="btn btn-outline-secondary" id="sortAmountDesc">金額：由大到小</button>
                                    <button class="btn btn-outline-secondary" id="sortAmountAsc">金額：由小到大</button>
                                </div>

                                <div class="btn-group btn-group-sm me-2" role="group" aria-label="日期排序">
                                    <button class="btn btn-outline-secondary" id="sortDateDesc">日期：最新</button>
                                    <button class="btn btn-outline-secondary" id="sortDateAsc">日期：最舊</button>
                                </div>
                            </div>
                        </div>

                        <div class="input-group border rounded" style="min-width:260px; max-width:40%;">
                            <input type="text" id="expenseSearch" class="form-control form-control-sm" placeholder="搜尋描述 / 商家">
                            <button class="btn btn-sm btn-outline-secondary" id="clearSearch" type="button">清除</button>
                        </div>
                    </div>
                    <div id="expenseList">
                    <?php
                        foreach ($lastTransRecord as $transRows) {
                    ?>
                        <div class="expense-item borderline"
                            data-amount="<?php echo $transRows['amount'];?>" 
                            data-date="<?php echo $transRows['spend_at'];?>" 
                            data-vendor="<?php echo $transRows['vendor_name'];?>"
                            data-subcategory_id="<?php echo $transRows['subcategory_id'];?>"
                            data-vendor_id="<?php echo $transRows['vendor_id'];?>"
                            data-account_id="<?php echo $transRows['account_id'];?>"
                            data-trans_no="<?php echo $transRows['trans_no'];?>"
                        >
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <i class="fas <?php echo $transRows['icon_name']?> fa-2x text-secondary"></i>
                                </div>
                                
                                <div class="col-md-2">
                                    <span class="badge bg-primary"><?php echo $transRows['account_name'];?></span>
                                    <span class="badge bg-info"><?php echo $transRows['category_name'].">".$transRows['subcategory_name']?></span>
                                </div>

                                <div class="col-md-7">
                                    <h6 class="mb-1">
                                        <span><?php echo $transRows['description']."(".$transRows['vendor_name'].")";?></span>
                                    </h6>
                                    <small class="text-muted"><?php echo $transRows['spend_at'];?></small>
                                </div>
                                
                                <!-- text-end -->
                                <div class="col-md-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 text-center">
                                            <?php
                                                if ($transRows['amount'] >= 0) {
                                                    echo '<h6 class="mb-0 text-success">+$' . number_format($transRows['amount']) . '</h6>';
                                                } else {
                                                    echo '<h6 class="mb-0 text-danger">-$' . number_format(abs($transRows['amount'])) . '</h6>';
                                                }
                                            ?>
                                        </div>
                                        <div class="ms-2 d-flex align-items-center">
                                            <i class="fa-regular fa-pen-to-square" style="cursor:pointer;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-primary">查看更多</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="expenseDetailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="expenseDetailModalBody" class="modal-body"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>