
    <h1 class="text-center"><?php echo $title;?></h1>

    <?php 
        if(count($transList)>0){
    ?>

    <div class="table-responsive">
        <table class="table table-striped well">    
            <thead>
                <tr>
                    <th>SpendTime</th>
                    <th>Category</th>
                    <th>Payee</th>
                    <th>Description</th>
                    <th>Spend</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($transList as $TransData) {
                ?>
                <tr>
                    <td><?php echo $TransData['spend_at']?></td>
                    <td><?php echo $TransData['category_name'] . " > " . $TransData['subcategory_name']?></td>
                    <td><?php echo $TransData['vendor_name']?></td>
                    <td><?php echo $TransData['description']?></td>
                    <td><?php echo $TransData['amount']?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <?php 
        } else {
    ?>
        <div align="center">
            <h3 class="text-danger">No Result...</h3>
        </div>
    <?php
        }
    ?>