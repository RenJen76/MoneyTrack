<link href="bootstrap3.3.7/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script src="bootstrap3.3.7/js/bootstrap-datetimepicker.js"></script>
<!-- <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="Most Spend"> -->

<form class="form-signin" action="index.php?route=reportResult" method="post">
    <div class="form-group well">
        <h2 class="text-center">Spend on Which Days ?</h2>       
        <div align="center">
            <div class="input-group date form_date well" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd"></div>
            <input type="hidden" id="dtp_input2" name="reportDate" value="<?php echo date('Y-m-d')?>">
            <button class="btn btn-lg btn-primary" type="submit">Search</button>
        </div>
    </div>
</form>
<form class="form-signin" action="index.php?route=reportResult" method="post">
    <div class="form-group well">
        <h2 class="text-center">Spend on Which Month ?</h2>
        <div align="center">
            <div class="input-group date form_month well" data-date="" data-date-format="MM yyyy" data-link-field="dtp_input3" data-link-format="yyyy-mm"></div>
            <input type="hidden" id="dtp_input3" name="reportMonth" value="<?php echo date('Y-m')?>">
            <button class="btn btn-lg btn-primary" type="submit">Search</button>
        </div>
    </div>
    <div class="text-center">
        <a href="index.php?route=index" class="text-muted">
            <b>see all spend</b>
        </a>
    </div>
</form>

<script type="text/javascript">
    $('.form_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_month').datetimepicker({
        autoclose: 1,
        startView: 3,
        minView: 3,
        forceParse: 0
    });
</script>