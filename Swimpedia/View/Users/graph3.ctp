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
//foreach($date as $d){
//    $dates[] = "'".$d."'";
//}
//foreach($csvs as $n){
//    $cs[] = $n;
//}
//foreach($csves as $m){
//    $cse[] = $m;
//}
//   $dates = implode(",",$dates);
//   $values = implode(",",$cs);
//   $val =  implode(",",$cse);
    ?>
<?php echo $this->Html->script('jquery.jqChart.min');?>
<!--<link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tab.js"></script>-->
        <script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<?php if((!empty($csvs)&&(!empty($csves)))){ ?>
           <div class="widget chartWrapper"  style="padding: 1em;">
<script type="text/javascript">
  $(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '  Call numbers by disposition'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
            credits:{enabled:false},
        series: [{
            type: 'pie',
            name: '  Call numbers by disposition',
            data: [
                ['DD Sign Up',<?php echo $csvs; ?>],
                ['CC Sign Up',<?php echo $csves; ?>],
            ]
        }]
    });
});
</script>

          <div class="chart" style="height: 500px; min-width: 500px">
                <div id="jqChart">
                    <div id="container1" style="height: 500px; min-width: 500px"></div>                      
                </div>
            </div>


    </div>
         
   <?php }else{ ?>
        <br/>
       <center> <h3> There is no data for graph. </h3>   </center>
     <?php    } ?> 