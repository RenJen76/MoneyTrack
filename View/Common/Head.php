    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="Resource/image/icon/icon.png">
    
    <title>MoneyDetector</title>
    
    <script type="text/javascript" src="bootstrap3.3.7/js/jquery-1.12.4.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script type="text/javascript" src="bootstrap3.3.7/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script type="text/javascript" src="bootstrap3.3.7/js/ie10-viewport-bug-workaround.js"></script>
    
    <!-- Bootstrap core CSS -->
    <link href="bootstrap3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap3.3.7/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script type="text/javascript" src="bootstrap3.3.7/js/ie-emulation-modes-warning.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- <script src="js/clienthint.js"></script> -->
    <script type="text/javascript" src="bootstrap3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="Highcharts5.0.5/js/highcharts.js"></script>
    <script type="text/javascript" src="Highcharts5.0.5/modules/data.js"></script>
    <script type="text/javascript" src="Highcharts5.0.5/modules/drilldown.js"></script>
    <script type="text/javascript" src="Highcharts5.0.5/themes/sand-signika.js"></script>

    <style type="text/css">
        .bg-gold {
            background-color: tan;
            color: white;
        }
    </style>

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