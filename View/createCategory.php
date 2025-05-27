 
    <link href="assets/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script type="text/javascript">
        $(function () {
            $("#submitBtn").click(function() {
                let categoryName = $("#category_name").val();
                if (!categoryName) {
                    alert('請輸入分類名稱');
                    $("#category_name").focus();
                } else {
                    $.ajax({
                        url: './api/api.php',
                        type: 'POST',
                        dataType: 'json',
                        data: JSON.stringify({ 
                            action: 'createCategory',
                            category_name: categoryName,
                            parent_category: $("#parent-category").val()
                        }),
                        success: function(response) {
                            if (response.success) {
                                // alert('分類建立成功');
                                appendChild(); 
                            } else {
                                alert('分類建立失敗: ' + response.error);
                            }
                        },
                        error: function() {
                            alert('伺服器錯誤，請稍後再試。');
                        }
                    });
                }
            });
            function appendChild()
            {
                const name   = document.getElementById('category_name').value.trim();
                const parent = document.getElementById('parent-category').value;

                if (!name) return;

                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = name;

                if (parent) {
                    const subList = document.getElementById("sub"+parent);
                    if (subList) subList.appendChild(li);
                } else {
                    const newId   = 'sub' + Math.random().toString(36).substr(2, 5);
                    const wrapper = document.createElement('li');
                    wrapper.className = 'list-group-item';
                    wrapper.innerHTML = `
                        <span class="category-item" data-target="#${newId}">
                            <span class="toggle-icon rounded">➕</span> ${name}
                        </span>
                        <ul class="list-group subcategories" id="${newId}"></ul>
                    `;
                    document.getElementById('category-list').appendChild(wrapper);

                    // 綁定新點擊事件
                    wrapper.querySelector('.category-item').addEventListener('click', function() {
                        const sub = document.querySelector(this.getAttribute('data-target'));
                        const icon = this.querySelector('.toggle-icon');
                        if (sub.style.display === 'none' || sub.style.display === '') {
                            sub.style.display = 'block';
                            icon.textContent = '➖';
                        } else {
                            sub.style.display = 'none';
                            icon.textContent = '➕';
                        }
                    });

                    // 加到下拉選單中（讓未來可以加子分類）
                    const option = document.createElement('option');
                    option.value = newId;
                    option.textContent = name;
                    document.getElementById('parent-category').appendChild(option);
                }

                // this.reset();
            }
        });
    </script>

    <div class="container-fluid min-vh-100 d-flex align-items-left justify-content-left">
        <!-- -->
        <style>
            .category-item {
            cursor: pointer;
            }
            .subcategories {
            margin-left: 1.5rem;
            display: none;
            }
            .toggle-icon {
            width: 1.5rem;
            display: inline-block;
            }
        </style>
        </head>

        <div class="col-12 col-md-8 col-lg-12 px-0">
            <div class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
                <h2 class="mb-4 text-center fw-bold text-secondary">📂 分類列表</h2>
                <ul class="list-group mb-4" id="category-list">
                    <?php
                        foreach ($categoryList as $category) {
                    ?>
                        <li class="list-group-item rounded">
                            <span class="category-item" data-target="#sub<?php echo $category['categoryId']?>">
                                <span class="toggle-icon">➕</span> <?php echo $category['categoryName']?>
                            </span>
                        </li>

                        <ul class="list-group subcategories collapse" id="sub<?php echo $category['categoryId']?>">
                        
                        <?php
                            foreach ($category['subcategory'] as $subcategory) {
                                echo '<li class="list-group-item rounded">'.$subcategory['subcategory_name'].'</li>';
                            }
                        ?>

                        </ul>
                    <?php
                        }
                    ?>
                </ul>
                <style>
                    .subcategories {
                        margin-left: 2.5rem;
                        transition: max-height 0.3s cubic-bezier(0.4,0,0.2,1);
                        overflow: hidden;
                        max-height: 0;
                        display: block !important;
                        background: #f8f9fa;
                        border-radius: 0 0 0.5rem 0.5rem;
                    }
                    .subcategories.show {
                        max-height: 500px;
                        margin-bottom: 1rem;
                    }
                </style>
                <script>
                    document.querySelectorAll('.category-item').forEach(item => {
                        item.addEventListener('click', function() {
                            const targetId = item.getAttribute('data-target');
                            const sub = document.querySelector(targetId);
                            const icon = item.querySelector('.toggle-icon');
                            if (sub.classList.contains('show')) {
                                sub.classList.remove('show');
                                icon.textContent = '➕';
                            } else {
                                sub.classList.add('show');
                                icon.textContent = '➖';
                            }
                        });
                    });
                </script>      
                
                <h5>➕ 新增分類</h5>
                <div class="col-md-4">
                    <input type="text" id="category_name" class="form-control" placeholder="分類名稱" required>
                </div>
                <div class="col-md-4">
                    <select id="parent-category" class="form-select">
                    <option value="">作為主分類</option>
                    <?php
                        foreach ($categoryList as $category) {
                            echo '<option value="' . $category['categoryId'] . '">' . $category['categoryName'] . '</option>';
                        }
                    ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" id="submitBtn" class="btn btn-primary btn-lg w-100 shadow-sm">建立</button>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.category-item').forEach(item => {
                item.addEventListener('click', () => {
                    const targetId = item.getAttribute('data-target');
                    const sub = document.querySelector(targetId);
                    const icon = item.querySelector('.toggle-icon');

                    if (sub.style.display === 'none' || sub.style.display === '') {
                    sub.style.display = 'block';
                    icon.textContent = '➖';
                    } else {
                    sub.style.display = 'none';
                    icon.textContent = '➕';
                    }
                });
            });            
        </script>
        <!--
        <div class="col-12 col-md-8 col-lg-12 px-0">
            <div class="row g-4 p-4 p-md-5 bg-white shadow-lg rounded-4 mx-1 mx-md-0 border border-2 light-gray-bg">
                <h2 class="mb-4 text-center fw-bold text-secondary">新增上層分類</h2>
                
                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end justify-content-start">
                    <label for="category_name" class="form-label fw-bold mb-0 w-100 text-md-end text-start">分類名稱</label>
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" class="form-control shadow-sm" id="category_name" name="category_name" placeholder="分類名稱">
                </div>


                <div class="col-12">
                    <button type="button" id="submitBtn" class="btn btn-primary btn-lg w-100 shadow-sm">建立</button>
                </div>
            </div>
        </div>
        -->
    </div>