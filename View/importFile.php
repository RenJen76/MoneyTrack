    <script type="text/javascript">
        $(function(){
            $("#importBtn").click(function(){
                document.importForm.submit()
            })
        })
    </script>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
                <form name="importForm" method="POST" enctype="multipart/form-data">
                    <h3 class="row mb-3">檔案匯入</h3>
                    
                    <div class="row mb-3">
                        <label for="uploadFile" class="form-label">選擇檔案</label>
                        <input type="file" class="form-control" name="uploadFile" id="uploadFile">
                    </div>

                    <div class="row mb-3">
                        <input type="button" id="importBtn" class="btn btn-primary" value="匯入">
                    </div>
                </form>
            </div>
        </div>
    <?php
        if (isset($import)) {
    ?>
        <div class="mt-5">
            <?php
                if (count($import) === 0) {
            ?>
            <h3 class="text-danger text-center">無資料匯入</h3>
            <?php
                } else {
            ?>
            <h3 class="text-success text-center">以下資料已匯入</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>分類</th>
                            <th>子分類</th>
                            <th>店家名稱</th>
                            <th>描述</th>
                            <th>金額</th>
                            <th>時間</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($import as $record) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['subcategory_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['vendor_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['description']); ?></td>
                            <td><?php echo htmlspecialchars($record['amount']); ?></td>
                            <td><?php echo htmlspecialchars($record['spend_at']); ?></td>
                        </tr>
                    <?php
                        }
                    ?>  
                    </tbody> 
                </table>
            </div>
            <?php
                }
            ?>
        </div>
    <?php
        }
    ?>
    </div>