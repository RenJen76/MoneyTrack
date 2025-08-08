<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-zoom/2.0.1/chartjs-plugin-zoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<style>
    /* body {
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        /* min-height: 100vh; */
        /* font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; */
    /* } */
    
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        backdrop-filter: blur(10px);
        background: rgba(255,255,255,0.95);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    /* .navbar {
        background: rgba(255,255,255,0.1) !important;
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    
    .navbar-brand {
        font-weight: bold;
        color: white !important;
    } */
    
    .stat-card {
        text-align: center;
        padding: 1.5rem;
        background: linear-gradient(45deg, #4CAF50, #45a049);
        color: white;
        border-radius: 15px;
        margin-bottom: 1rem;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s;
    }
    
    .stat-card:hover::before {
        transform: translateX(100%);
    }
    
    .stat-card.expense {
        background: linear-gradient(45deg, #f44336, #d32f2f);
    }
    
    .stat-card.budget {
        background: linear-gradient(45deg, #2196F3, #1976D2);
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        margin: 0.5rem 0;
    }
    
    .filter-section {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .expense-item {
        border-left: 4px solid #007bff;
        padding: 1rem;
        margin-bottom: 1rem;
        background: rgba(255,255,255,0.8);
        border-radius: 0 10px 10px 0;
        transition: all 0.3s ease;
    }
    
    .expense-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .expense-item.food { border-left-color: #ff9800; }
    .expense-item.transport { border-left-color: #4caf50; }
    .expense-item.entertainment { border-left-color: #e91e63; }
    .expense-item.shopping { border-left-color: #9c27b0; }
    
    .chart-container {
        position: relative;
        height: 400px;
        margin: 1rem 0;
    }
    
    /* .btn-primary {
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    } */
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.9);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

<div class="container mt-4 pt-4 shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
    <!-- 統計摘要 -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <div class="stat-value">$12,450</div>
                <div>本月收入</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card expense">
                <i class="fas fa-credit-card fa-2x mb-2"></i>
                <div class="stat-value">$<?php echo number_format($thisMonthsSpend)?></div>
                <div>本月支出</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card budget">
                <i class="fas fa-piggy-bank fa-2x mb-2"></i>
                <div class="stat-value">$4,220</div>
                <div>本月結餘</div>
            </div>
        </div>
    </div>

    <!-- 篩選器 -->
    <div class="filter-section bg-secondary bg-gradient">
        <h5 class="mb-3">
            <i class="fas fa-filter me-2"></i>篩選器
        </h5>
        <div class="row">
            <div class="col-md-3">
                <label class="form-label text-white">開始日期</label>
                <input type="date" id="startDate" class="form-control" value="2024-01-01">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">結束日期</label>
                <input type="date" id="endDate" class="form-control" value="2024-01-31">
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
                        <i class="fas fa-list me-2 text-info"></i>今日消費明細
                    </h5>
                    <span class="badge bg-primary">共 8 筆</span>
                </div>
                <div class="card-body">
                    <div id="expenseList">
                        <div class="expense-item food">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <i class="fas fa-utensils fa-2x text-warning"></i>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">午餐 - 便當</h6>
                                    <small class="text-muted">12:30</small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-warning">餐飲</span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h6 class="mb-0 text-danger">-$120</h6>
                                </div>
                            </div>
                        </div>

                        <div class="expense-item transport">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <i class="fas fa-bus fa-2x text-success"></i>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">公車費用</h6>
                                    <small class="text-muted">08:45</small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-success">交通</span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h6 class="mb-0 text-danger">-$30</h6>
                                </div>
                            </div>
                        </div>

                        <div class="expense-item entertainment">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <i class="fas fa-film fa-2x text-danger"></i>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">電影票</h6>
                                    <small class="text-muted">19:00</small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-danger">娛樂</span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h6 class="mb-0 text-danger">-$320</h6>
                                </div>
                            </div>
                        </div>

                        <div class="expense-item shopping">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <i class="fas fa-shopping-bag fa-2x text-purple"></i>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1">日用品購買</h6>
                                    <small class="text-muted">16:20</small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge bg-purple">購物</span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <h6 class="mb-0 text-danger">-$450</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <button class="btn btn-outline-primary">查看更多</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo "<pre>";print_r($dailyCostByCategory);
?>
<script>
    const spend_rows = <?php echo json_encode($dailyCosts)?>;
    const categorys  = <?php echo json_encode($categoryList)?>;
    const dailyCostByCategory = <?php echo json_encode($dailyCostByCategory)?>;
    const varColors  = ["#ff6384", "#36a2eb", "#4caf50", "#ffce56", "#9966ff"];

    // 產生每個 varColor 的五階漸層色（由深到淺）
    function generateColorShades(hex, steps = 5) {
        // 將 hex 轉為 rgb
        let r = parseInt(hex.substr(1,2),16);
        let g = parseInt(hex.substr(3,2),16);
        let b = parseInt(hex.substr(5,2),16);
        let shades = [];
        for(let i=0; i<steps; i++) {
            // 由 1 到 0.4（深）線性插值到 1（原色），再到 1.6（亮）
            let factor = 1 - (i * 0.15); // 1, 0.85, 0.7, 0.55, 0.4
            let nr = Math.round(r * factor + 255 * (1 - factor));
            let ng = Math.round(g * factor + 255 * (1 - factor));
            let nb = Math.round(b * factor + 255 * (1 - factor));
            shades.push(`rgb(${nr},${ng},${nb})`);
        }
        return shades;
    }

    function getMaincategory(MainCategory, subCategory) 
    {
        for (const mainCategory of Object.keys(MainCategory)) {
            if (Object.keys(MainCategory[mainCategory]).includes(subCategory)) {
                return mainCategory;
            }
        }

        return '';
    }

    // 生成所有 varColors 的漸層色陣列
    const varColorShades = varColors.map(color => generateColorShades(color, 5));
    // varColorShades[0] 是 varColors[0] 的五階漸層色，由深到淺

    // 詳細分類數據
    const detailedCategoryData = {};
    const categoryRank = {};
    let datasets = [];
    let categoryDataHistory = [];

    Object.values(spend_rows.category).forEach(category_name => {
        datasets.push({
            label: category_name,
            data: Object.values(spend_rows.record).map(item => Math.abs(item[category_name] || 0)),
            backgroundColor: varColors[datasets.length % varColors.length],
            stack: 'Stack 0'
        });
    });

    Object.keys(dailyCostByCategory).forEach((category_name, row) => {
        detailedCategoryData[category_name] = {
            'labels': Object.keys(dailyCostByCategory[category_name]),
            'datasets': [{
                data: Object.values(dailyCostByCategory[category_name]),
                backgroundColor: varColorShades[row]
            }]
        };
        categoryRank[category_name] = {
            'amounts' : Math.abs(Object.values(dailyCostByCategory[category_name]).reduce((sum, item) => sum + item, 0))
        };
    });

    categoryTotalCosts = Object.values(categoryRank).reduce((sum, item) => sum + item.amounts, 0);
    Object.keys(categoryRank).forEach(categoryName => {
        categoryRank[categoryName].percent = ((categoryRank[categoryName]['amounts'] / categoryTotalCosts) * 100).toFixed(1);
    })

    console.log(dailyCostByCategory)
    console.log(categoryRank);
    // 註冊縮放插件
    Chart.register(ChartZoom);
    
    // 消費趨勢圖表
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');

    const trendChart = new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(spend_rows.record),
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    filter: function(tooltipItem) {
                        return tooltipItem.parsed.y !== 0;
                    },
                    // 自定義 tooltip 的顯示方式
                    callbacks: {
                        title: function(tooltipItems) {
                            console.log(tooltipItems)
                            // 只有當有非零值時才顯示標題
                            const hasNonZero = tooltipItems.some(item => item.parsed.y !== 0);
                            const totalCosts = tooltipItems.reduce((sum, item) => sum + item.parsed.y, 0);
                            return hasNonZero ? tooltipItems[0].label + ': $' + totalCosts.toLocaleString() : '';
                        },
                        label: function(context) {
                            console.log(context)
                            if (context.parsed.y === 0) {
                                return null;
                            }
                            return context.dataset.label + ': $' + context.parsed.y;
                        }
                    }
                },
                title: {
                    display: true,
                    text: '每日收支趨勢 (可縮放和拖拽)',
                    font: {
                        size: 14
                    }
                },
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        scaleMode: 'x'
                    },
                    zoom: {
                        wheel: {
                            enabled: true,
                            speed: 0.1
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x',
                        scaleMode: 'x'
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '金額 (NT$)'
                    }
                }
            },
            // 新增 onClick callback
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    const clickedIndex = elements[0].index;
                    const clickedDate = this.data.labels[clickedIndex];
                    showDayDetail(clickedDate); // 呼叫你自訂的函式
                }
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
        }
    });

    function showDayDetail(date) 
    {
        fetch(`api/api.php`, {
            method: 'POST',
            body: JSON.stringify({action: 'getDailyCostByDate', date: date }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                let detailHtml = `<h5>${date} 的消費明細</h5>`;
                detailHtml += '<ul class="list-group">';
                data.forEach(item => {
                    detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>${item.category} - ${item.description}</span>
                        <span class="badge bg-primary rounded-pill">$${item.amount.toLocaleString()}</span>
                    </li>`;
                });
                detailHtml += '</ul>';
                
                // 顯示在一個模態框或其他地方
                document.getElementById('expenseDetailModalBody').innerHTML = detailHtml;
                $('#expenseDetailModal').modal('show');
            } else {
                alert('沒有該日期的消費記錄。');
            }
        })
        .catch(error => {
            console.error('獲取消費明細時出錯:', error);
            alert('無法獲取消費明細，請稍後再試。');
        }); 
    }

    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(dailyCostByCategory),
            datasets: [{
                data: Object.values(categoryRank).map(item => item.percent),
                backgroundColor: [
                    '#ff9800',
                    '#4caf50',
                    '#e91e63',
                    '#9c27b0',
                    '#607d8b'
                ],
                borderWidth: 2,
                borderColor: '#fff',
                hoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: '支出分類分佈 (點擊查看詳細)',
                    font: {
                        size: 14
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            console.log(context)
                            let percent, labelAmounts, mainCategory;
                            let label = context.label || '';
                            let isMainCategory = (Object.keys(dailyCostByCategory).indexOf(label) !== -1);
                            if (isMainCategory) {
                                labelAmounts = categoryRank[label]['amounts'];
                                percent      = context.formattedValue;
                            } else {
                                mainCategory = getMaincategory(dailyCostByCategory, label);
                                labelAmounts = Math.abs(context.parsed);
                                percent      = (labelAmounts / categoryRank[mainCategory]['amounts'] * 100).toFixed(1);
                            }
                            return `${label}: ${percent}% (${(labelAmounts).toLocaleString()}$)`;
                        }
                    }
                }
            },
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    const clickedIndex = elements[0].index;
                    const clickedLabel = this.data.labels[clickedIndex];
                    
                    if (detailedCategoryData[clickedLabel]) {
                        // 儲存當前狀態
                        categoryDataHistory.push({
                            data: JSON.parse(JSON.stringify(this.data)),
                            title: this.options.plugins.title.text
                        });
                        
                        // 切換到詳細視圖
                        this.data = detailedCategoryData[clickedLabel];
                        this.options.plugins.title.text = clickedLabel + ' - 詳細分項';
                        this.update();
                        
                        // 顯示返回按鈕
                        showCategoryBackButton();
                    }
                }
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
        }
    });

    function showCategoryBackButton() {
        let backBtn = document.getElementById('categoryBackBtn');
        if (!backBtn) {
            backBtn = document.createElement('button');
            backBtn.id = 'categoryBackBtn';
            backBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
            backBtn.innerHTML = '<i class="fas fa-arrow-left"></i> 返回';
            backBtn.onclick = goBackToMainCategory;
            document.querySelector('#categoryChart').parentNode.appendChild(backBtn);
        }
        backBtn.style.display = 'inline-block';
    }

    function goBackToMainCategory() {
        if (categoryDataHistory.length > 0) {
            const previousState = categoryDataHistory.pop();
            categoryChart.data = previousState.data;
            categoryChart.options.plugins.title.text = previousState.title;
            categoryChart.update();
            
            document.getElementById('categoryBackBtn').style.display = 'none';
        }
    }

    // 添加重置縮放按鈕
    const resetZoomBtn = document.createElement('button');
    resetZoomBtn.className = 'btn btn-sm btn-outline-secondary';
    resetZoomBtn.innerHTML = '<i class="fas fa-undo"></i> 重置縮放';
    resetZoomBtn.onclick = () => {
        trendChart.resetZoom();
    };
    document.querySelector('#trendChart').parentNode.appendChild(resetZoomBtn);

    // 篩選功能
    function applyFilters() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const category = document.getElementById('categoryFilter').value;
        
        // 模擬篩選效果
        console.log('篩選條件:', { startDate, endDate, category });
        
        // 這裡可以加入實際的篩選邏輯
        updateCharts(startDate, endDate, category);
        filterExpenseList(category);
    }

    // 篩選功能
    function applyFilters() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const category = document.getElementById('categoryFilter').value;
        
        // 模擬篩選效果
        console.log('篩選條件:', { startDate, endDate, category });
        
        // 這裡可以加入實際的篩選邏輯
        updateCharts(startDate, endDate, category);
        filterExpenseList(category);
    }

    function updateCharts(startDate, endDate, category) {
        // 模擬更新圖表數據
        const newData = generateRandomData();
        trendChart.data.datasets[0].data = newData.trend;
        trendChart.update();
        
        const newCategoryData = generateRandomCategoryData();
        categoryChart.data.datasets[0].data = newCategoryData;
        categoryChart.update();
    }

    function filterExpenseList(category) {
        const expenseItems = document.querySelectorAll('.expense-item');
        expenseItems.forEach(item => {
            if (category === '' || item.classList.contains(category)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function generateRandomData() {
        return {
            trend: Array.from({length: 7}, () => Math.floor(Math.random() * 800) + 100)
        };
    }

    function generateRandomCategoryData() {
        return Array.from({length: 5}, () => Math.floor(Math.random() * 40) + 10);
    }


    // 篩選功能
    function applyFilters() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const category = document.getElementById('categoryFilter').value;
        
        // 模擬篩選效果
        console.log('篩選條件:', { startDate, endDate, category });
        
        // 這裡可以加入實際的篩選邏輯
        updateCharts(startDate, endDate, category);
        filterExpenseList(category);
    }

    function updateCharts(startDate, endDate, category) {
        // 模擬更新圖表數據
        const newData = generateRandomData();
        trendChart.data.datasets[0].data = newData.trend;
        trendChart.data.datasets[1].data = newData.income;
        trendChart.update();
        
        const newCategoryData = generateRandomCategoryData();
        categoryChart.data.datasets[0].data = newCategoryData;
        categoryChart.update();
        
        // 重置縮放
        trendChart.resetZoom();
    }

    function filterExpenseList(category) {
        const expenseItems = document.querySelectorAll('.expense-item');
        expenseItems.forEach(item => {
            if (category === '' || item.classList.contains(category)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function generateRandomData() {
        return {
            trend: Array.from({length: 15}, () => Math.floor(Math.random() * 800) + 100),
            income: Array.from({length: 15}, (_, i) => i % 2 === 0 ? Math.floor(Math.random() * 1000) + 800 : 0)
        };
    }

    function generateRandomCategoryData() {
        return Array.from({length: 5}, () => Math.floor(Math.random() * 40) + 10);
    }

    // 添加動畫效果
    window.addEventListener('load', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });
    });

    // 添加動畫效果
    window.addEventListener('load', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.5s ease';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });
    });

    // 實時更新統計數據
    setInterval(function() {
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach(value => {
            const currentValue = parseInt(value.textContent.replace('$', '').replace(',', ''));
            const newValue = currentValue + Math.floor(Math.random() * 100) - 50;
            value.textContent = '$' + newValue.toLocaleString();
        });
    }, 30000); // 每30秒更新一次


</script>