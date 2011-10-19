
 <div class="">
  <div class="help-container">{insert name="help_link" id=$display}</div>
  {if $description}<i>{$description}</i>{/if}
</div>
    {if $error}
    <p class="error">
        {$error}
    </p>
    {/if}

<h2>{if $follower_count_history_by_day.trend}({if $follower_count_history_by_day.trend > 0}<span style="color:green">+{else}<span style="color:red">{/if}{$follower_count_history_by_day.trend|number_format}</span>/day){/if}</h2>
<div id="follower_count_history_by_day"></div>

{if $follower_count_history_by_day.milestone}
    <br /><small style="color:gray">NEXT MILESTONE: <span style="background-color:#FFFF80;color:black">{$follower_count_history_by_day.milestone.will_take} day{if $follower_count_history_by_day.milestone.will_take > 1}s{/if}</span> till you reach <span style="background-color:#FFFF80;color:black">{$follower_count_history_by_day.milestone.next_milestone|number_format} followers</span> at this rate.</small>
{/if}

<h2>{if $follower_count_history_by_week.trend != 0}({if $follower_count_history_by_week.trend > 0}<span style="color:green">+{else}<span style="color:red">{/if}{$follower_count_history_by_week.trend|number_format}</span>/week){/if}</h2>

<div id="follower_count_history_by_week"></div>
    {if $follower_count_history_by_week.milestone}
<br /><small style="color:gray">NEXT MILESTONE: <span style="background-color:#FFFF80;color:black">{$follower_count_history_by_week.milestone.will_take} week{if $follower_count_history_by_week.milestone.will_take > 1}s{/if}</span> till you reach <span style="background-color:#FFFF80;color:black">{$follower_count_history_by_week.milestone.next_milestone|number_format} followers</span> at this rate.</small>
{/if}

<h2>{if $follower_count_history_by_month.trend != 0}({if $follower_count_history_by_month.trend > 0}<span style="color:green">+{else}<span style="color:red">{/if}{$follower_count_history_by_month.trend|number_format}</span>/month){/if}</h2>

<div id="follower_count_history_by_month"></div>
{if $follower_count_history_by_month.milestone}
    <br /><small style="color:gray">NEXT MILESTONE: <span style="background-color:#FFFF80;color:black">{$follower_count_history_by_month.milestone.will_take} month{if $follower_count_history_by_month.milestone.will_take > 1}s{/if}</span> till you reach <span style="background-color:#FFFF80;color:black">{$follower_count_history_by_month.milestone.next_milestone|number_format} followers</span> at this rate.</small>
{/if}

<script>
var follower_count_history_by_day_data = {$follower_count_history_by_day.ccc_data};
var follower_count_history_by_week_data = {$follower_count_history_by_week.ccc_data};
var follower_count_history_by_month_data = {$follower_count_history_by_month.ccc_data};

{literal}
var line1 = new pvc.LineChart({
    canvas: "follower_count_history_by_day",
    width: 600,
    height: 250,
    animate:true,
    title: "Follower Count By Day",
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
line1.setData(follower_count_history_by_day_data, {
    crosstabMode: false,
    seriesInRows: false});
line1.render();

var line2 = new pvc.LineChart({
    canvas: "follower_count_history_by_week",
    width: 600,
    height: 250,
    animate:true,
    title: "Follower Count By Week",
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
line2.setData(follower_count_history_by_week_data, {
    crosstabMode: false,
    seriesInRows: false});
line2.render();

var line3 = new pvc.LineChart({
    canvas: "follower_count_history_by_month",
    width: 600,
    height: 250,
    animate:true,
    title: "Follower Count By Month",
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
line3.setData(follower_count_history_by_month_data, {
    crosstabMode: false,
    seriesInRows: false});
line3.render();
{/literal}
</script>
