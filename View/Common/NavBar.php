<div class="header clearfix">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#toggleHeader" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php?route=index">MoneyTracker</a>
        </div>
        <div class="collapse navbar-collapse" id="toggleHeader">
            <ul class="nav navbar-nav">
                <li class="<?php if($_GET['route']=='report'){echo 'active';}?>">
                    <a href="index.php?route=report">報表</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#myModal">分析</a>
                </li>
                <li class="<?php if($_GET['route']=='create'){echo 'active';}?>">
                    
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        建立<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="index.php?route=create">新增一筆消費</a>
                        </li>
                        <li>
                            <a href="index.php?route=create">建立店家</a>
                        </li>
                        <li>
                            <a href="index.php?route=create">建立分類</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="index.php?route=import">匯入檔案</a>
                        </li>
                        <!-- 
                        <li><a href="#">Something else here</a></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                        -->
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>  
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <b>Analysis Vendor</b>
                </h4>
            </div>
            <div class="modal-body">
                <form id="analysisForm" method="POST" action="index.php?route=analysisVendor">
                <div>
                    <input type="text" class="form-control" id="vendor" name="vendor" placeholder="vendor">
                    <h6 class="text-muted">Suggestions: 
                        <span id="NewStringBox"></span>
                    </h6>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" class="btn btn-primary" id="analysisBtn" value="Submit">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li class="active"><a href="#">All <span class="sr-only">(current)</span></a></li>
        <li><a href="#Most Spend">Reports</a></li>
        <li><a href="#">Export</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li><a href="">Nav item</a></li>
        <li><a href="">Nav item again</a></li>
        <li><a href="">One more nav</a></li>
        <li><a href="">Another nav item</a></li>
        <li><a href="">More navigation</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li><a href="">Nav item again</a></li>
        <li><a href="">One more nav</a></li>
        <li><a href="">Another nav item</a></li>
    </ul>
</div>
-->