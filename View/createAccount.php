 
    <link href="assets/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script type="text/javascript">
        $(function () {
            $("#submitBtn").click(function() {
                let accountName = $("#account_name").val();
                if (!accountName) {
                    alert('請輸入帳戶名稱');
                    $("#account_name").focus();
                } else {
                    $.ajax({
                        url: './api/api.php',
                        type: 'POST',
                        dataType: 'json',
                        data: JSON.stringify({ 
                            action: 'createAccount',
                            account_name: accountName
                        }),
                        success: function(response) {
                            if (response.success) {
                                const toastElement = document.getElementById('account-toast');
                                const toast = new bootstrap.Toast(toastElement);
                                toast.show();
                                appendAccount(); 
                            } else {
                                alert('帳戶建立失敗: ' + response.error);
                            }
                        },
                        error: function() {
                            alert('伺服器錯誤，請稍後再試。');
                        }
                    });
                }
            });

            function appendAccount()
            {
                const name      = document.getElementById('account_name').value.trim();
                const newId     = 'sub' + Math.random().toString(36).substr(2, 5);
                const wrapper   = document.createElement('li');

                if (!name) return;

                wrapper.className = 'list-group-item';
                wrapper.innerHTML = `
                    <span class="account-item" data-target="#${newId}">
                        <span class="toggle-icon rounded">➕</span> ${name}
                    </span>
                    <ul class="list-group subaccounts" id="${newId}"></ul>
                `;
                document.getElementById('account-list').appendChild(wrapper);
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
        </style>
        </head>

        <div class="col-12 col-md-8 col-lg-12 px-0">
            <div class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
                <h2 class="mb-4 text-center fw-bold text-secondary">💰 帳戶列表</h2>
                <ul class="list-group mb-4" id="account-list">
                    <?php
                        foreach ($AccountList as $account) {
                    ?>
                        <li class="list-group-item rounded">
                            <span class="category-item" data-target="#sub<?php echo $account['account_id']?>">
                                <span class="toggle-icon">➕</span> <?php echo $account['account_name']?>
                            </span>
                        </li>
                    <?php
                        }
                    ?>
                </ul>
                <style>
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
                <script>
                    document.querySelectorAll('.category-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const targetId = item.getAttribute('data-target');
                            const sub = document.querySelector(targetId);
                            const icon = item.querySelector('.toggle-icon');
                            if (sub.classList.contains('show')) {
                                sub.classList.remove('show');
                                icon.textContent = '➕';
                            } else {
                                sub.classList.add('show');
                                icon.textContent = '➖';
                            }
                        });
                    });
                </script>      
                
                <h5>➕ 新增帳戶</h5>
                <div class="col-md-4">
                    <input type="text" id="account_name" class="form-control" placeholder="帳戶名稱" required>
                </div>
                <div class="col-md-4">
                    <button type="button" id="submitBtn" class="btn btn-primary btn-lg w-100 shadow-sm">建立</button>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.category-item').forEach(item => {
                item.addEventListener('click', () => {
                    const targetId = item.getAttribute('data-target');
                    const sub = document.querySelector(targetId);
                    const icon = item.querySelector('.toggle-icon');

                    if (sub.style.display === 'none' || sub.style.display === '') {
                    sub.style.display = 'block';
                    icon.textContent = '➖';
                    } else {
                    sub.style.display = 'none';
                    icon.textContent = '➕';
                    }
                });
            });            
        </script>
        <!-- Toast 通知 -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
            <div id="account-toast" class="toast align-items-center text-white bg-success border-0" role="alert">
                <div class="d-flex">
                <div class="toast-body">
                    ✅ 帳戶已成功建立！
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    </div>