 
    <link href="Resource/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script type="text/javascript" src="Resource/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="Resource/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker2').datetimepicker();
        });
    </script>

    <form class="form-horizontal form-group-lg well" action="index.php?route=store" method="POST">
        <div class="form-group">
            <div class="col-sm-4">
                <p class="lead">Vendor</p>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="Vendor" placeholder="Vendor">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <p class="lead">Description</p>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="Description" placeholder="Description">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <p class="lead">Amount</p>
            </div>
            <div class="col-sm-8">
                <input onkeyup="value=value.replace(/[^\d]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"
                id="inputEmail3" name="Cost" class="form-control" placeholder="TWD">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <p class="lead">Category</p>
            </div>
            <div id="Cate1" class="col-sm-8">
                <select id="test" class="form-control" placeholder="select a type" name="Category">
                    <option class="hidden">Select a Category</option>
                    <?php 
                        foreach ($categoryList as $category) {
                    ?>

                            <option class="bg-gold" disabled><?php echo $category['categoryName']?></option>

                        <?php 
                            foreach ($category['subcategory'] as $subcategory) { 
                        ?>
                                <option value="<?php echo $subcategory['subcategory_id']?>">
                                    <?php echo $subcategory['subcategory_name']?>
                                </option>
                        <?php 
                            }
                        ?>

                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <p class="lead">Spend At</p>
            </div>
            <div class="col-sm-8">
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' id="spendAt" name="spendAt" class="form-control">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="button" class="btn btn-lg btn-primary btn-block" value="Create">
        </div>
    </form>