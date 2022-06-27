    <script type="text/javascript">
        $(function(){
            $("#importBtn").click(function(){
                document.importForm.submit()
            })
        })
    </script>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 well">
            <form name="importForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <h3>檔案匯入</h3>
                    </div>
                    <div class="form-group">
                        <label for="uploadFile">選擇檔案</label>
                        <div>
                            <input type="file" name="uploadFile">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="button" id="importBtn" class="btn btn-md btn-primary" value="匯入">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-2"></div>
    </div>