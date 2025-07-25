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
                <div class="stat-value">$8,230</div>
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
                <select id="categoryFilter" class="form-select">
                    <option value="">全部分類</option>
                    <option value="food">餐飲</option>
                    <option value="transport">交通</option>
                    <option value="entertainment">娛樂</option>
                    <option value="shopping">購物</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">&nbsp;</label>
                <button class="btn btn-dark d-block w-100 btn-lg" onclick="applyFilters()">
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
                <div class="card-body">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // 註冊縮放插件
    Chart.register(ChartZoom);
    
    // 消費趨勢圖表
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');

    const trendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['1/1', '1/2', '1/3', '1/4', '1/5', '1/6', '1/7', '1/8', '1/9', '1/10', '1/11', '1/12', '1/13', '1/14', '1/15'],
            datasets: [{
                label: '支出',
                data: [200, 450, 300, 600, 280, 520, 380, 420, 650, 300, 480, 560, 320, 400, 580],
                borderColor: '#ff6b6b',
                backgroundColor: 'rgba(255, 107, 107, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 8
            }, {
                label: '收入',
                data: [800, 0, 1200, 0, 900, 0, 1100, 0, 1500, 0, 950, 0, 1300, 0, 1000],
                borderColor: '#4ecdc4',
                backgroundColor: 'rgba(78, 205, 196, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 8
            }]
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
            }
        }
    });

    // const categoryChart = new Chart(categoryCtx, {
    //     type: 'pie',
    //     data: {
    //         labels: ['1/1', '1/2', '1/3', '1/4', '1/5', '1/6', '1/7', '1/8', '1/9', '1/10', '1/11', '1/12', '1/13', '1/14', '1/15'],
    //         datasets: [{
    //             label: '支出',
    //             data: [200, 450, 300, 600, 280, 520, 380, 420, 650, 300, 480, 560, 320, 400, 580],
    //             borderColor: '#ff6b6b',
    //             backgroundColor: 'rgba(255, 107, 107, 0.1)',
    //             tension: 0.4,
    //             fill: true,
    //             pointRadius: 4,
    //             pointHoverRadius: 8
    //         }, {
    //             label: '收入',
    //             data: [800, 0, 1200, 0, 900, 0, 1100, 0, 1500, 0, 950, 0, 1300, 0, 1000],
    //             borderColor: '#4ecdc4',
    //             backgroundColor: 'rgba(78, 205, 196, 0.1)',
    //             tension: 0.4,
    //             fill: true,
    //             pointRadius: 4,
    //             pointHoverRadius: 8
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         interaction: {
    //             intersect: false,
    //             mode: 'index'
    //         },
    //         plugins: {
    //             legend: {
    //                 position: 'top',
    //             },
    //             title: {
    //                 display: true,
    //                 text: '每日收支趨勢 (可縮放和拖拽)',
    //                 font: {
    //                     size: 14
    //                 }
    //             },
    //             zoom: {
    //                 pan: {
    //                     enabled: true,
    //                     mode: 'x',
    //                     scaleMode: 'x'
    //                 },
    //                 zoom: {
    //                     wheel: {
    //                         enabled: true,
    //                         speed: 0.1
    //                     },
    //                     pinch: {
    //                         enabled: true
    //                     },
    //                     mode: 'x',
    //                     scaleMode: 'x'
    //                 }
    //             }
    //         },
    //         scales: {
    //             x: {
    //                 title: {
    //                     display: true,
    //                     text: '日期'
    //                 }
    //             },
    //             y: {
    //                 beginAtZero: true,
    //                 title: {
    //                     display: true,
    //                     text: '金額 (NT$)'
    //                 }
    //             }
    //         }
    //     }
    // });

    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['餐飲', '交通', '娛樂', '購物', '其他'],
            datasets: [{
                data: [35, 15, 25, 20, 5],
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
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${percentage}% (${(value * 100).toLocaleString()})`;
                        }
                    }
                }
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
        }
    });

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