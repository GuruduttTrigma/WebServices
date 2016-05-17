<?php $x=$this->Session->flash(); ?>
    <?php if($x){ ?>
    <div class="nNote nSuccess" id="flash">
        <div class="" style="text-align:center" > <?php echo $x; ?></div>
    </div>
    <?php } ?>
<?php
//        foreach($csvs as $key => $csv){
//        @$dates[] = "'".$csv['csves']['data']."'";
//        @$values[] = $csv[0]['graphs'];  
//        
//    }
//    foreach($csves as $key => $csv){
//        @$val[] = $csv[0]['graph'];  
//        
//    }
//    $dates = implode(',',$dates);
//    $values = implode(',',$values);
//     $val = implode(',',$val);
foreach($date as $d){
    $dates[] = "'".$d."'";
}
foreach($csvs as $n){
    $cs[] = $n;
}
foreach($csves as $m){
    $cse[] = $m;
}
   $dates = implode(",",$dates);
   $values = implode(",",$cs);
   $val =  implode(",",$cse);
    ?>
<?php echo $this->Html->script('jquery.jqChart.min');?>
<!--<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tab.js"></script>-->
        <script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>

           <div class="widget chartWrapper"  style="padding: 1em;">
<script type="text/javascript">
 $(function () {
        $('#container1').highcharts({
            title: {
                text: 'Customer Payment type',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: Customer Payment type',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $dates; ?>]
            },
            yAxis: {
                title: {
                    text: 'Customer Payment type'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'Customer Payment type'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },            
            credits:{enabled:false},        
            series: [{  
                name: 'DD',
                data: [<?php echo $values;?>]
            },{
                 name: 'CC',
                 data: [<?php echo $val;?>]
            }
        ]
        });
    });
</script>

          <div class="chart" style="height: 500px; min-width: 500px">
                <div id="jqChart">
                    <div id="container1" style="height: 500px; min-width: 500px"></div>                      
                </div>
            </div>


    </div>
         
  