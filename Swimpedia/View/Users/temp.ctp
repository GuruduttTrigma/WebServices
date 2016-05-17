 <?php echo $this->Html->script('highcharts');?>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>

        <div id="graph" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <script type="text/javascript">
            $(function() {
                $('#graph').highcharts({
                    title: {
                        text: 'User Details',
                        x: -20 //center
                    },
                    xAxis: {
                        categories: ['<?php echo $users_date?>']
                    },
                    yAxis: {
                        title: {
                            text: 'Number Of Registered Users'
                        },
                        plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                            name: 'Registered Users',
                            data: [<?php echo $users_reg;?>]
                        }]
                });
            });

        </script>