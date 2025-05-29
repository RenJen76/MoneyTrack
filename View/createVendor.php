 
    <link href="assets/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script type="text/javascript">
        $(function () {
            $("#submitBtn").click(function() {
                let vendorName = $("#vendor_name").val();
                if (!vendorName) {
                    alert('請輸入店家名稱');
                    $("#vendor_name").focus();
                } else {
                    $.ajax({
                        url: './api/api.php',
                        type: 'POST',
                        dataType: 'json',
                        data: JSON.stringify({ 
                            action: 'createVendor',
                            vendor_name: vendorName
                        }),
                        success: function(response) {
                            if (response.success) {
                                const toastElement  = document.getElementById('category-toast');
                                const toast         = new bootstrap.Toast(toastElement);
                                toast.show()
                                appendChild(); 
                            } else {
                                const toastElement  = document.getElementById('failed-toast');
                                const failedToast   = new bootstrap.Toast(toastElement);
                                $("#failed-toast>>.toast-body").html(`建立店家失敗: ${response.error}`)
                                failedToast.show()
                            }
                        },
                        error: function() {
                            alert('伺服器錯誤，請稍後再試。');
                        }
                    });
                }
            });
            function appendChild()
            {
                const name      = document.getElementById('vendor_name').value.trim();
                const li        = document.createElement('li');
                const newId     = 'sub' + Math.random().toString(36).substr(2, 5);
                const wrapper   = document.createElement('li');

                if (!name) return;

                li.className    = 'list-group-item';
                li.textContent  = name;

                wrapper.className = 'list-group-item';
                wrapper.innerHTML = `
                    <span class="category-item" data-target="#${newId}">
                        <span class="toggle-icon rounded">➕</span> ${name}
                    </span>
                    <ul class="list-group subcategories" id="${newId}"></ul>
                `;              
                document.getElementById('category-list').appendChild(wrapper);
            }
        });
    </script>

    <div class="container-fluid min-vh-100 d-flex align-items-left justify-content-left">
        <!-- -->
        <style>
            .category-item {
                cursor: pointer;
            }
            .subcategories {
                margin-left: 1.5rem;
                display: none;
            }
            .toggle-icon {
                width: 1.5rem;
                display: inline-block;
            }
            .subcategories {
                margin-left: 2.5rem;
                transition: max-height 0.3s cubic-bezier(0.4,0,0.2,1);
                overflow: hidden;
                max-height: 0;
                display: block !important;
                background: #f8f9fa;
                border-radius: 0 0 0.5rem 0.5rem;
            }
            .subcategories.show {
                max-height: 500px;
                margin-bottom: 1rem;
            }
        </style>

        <div class="col-12 col-md-8 col-lg-12 px-0">
            <div class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
                <h2 class="mb-4 text-center fw-bold text-secondary">📂 店家列表</h2>
                <ul class="list-group mb-4" id="category-list">
                    <?php
                        foreach ($vendorList as $vendor) {
                    ?>
                        <li class="list-group-item rounded">
                            <span class="category-item" data-target="#sub<?php echo $vendor['vendor_id']?>">
                                <span class="toggle-icon">➕</span> <?php echo $vendor['vendor_name']?>
                            </span>
                        </li>

                        <ul class="list-group subcategories collapse" id="sub<?php echo $vendor['vendor_id']?>">
                        
                        </ul>
                    <?php
                        }
                    ?>
                </ul>
                <h5>➕ 新增店家</h5>
                <div class="col-md-6">
                    <input type="text" id="vendor_name" class="form-control" placeholder="店家名稱" required>
                </div>
                <div class="col-md-6">
                    <button type="button" id="submitBtn" class="btn btn-primary btn-lg w-100 shadow-sm">建立</button>
                </div>
            </div>
        </div>
        <!-- Toast 通知 -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
            <div id="category-toast" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                <div class="toast-body">
                    ✅ 店家已成功建立！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
            <div id="failed-toast" class="toast align-items-center text-white bg-danger border-0" role="alert">
                <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    </div>