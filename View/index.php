    <script type="text/javascript">    
        var seriesJson      = JSON.parse('<?php echo json_encode($totalSpend[dataJson])?>');
        var seriseDetail    = JSON.parse('<?php echo json_encode($totalSpend[cateDetail])?>');
        var seriesData      = Object.values(seriesJson);
        $(function () {
            // Create the chart
            Highcharts.chart('mychart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 1000 +" $"
                },
                subtitle: {
                    text: 'From January 2016 to December 2016'
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y:.1f}%'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style= "color:{point.color} "> {point.name} </span>: <b> {point.y:.1f} </b><br/>'
                },
                series: [{
                    name        : 'username',
                    colorByPoint: true,
                    data        : seriesData
                }],
                drilldown: {
                    series: seriseDetail
                }
            });
        });
    </script>
    <div> 
        <h1 class="sub-header">Total Spend</h1>
        <div id="mychart" align="center" class="well"></div>
    </div>

    <div class="sub-header" id="Most Spend">
        <div>
            <h2 class="sub-header">Most Spend
                <br>
                <small class="text-danger">
                    <?php echo $mostCostDay['dayAmount'] ?> $
                </small>
                <small class="text-muted">on <?php echo $mostCostDay['spend_at']?></small>
            </h2>
            <div class="table-responsive well">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Spend At</th>
                            <th>Category</th>
                            <th>Payee</th>
                            <th>Description</th>
                            <th>Spent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($mostCostTrans as $TransData) {
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
        </div>

        <h2 class="sub-header">Vendor Cost Rank</h2>

        <div class="table-responsive">
            <table class="table table-striped well">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Payee</th>
                        <th>Count</th>
                        <th>Spent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($costVendorRank as $index => $VendorRank) {
                    ?>
                        <tr>
                            <td><?php echo $index+1?></td>
                            <td><?php echo $VendorRank['vendor_name']?></td>
                            <td><?php echo $VendorRank['count_num']?></td>
                            <td><?php echo $VendorRank['amount']?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>