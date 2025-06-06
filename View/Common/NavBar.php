<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mt-2 mb-5" style="background-color:rgb(80, 161, 246); border-radius: 1rem;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php?route=index">
            <i class="bi bi-cash-stack me-2"></i>MoneyTracker
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link<?php if(isset($_GET['route']) && $_GET['route']=='index'){echo ' active';} ?>" href="index.php?route=index">
                        <i class="bi bi-house-door me-1"></i>首頁
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if(isset($_GET['route']) && $_GET['route']=='report'){echo ' active';} ?>" href="index.php?route=report">
                        <i class="bi bi-bar-chart-line me-1"></i>報表
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#myModal">
                        <i class="bi bi-graph-up-arrow me-1"></i>分析
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle<?php if(isset($_GET['route']) && ($_GET['route']=='create' || $_GET['route']=='import')){echo ' active';} ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-circle me-1"></i>建立
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="index.php?route=create"><i class="bi bi-plus-square me-1"></i>新增一筆消費</a></li>
                        <li><a class="dropdown-item" href="index.php?route=createVendor"><i class="bi bi-shop me-1"></i>建立店家</a></li>
                        <li><a class="dropdown-item" href="index.php?route=createCategory"><i class="bi bi-tags me-1"></i>建立分類</a></li>
                        <li><a class="dropdown-item" href="index.php?route=createAccount"><i class="bi bi-wallet2 me-1"></i>建立帳戶</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?route=import"><i class="bi bi-upload me-1"></i>匯入檔案</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

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