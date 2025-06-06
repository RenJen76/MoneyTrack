 
    <link href="assets/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script type="text/javascript">
        $(function () {
            const currentDate = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
            const currentTime = new Date().toTimeString().split(' ')[0];

            $("#spendAtDate").val(currentDate)
            $("#spendAtTime").val(currentTime)
        });
    </script>

    <div class="container-fluid min-vh-100 d-flex align-items-left justify-content-left">
        <div class="col-12 col-md-8 col-lg-12 px-0">
            <form class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg" action="index.php?route=store" method="POST">
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
                        <?php foreach ($vendorList as $vendor): ?>
                            <option value="<?php echo htmlspecialchars($vendor['vendor_name']); ?>">
                                <?php echo htmlspecialchars($vendor['vendor_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>
                    $(function() {
                        $('#vendor_list').select2({
                            tags: true,
                            placeholder: "請選擇或輸入店家名稱",
                            allowClear: true,
                            width: '100%'
                        });
                    });
                </script>      
                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="description" class="form-label fw-bold mb-0 w-100 text-md-end text-start">消費描述</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" class="form-control shadow-sm" id="description" name="Description" placeholder="消費描述">
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="cost" class="form-label fw-bold mb-0 w-100 text-md-end text-start">金額</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" pattern="\d*" inputmode="numeric"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        id="cost" name="Cost" class="form-control shadow-sm" placeholder="TWD">
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="spendAt" class="form-label fw-bold mb-0 w-100 text-md-end text-start">時間</label>
                </div>
                <div class="col-12 col-md-8">
                    <div class="input-group date">
                        <input type="date" id="spendAtDate" name="spendAtDate" class="form-control">
                        <input type="time" id="spendAtTime" name="spendAtTime" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">新增</button>
                </div>
            </form>
        </div>
    </div>