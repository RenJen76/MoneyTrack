 
    <link href="assets/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="assets/select2-4.1.0/select2.min.css" rel="stylesheet" />
    <link href="assets/css/custom_select2.css" rel="stylesheet" />
    <script src="assets/select2-4.1.0/select2.min.js"></script>    
    <script type="text/javascript">
        $(function () {
            const currentDate       = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
            const currentTime       = new Date().toTimeString().split(' ')[0];
            var   is_createCategory = false;

            $("#spendAtDate").val(currentDate)
            $("#spendAtTime").val(currentTime)
        });
    </script>

    <div class="container-fluid min-vh-100 d-flex align-items-left justify-content-left">
        <div class="col-12 col-md-8 col-lg-12 px-0">
            <form class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
                <h2 class="mb-4 text-center fw-bold text-secondary">新增消費紀錄</h2>

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="account" class="form-label fw-bold mb-0 w-100 text-md-end text-start">帳戶名稱</label>
                </div>
                <div class="col-12 col-md-8">
                    <select id="account" class="form-select shadow-sm" name="account">
                        <option selected disabled>請選擇帳戶</option>
                        <?php 
                            foreach ($AccountList as $account) {
                        ?>
                            <!-- <option class="fw-bold" disabled><?php echo $account['categoryName']?></option> -->
                            <?php 
                                // foreach ($category['subcategory'] as $subcategory) { 
                            ?>
                                <option value="<?php echo $account['account_id']?>">
                                    &nbsp;&nbsp;<?php echo $account['account_name']?>
                                </option>
                            <?php 
                                // }
                            ?>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="category" class="form-label fw-bold mb-0 w-100 text-md-end text-start">分類</label>
                </div>
                <div class="col-12 col-md-8">
                    <select id="category" class="form-select shadow-sm" name="Category">
                        <option selected disabled>請選擇分類</option>
                        <?php 
                            foreach ($categoryList as $category) {
                        ?>
                            <option class="fw-bold" disabled><?php echo $category['categoryName']?></option>
                            <?php 
                                foreach ($category['subcategory'] as $subcategory) { 
                            ?>
                                <option value="<?php echo $subcategory['subcategory_id']?>">
                                    &nbsp;&nbsp;<?php echo $subcategory['subcategory_name']?>
                                </option>
                            <?php 
                                }
                            ?>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                
                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="vendor" class="form-label fw-bold mb-0 w-100 text-md-end text-start">店家名稱</label>
                </div>

                <div class="col-12 col-md-8">
                    <select id="vendor_list" class="form-select shadow-sm" name="Vendor" style="width: 100%;">
                        <option value="" selected disabled hidden>請選擇店家</option>
                        <?php foreach ($vendorList as $vendor): ?>
                            <option value="<?php echo htmlspecialchars($vendor['vendor_id']); ?>">
                                <?php echo htmlspecialchars($vendor['vendor_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <script>
                    $(function() {
                        $('#vendor_list').select2({
                            tags: true,
                            placeholder: "請選擇或輸入店家名稱",
                            allowClear: true,
                            width: '100%',
                            createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term,
                                    isNew: true // 標記為新選項
                                };
                            }
                        });
                        $('#vendor_list').on('select2:select', function (e) {
                            var data = e.params.data;
                            console.log(data)
                            if (data.isNew) {
                                is_createCategory = true;
                            } else {
                                is_createCategory = false;
                            }
                        });
                    });
                </script>     

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="cost" class="form-label fw-bold mb-0 w-100 text-md-end text-start">金額</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" pattern="\d*" inputmode="numeric"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        id="cost" name="Cost" class="form-control shadow-sm" placeholder="TWD">
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="description" class="form-label fw-bold mb-0 w-100 text-md-end text-start">消費描述</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" class="form-control shadow-sm" id="description" name="Description" placeholder="消費描述">
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="spendAtDate" class="form-label fw-bold mb-0 w-100 text-md-end text-start">時間</label>
                </div>
                <div class="col-12 col-md-8">
                    <div class="input-group date">
                        <input type="date" id="spendAtDate" name="spendAtDate" class="form-control">
                        <input type="time" id="spendAtTime" name="spendAtTime" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <input type="button" class="btn btn-primary btn-lg w-100 shadow-sm" value="新增消費紀錄" id="submitBtn">
                </div>
            </form>
        </div>
    </div>
    <!-- Toast 通知 -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
        <div id="create-transaction-toast" class="toast align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
            <div class="toast-body">建立成功！</div>
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

    <script>
        $(document).ready(function() {
            $('#submitBtn').click(function() {
                const account           = $('#account').val();
                const category          = $('#category').val();
                const vendor            = $('#vendor_list').val();
                const cost              = $('#cost').val();
                const description       = $('#description').val();
                const spendAtDate       = $('#spendAtDate').val();
                const spendAtTime       = $('#spendAtTime').val();
                let failedToastElement  = document.getElementById('failed-toast');
                let failedToast         = new bootstrap.Toast(failedToastElement);

                if (!account || !category || !vendor || !cost || !spendAtDate || !spendAtTime) {
                    $("#failed-toast>>.toast-body").html(`請填寫所有必填欄位！`)
                    failedToast.show()
                    return;
                }

                $.ajax({
                    url: 'api/api.php?route=createSpend',
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        action: "createSpend",
                        accountId: account,
                        categoryId: category,
                        is_createCategory: is_createCategory,
                        vendorId: vendor,
                        amount: cost,
                        description: description,
                        spendAt: formatDateTime(spendAtDate, spendAtTime)
                    }),
                    success: function(response) {
                        if (response.success === true) {
                            const toastElement  = document.getElementById('create-transaction-toast');
                            const toast         = new bootstrap.Toast(toastElement);
                            toast.show()
                            // window.location.href = 'index.php?route=spendList';
                        } else {
                            $("#failed-toast>>.toast-body").html(`新增失敗：${response.error}`)
                            failedToast.show()
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('新增失敗，請稍後再試。');
                    }
                });

                // 將日期和時間組合成 YYYY-MM-DD HH:mm:ss 格式
                function formatDateTime(date, time) {
                    return date + ' ' + time;
                }
            });
        });
    </script>