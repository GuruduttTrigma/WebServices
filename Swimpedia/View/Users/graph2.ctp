<?php

//    foreach($csvs as $key => $csv){
//        $dates[] = "'".$csv['csves']['data']."'";
//        $values[] = $csv[0]['graphs'];                
//    }
//    $dates = implode(',',$dates);
//    $values = implode(',',$values);
foreach($date as $d){
    $dates[] = "'".$d."'";
}
foreach($noof as $n){
    $cs[] = $n;
}
   $dates = implode(",",$dates);
   $value = implode(",",$cs);
    ?>
<?php if((!empty($dates)&&(!empty($value)))){ ?>
<div class="widget chartWrapper"  style="padding: 1em;max-height:90%;width: 98%;">
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript">
 $(function () {
        $('#container1').highcharts({
            title: {
                text: '  Unique customers contacted',
                x: -20 //center
            },
            subtitle: {
                text: 'Source:  Unique customers contacted',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $dates; ?>]
            },
            yAxis: {
                title: {
                    text: 'customers contacted'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'customers contacted'
            },
            legend: {
//                layout: 'vertical',
//                align: 'right',
//                verticalAlign: 'middle',
//                borderWidth: 0
                 enabled:false
            },
            credits:{enabled:false},
            series: [{                
                data: [<?php echo $value;?>]
            }
        ]
        });
    });
</script>

        

             <div class="chart" style="height:98%; min-width:98%;">
                <div id="jqChart">
                    <div id="container1" style="max-height:100%; min-width:98%;"></div>                    
                </div>
            </div>

    </div>
 <?php }else{ ?>
        <br/>
       <center> <h3> There is no data for graph. </h3>   </center>
     <?php    } ?> 
