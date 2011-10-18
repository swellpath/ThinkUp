
 <div class="">
  <div class="help-container">{insert name="help_link" id=$display}</div>
  {if $description}<i>{$description}</i>{/if}
</div>
    {if $error}
    <p class="error">
        {$error}
    </p>
    {/if}


<div id="external_referrer_history_by_day"></div>
<div id="external_referrer_history_by_week"></div>
<div id="external_referrer_history_by_month"></div>

<script>
var external_referrer_history_by_day_data = {$external_referrer_history_by_day};
var external_referrer_history_by_week_data = {$external_referrer_history_by_week};
var external_referrer_history_by_month_data = {$external_referrer_history_by_month};

{literal}
var line1 = new pvc.LineChart({
          canvas: "external_referrer_history_by_day",
          width: 600,
          height: 250,
          animate:false,
          title: "External Referrer Count By Day",
          titleSize: 40,
          legend: true,
          legendPosition: "top",
          legendAlign: "right",

          orientation: 'vertical',
          timeSeries: true,
          timeSeriesFormat: "%Y-%m-%d",

          showValues: false,
          showDots: true,
          yAxisPosition: "right",
          yAxisSize: 30,
          extensionPoints: {
            noDataMessage_text: "No data",
            xAxisScale_dateTickFormat: "%m/%d",
            xAxisScale_dateTickPrecision: 798336000/10
                      //set in miliseconds
          }
        });
        line1.setData(external_referrer_history_by_day_data,
             {crosstabMode: false,
              seriesInRows: false});
        line1.render();

var line2 = new pvc.LineChart({
          canvas: "external_referrer_history_by_week",
          width: 600,
          height: 250,
          animate:false,
          title: "External Referrer Count By Week",
          titleSize: 40,
          legend: true,
          legendPosition: "top",
          legendAlign: "right",

          orientation: 'vertical',
          timeSeries: true,
          timeSeriesFormat: "%Y-%m-%d",

          showValues: false,
          showDots: true,
          yAxisPosition: "right",
          yAxisSize: 30,
          extensionPoints: {
            noDataMessage_text: "No data",
            xAxisScale_dateTickFormat: "%m/%d",
            xAxisScale_dateTickPrecision: 798336000/1.5
                      //set in miliseconds
          }
        });
        line2.setData(external_referrer_history_by_week_data,
             {crosstabMode: false,
              seriesInRows: false});
        line2.render();

var line3 = new pvc.LineChart({
          canvas: "external_referrer_history_by_month",
          width: 600,
          height: 350,
          animate:true,
          title: "External Referrer Count By Month",
          titleSize: 40,
          showTooltips: true,
          legend: true,
          legendPosition: "top",
          legendAlign: "right",

          orientation: 'vertical',
          timeSeries: true,
          timeSeriesFormat: "%Y-%m-%d",

          showValues: false,
          showDots: true,
          yAxisPosition: "right",
          yAxisSize: 30,
          extensionPoints: {
            noDataMessage_text: "No data",
//            xAxisScale_dateTickFormat: "%Y/%m/%d",
            xAxisScale_dateTickPrecision: 798336000/.3
                      //set in miliseconds
          }
        });
        line3.setData(external_referrer_history_by_month_data,
             {crosstabMode: false,
              seriesInRows: false});
        line3.render();
{/literal}
</script>
