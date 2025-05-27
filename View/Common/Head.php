    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="Resource/image/icon/icon.png">
    
    <title>MoneyDetector</title>
    
    <script type="text/javascript" src="assets/jQuery-3.7.1/jQuery-3.7.1.js"></script>
    <link href="assets/bootstrap-5.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="assets/bootstrap-5.3.6/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="assets/Highcharts5.0.5/js/highcharts.js"></script>
    <script type="text/javascript" src="assets/Highcharts5.0.5/modules/data.js"></script>
    <script type="text/javascript" src="assets/Highcharts5.0.5/modules/drilldown.js"></script>
    <script type="text/javascript" src="assets/Highcharts5.0.5/themes/sand-signika.js"></script>  
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="assets/css/custom.css" rel="stylesheet">
    <script type="text/javascript">
        $(function(){
            let analysisBtn;
            $("#analysisBtn").click(function(){
                let vendor = $("#vendor").val();
                if (!vendor) {
                    alert('請輸入店家名稱');
                    $("#vendor").focus();
                } else {
                    $("#analysisForm").submit();
                }
            })
        })
    </script>