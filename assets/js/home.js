document.addEventListener('DOMContentLoaded', function() {
    const expenseList = document.getElementById('expenseList');
    
    // 點擊編輯按鈕
    expenseList.addEventListener('click', function(e) {
        if (e.target.classList.contains('fa-pen-to-square')) {
            const expenseItem = e.target.closest('.expense-item');
            const currentRow = expenseItem.querySelector('.row');
            const originalContent = currentRow.innerHTML; // 儲存原始內容
            
            // 儲存原始數據到DOM元素
            console.log(expenseItem.dataset)
            expenseItem.dataset.originalContent = originalContent;
            
            // 建立編輯表單
            const editForm = createEditForm(expenseItem);
            currentRow.innerHTML = editForm;
        }
    });

    // 處理儲存和取消按鈕
    expenseList.addEventListener('click', async function(e) {
        const expenseItem = e.target.closest('.expense-item');
        if (!expenseItem) return;

        // 取消編輯
        if (e.target.classList.contains('cancel-btn') || e.target.closest('.cancel-btn')) {
            const row = expenseItem.querySelector('.row');
            row.innerHTML = expenseItem.dataset.originalContent;
        }

        // 儲存變更
        if (e.target.classList.contains('save-btn') || e.target.closest('.save-btn')) {
            const formData = {
                trans_id: expenseItem.dataset.trans_no,
                action: 'updateSpend',
                description: expenseItem.querySelector('[name="description"]').value,
                // vendor: expenseItem.querySelector('[name="vendor"]').value,
                amount: parseFloat(expenseItem.querySelector('[name="amount"]').value),
                spend_at: expenseItem.querySelector('[name="spend_at"]').value,
                account_id: expenseItem.querySelector('[name="account"]').value,
                category_id: expenseItem.querySelector('[name="category"]').value
            };

            try {
                const response = await fetch('api/api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                if (result.success) {
                    location.reload(); // 重新載入頁面以顯示更新後的數據
                } else {
                    alert('儲存失敗: ' + result.message);
                }
            } catch (err) {
                console.error('儲存時發生錯誤:', err);
                alert('儲存時發生錯誤，請稍後再試');
            }
        }
    });

    // 建立編輯表單的HTML
    function createEditForm(item) {
        return `
            <div class="col-md-1">
                <i class="fas ${item.querySelector('.fas').className.split(' ').slice(1).join(' ')}"></i>
            </div>
            
            <div class="col-md-2">
                <select name="account" class="form-select form-control-sm mb-2">
                    ${generateAccountOptions(item.dataset.account_id)}
                </select>
                <select name="category" class="form-select form-control-sm">
                    ${generateCategoryOptions(item.dataset.subcategory_id)}
                </select>
            </div>

            <div class="col-md-7">
                <div class="d-flex align-items-center mb-2">
                    <input type="text" class="form-control w-50 me-1" name="description" value="${getDescription(item)}">
                    (${item.dataset.vendor})
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="datetime-local" class="form-control form-control-sm" name="spend_at"  value="${item.dataset.date}">
                    </div>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="d-flex align-items-center gap-2">
                    <input type="number" class="form-control form-control-sm" name="amount" value="${item.dataset.amount}">
                    <i class="fas fa-check save-btn"></i>
                    <i class="fas fa-times cancel-btn"></i>
                </div>
            </div>
        `;
    }

    // 取得描述文字（去除商家名稱）
    function getDescription(item) {
        const descEl = item.querySelector('h6.mb-1 span');
        const desc = descEl.textContent;
        const vendor = item.dataset.vendor;
        return desc.replace(`(${vendor})`, '').trim();
    }

    // 產生帳戶選項
    function generateAccountOptions(accountId = null) {
        accountDOM = '';
        accountList.forEach((elements) => {
            selected     = accountId && elements.account_id == accountId ? 'selected' : '';
            accountDOM  += `<option value="${elements.account_id}" ${selected}>${elements.account_name}</option>`;
        })
        return accountDOM;
    }

    // 產生分類選項
    function generateCategoryOptions(subcategoryId = null) 
    {

        categoryDOM = '';

        categorys.forEach((elements) => {
            if (elements.subcategory.length > 0 ) {
                categoryDOM += `<optgroup label="${elements.categoryName}">`;
                elements.subcategory.forEach((subElements) => {
                    selected     = subcategoryId && subElements.subcategory_id == subcategoryId ? 'selected' : '';
                    categoryDOM += `<option value="${subElements.subcategory_id}" ${selected}>${subElements.subcategory_name}</option>`;
                });
                categoryDOM += `</optgroup>`;
            }
        })

        return categoryDOM;
    }

    // 產生店家列表
    function generateVendorOptions(vendorId = null) 
    {

        categoryDOM = '';

        categorys.forEach((elements) => {
            if (elements.subcategory.length > 0 ) {
                categoryDOM += `<optgroup label="${elements.categoryName}">`;
                elements.subcategory.forEach((subElements) => {
                    selected     = vendorId && subElements.subcategory_id == vendorId ? 'selected' : '';
                    categoryDOM += `<option value="${subElements.subcategory_id}" ${selected}>${subElements.subcategory_name}</option>`;
                });
                categoryDOM += `</optgroup>`;
            }
        })

        return categoryDOM;
    }

});

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

const varColorShades = varColors.map(color => generateColorShades(color, 5));

// 詳細分類數據
const detailedCategoryData = {};
const categoryRank = {};
// 每日消費資料
let datasets = [];
let categoryDataHistory = [];

$(function(){
    
    // 消費趨勢圖表
    const trendCtx      = document.getElementById('trendChart').getContext('2d');
    const categoryCtx   = document.getElementById('categoryChart').getContext('2d');

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

    // console.log(dailyCostByCategory)
    // console.log(categoryRank);
    // 註冊縮放插件
    Chart.register(ChartZoom);
    const trendChart    = new Chart(trendCtx, {
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
                            // console.log(tooltipItems)
                            // 只有當有非零值時才顯示標題
                            const hasNonZero = tooltipItems.some(item => item.parsed.y !== 0);
                            const totalCosts = tooltipItems.reduce((sum, item) => sum + item.parsed.y, 0);
                            return hasNonZero ? tooltipItems[0].label + ': $' + totalCosts.toLocaleString() : '';
                        },
                        label: function(context) {
                            // console.log(context)
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

    // 添加重置縮放按鈕
    const resetZoomBtn = document.createElement('button');
    resetZoomBtn.className = 'btn btn-sm btn-outline-secondary';
    resetZoomBtn.innerHTML = '<i class="fas fa-undo"></i> 重置縮放';
    resetZoomBtn.onclick = () => {
        trendChart.resetZoom();
    };
    document.querySelector('#trendChart').parentNode.appendChild(resetZoomBtn);
})



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
    .then(dailyRecords => {
        let dailyAmount = 0;
        if (dailyRecords && dailyRecords.data.length > 0) {
            let detailHtml = '<ul class="list-group">';
            dailyRecords.data.forEach(item => {
                amountsColor = item.amount > 0 ? 'bg-success' : 'bg-danger'; 
                dailyAmount  = dailyAmount + item.amount;
                detailHtml  += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info">${item.account_name}</span>
                            <span class="fw-semibold">${item.vendor_name} - ${item.description}</span>
                        </div>
                        <div>
                            <span class="text-muted fs-6">${item.spend_at}</span>
                        </div>
                    </div>
                    <div class="ms-3 align-self-center">
                        <span class="badge ${amountsColor} rounded-pill">$${item.amount.toLocaleString()}</span>
                    </div>
                </li>`;
            });
            detailHtml += '</ul>';
            document.getElementById('expenseDetailModalBody').innerHTML = detailHtml;
            document.getElementById('exampleModalLabel').innerHTML= `
                <span class="fs-5 text-muted d-inline-flex align-items-center">${date} 消費明細 
                    <span class="badge badge-sm bg-success rounded-pill ms-2 badge-eq bg-opacity-50">$${dailyAmount.toLocaleString()}</span>
                </span>
            `;
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

// 篩選功能
function applyFilters() {
    const startDate = document.getElementById('startDate').value;
    const endDate   = document.getElementById('endDate').value;
    const category  = document.getElementById('categoryFilter').value;
    
    // 模擬篩選效果
    console.log('篩選條件:', { startDate, endDate, category });
    
    // 這裡可以加入實際的篩選邏輯
    updateCharts(startDate, endDate, category);
    filterExpenseList(category);
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

function generateRandomCategoryData() {
    return Array.from({length: 5}, () => Math.floor(Math.random() * 40) + 10);
}

function updateCharts(startDate, endDate) {
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

function generateRandomData() {
    return {
        trend: Array.from({length: 15}, () => Math.floor(Math.random() * 800) + 100),
        income: Array.from({length: 15}, (_, i) => i % 2 === 0 ? Math.floor(Math.random() * 1000) + 800 : 0)
    };
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

// 實時更新統計數據
setInterval(function() {
    const statValues = document.querySelectorAll('.stat-value');
    statValues.forEach(value => {
        const currentValue = parseInt(value.textContent.replace('$', '').replace(',', ''));
        const newValue = currentValue + Math.floor(Math.random() * 100) - 50;
        value.textContent = '$' + newValue.toLocaleString();
    });
}, 30000); // 每30秒更新一次

$(function(){
    const listEl = document.getElementById('expenseList');
    const sortSelect = document.getElementById('sortSelect');
    const searchInput = document.getElementById('expenseSearch');
    const clearBtn = document.getElementById('clearSearch');
    const countInfo = document.getElementById('countInfo');

    function getItems() {
        return Array.from(listEl.querySelectorAll('.expense-item'));
    }

    function sortItems(mode) {
        const items = getItems();
        items.sort((a,b) => {
            if (mode === 'amount_desc') {
                return parseFloat(b.dataset.amount) - parseFloat(a.dataset.amount);
            }
            if (mode === 'amount_asc') {
                return parseFloat(a.dataset.amount) - parseFloat(b.dataset.amount);
            }
            if (mode === 'date_desc') {
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            }
            if (mode === 'date_asc') {
                return new Date(a.dataset.date) - new Date(b.dataset.date);
            }
            return 0;
        });
        const fragment = document.createDocumentFragment();
        items.forEach(it => fragment.appendChild(it));
        listEl.appendChild(fragment);
    }

    // sortSelect.addEventListener('change', e => sortItems(e.target.value));
    document.getElementById('sortAmountDesc').addEventListener('click', () => {sortItems('amount_desc'); });
    document.getElementById('sortAmountAsc').addEventListener('click', () => {sortItems('amount_asc'); });
    document.getElementById('sortDateDesc').addEventListener('click', () => {sortItems('date_desc'); });
    document.getElementById('sortDateAsc').addEventListener('click', () => {sortItems('date_asc'); });

    function updateCount() {
        const visible = getItems().filter(i => i.style.display !== 'none').length;
        countInfo.textContent = `顯示 ${visible} 筆，總共 ${getItems().length} 筆`;
    }

    function applySearch() {
        const q = searchInput.value.trim().toLowerCase();
        getItems().forEach(item => {
            const text = (item.textContent || '').toLowerCase();
            item.style.display = q === '' ? 'block' : (text.indexOf(q) !== -1 ? 'block' : 'none');
        });
        // updateCount();
    }

    searchInput.addEventListener('input', applySearch);
    clearBtn.addEventListener('click', () => { searchInput.value=''; applySearch(); });

    // 初始排序（由大到小）
    // sortItems(sortSelect.value);
    // updateCount();
});