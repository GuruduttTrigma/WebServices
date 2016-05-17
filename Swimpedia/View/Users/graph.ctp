<?php $x=$this->Session->flash(); ?>
    <?php if($x){ ?>
    <div class="nNote nSuccess" id="flash">
        <div class="" style="text-align:center" > <?php echo $x; ?></div>
    </div>
    <?php } ?>
<?php

//    foreach($csvs as $key => $csv){    
//                 $values[] = $csv[0]['graphs'];  
//
//
//    }
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
<div class="widget chartWrapper" style="padding: 1em;max-height:90%;width: 98%;">
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript">
 $(function () {
   //$(".chartWrapper").css({"width":screen.width,"height":screen.height});
  //$(".chart").css({"width":screen.width,"height":screen.height});
    // alert(screen.width);
    // alert(screen.height);
        $('#container1').highcharts({
            title: {
                text: ' Call Numbers',
                x: -20 //center
            },
            subtitle: {
                text: 'Source:  Call Numbers',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $dates; ?>]
            },
            yAxis: {
                title: {
                    text: 'Numbers of Calls'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'Numbers of Calls'
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
                data: [<?php echo $value; ?>]
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
