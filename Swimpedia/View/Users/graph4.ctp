<?php echo $this->Html->script('jquery.jqChart.min');?>
<?php $x=$this->Session->flash(); ?>
    <?php if($x){ ?>
    <div class="nNote nSuccess" id="flash">
        <div class="" style="text-align:center" > <?php echo $x; ?></div>
    </div>
    <?php } ?>
        <script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
 <?php
    //echo $this->element('admin_header');
   // echo $this->element('admin_sidebar');
    //debug($csvs);
//    foreach($csvs as $key => $csv){
//        @$dates[] = "'".$csv['date']."'";
//        @$values[] = $csv[0]['graphs'];   
//        @$abc = $csv['calls'] / $csv['sales'];
//        @$calls[] = $abc;
//    }
//    $dates = implode(',',$dates);
//    $values = implode(',',$values);
//    $calls = implode(',',$calls);
//    debug($dates);
//    debug($values);
//    debug($calls);exit;
    ?>
    <div class="widget chartWrapper"  style="padding: 1em;">  
                        <div class="well">
                    <p><b>Valid Start Date :</b><?php echo date('d-m-Y',strtotime($validstartdate['Csfe']['Date'])); ?></p>
                     <p><b>Valid End Date :</b><?php echo date('d-m-Y',strtotime($validenddate['Csfe']['Date'])); ?></p>
                </div>
<?php if($csvs){ ?>
                <div id="jqChart">
                    <div id="container"></div> 
                </div>
<?php } ?>
    </div>     

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
                ['DD Sign Up',<?php echo $first; ?>],
                ['CC Sign Up',<?php echo $second; ?>],
                ['Declined Lottery',<?php echo $third; ?>],
                ['No Answer',<?php echo $fourth; ?>],
            ]
        }]
    });
});
</script>