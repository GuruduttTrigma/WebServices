<?php echo $this->Html->script('jquery.jqChart.min');?>


    <?php
//    echo $this->element('admin_header');
//    echo $this->element('admin_sidebar');

    foreach($csvs as $csv){
//        @$dates[] = "'".$csv['date']."'";
        @$abc = $csv['calls'] / $csv['sales'];
        @$values[] = $abc;                
    }
    foreach($date as $d){
    $dates[] = "'".$d."'";
}
    $dates = implode(',',$dates);
    $value = implode(',',$values);
    //debug($value);exit;
//    foreach($date as $d){
//    $dates[] = "'".$d."'";
//}
//foreach($noof as $n){
//    $cs[] = $n;
//}
//   $dates = implode(",",$dates);
//   $value = implode(",",$cs);
    ?>
        <script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<?php if((!empty($dates)&&(!empty($value)))){ ?>
    <div class="widget chartWrapper"  style="padding: 1em;max-height:90%;width: 98%;">
        <?php $x=$this->Session->flash(); ?>
    <?php if($x){ ?>
    <div class="nNote nSuccess" id="flash">
        <div class="" style="text-align:center" > <?php echo $x; ?></div>
    </div>
    <?php } ?>

                <div id="jqChart"  style="height:98%; min-width:98%;">>
                    <div id="container" style="max-height:100%; min-width:98%;"></div> 
                </div>

    </div>     

<script type="text/javascript">
  $(function () {
        $('#container').highcharts({
            title: {
                text: ' Call to Sale ',
                x: -20 //center
            },
            subtitle: {
                text: 'Source:  Call to Sale ',
                x: -20
            },
            xAxis: {
                categories: [<?php echo $dates; ?>]
            },
            yAxis: {
                title: {
                    text: 'Call to Sale'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'Call to Sale'
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
 <?php }else{ ?>
        <br/>
       <center> <h3> There is no data for graph. </h3>   </center>
     <?php    } ?> 