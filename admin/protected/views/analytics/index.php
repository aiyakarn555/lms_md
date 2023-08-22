<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php

// Load the Google API PHP Client Library.
require_once __DIR__ . '/../../extensions/google-api-php-client/vendor/autoload.php';
$path_theme = Yii::app()->theme->baseUrl."/assets";
$clientScript = Yii::app()->clientScript;
  $clientScript->registerCssFile($path_theme.'/css/AdminLTE.css');
        $clientScript->registerCssFile('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
//var_dump($path_theme.'/css/AdminLTE.css');exit();
//require_once $path_theme.'/css/AdminLTE.css';

$analytics = initializeAnalytics();
$session7Day = getReport($analytics,'ga:sessions','7daysago','today');
$session1Day = getReport($analytics,'ga:sessions',date('Y-m-d'),'today');
$visitors7Day = getReport($analytics,'ga:users','7daysago','today');
$Pageviews7Day = getReport($analytics,'ga:pageviews','7daysago','today');
$sessionsPerUser = getReport($analytics,'ga:sessionsPerUser','7daysago','today');
$newUsers = getReport($analytics,'ga:newUsers','7daysago','today');
$test2 = getReport($analytics, 'ga:sessionsPerUser','7daysago','today');
// var_dump(date("F Y",strtotime("- 1 month")));exits();
$lm_first_date = date('Y-m-d',strtotime("first day of ".date("F Y")));
$lm_last_date = date('Y-m-d',strtotime("last day of ".date("F Y")));
$month_name = date("F Y");
$lastmonth = getReport($analytics,'ga:users',$lm_first_date,$lm_last_date);

// var_dump($lm_first_date);
// echo '<br>';
// var_dump($lm_last_date);
// echo '<br>';
// var_dump(printResultsNumber($lastmonth));
// echo '<hr>';
// echo '<hr>';

$lm2_first_date = date('Y-m-d',strtotime("first day of ".date("F Y",strtotime("- 1 month"))));
$lm2_last_date = date('Y-m-d',strtotime("last day of ".date("F Y",strtotime("- 1 month"))));
$lastmonth2 = getReport($analytics,'ga:users',$lm2_first_date,$lm2_last_date);
$month_name2 = date("F Y",strtotime("- 1 month"));

$lm3_first_date = date('Y-m-d',strtotime("first day of ".date("F Y",strtotime("- 2 month"))));
$lm3_last_date = date('Y-m-d',strtotime("last day of ".date("F Y",strtotime("- 2 month"))));
$lastmonth3 = getReport($analytics,'ga:users',$lm3_first_date,$lm3_last_date);
$month_name3 = date("F Y",strtotime("- 2 month"));

$lm4_first_date = date('Y-m-d',strtotime("first day of ".date("F Y",strtotime("- 3 month"))));
$lm4_last_date = date('Y-m-d',strtotime("last day of ".date("F Y",strtotime("- 3 month"))));
$lastmonth4 = getReport($analytics,'ga:users',$lm4_first_date,$lm4_last_date);
$month_name4 = date("F Y",strtotime("- 3 month"));


/**
 * Initializes an Analytics Reporting API V4 service object.
 *
 * @return An authorized Analytics Reporting API V4 service object.
 */
function initializeAnalytics()
{

  // Use the developers console and download your service account
  // credentials in JSON format. Place them in this directory or
  // change the key file location if necessary.
  $KEY_FILE_LOCATION = __DIR__ . '/../../vendors/client_secrets.json';

  // Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("Hello Analytics Reporting");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  
  $analytics = new Google_Service_AnalyticsReporting($client);

  return $analytics;
}


/**
 * Queries the Analytics Reporting API V4.
 *
 * @param service An authorized Analytics Reporting API V4 service object.
 * @return The Analytics Reporting API V4 response.
 */
function getReport($analytics,$expression=null,$dateStart=null,$endDate=null,$alias=null) {

  // Replace with your view ID, for example XXXX.
  // $VIEW_ID = "219498559";
  $VIEW_ID = "224206542";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($dateStart);
  $dateRange->setEndDate($endDate);
  // $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression($expression);
  $sessions->setAlias(null);

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}


/**
 * Parses and prints the Analytics Reporting API V4 response.
 *
 * @param An Analytics Reporting API V4 response.
 */
function printResults($reports) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[ $rowIndex ];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
      for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
        print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
      }

      for ($j = 0; $j < count($metrics); $j++) {
        $values = $metrics[$j]->getValues();
        for ($k = 0; $k < count($values); $k++) {
          $entry = $metricHeaders[$k];
          //print($entry->getName() . ": " . $values[$k] . "\n");
          print($values[$k] . "\n");
        }
      }
    }
  }
}

function printResultsNumber($reports) {
  $val = 0;
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[ $rowIndex ];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
      for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
        print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
      }

      for ($j = 0; $j < count($metrics); $j++) {
        $values = $metrics[$j]->getValues();
        for ($k = 0; $k < count($values); $k++) {
          $entry = $metricHeaders[$k];
          //print($entry->getName() . ": " . $values[$k] . "\n");
          $val += $values[$k];
        }
      }
    }
  }
  return $val;
}

$titleName = 'Dashboard';
//$this->headerText = $titleName;
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;

?>
<style type="text/css">
  .box {
    background: #ecf0f5;
    border-top: 0;
}
  .well {
    background-color: #f5f5f5;
    border: 0;
    border-radius: 0;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    border: 1px solid #fff;
}
.bg-mute{
  background-color: #eee;
}
</style>
<!-- <section class="content" style="background: url(<?= Yii::app()->baseUrl; ?>/themes/AdminLMS/base_assets//images/bg-admin.png) no-repeat center center;background-size: cover;min-height: 768px;"> -->
<section class="content">

  <div class="page-content">

    <div class="site-index">
      <div class="body-content">

        <div class="row">
         <!-- <div class="col-lg-2 col-xs-6"> -->
            <!-- small box -->
            <!-- <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?= printResults($session1Day); ?></h3>

                <p>Sessions Present</p>
              </div>
              <div class="icon">
                <i class="ion ion-eye"></i>
              </div>
            </div>
          </div> -->

            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?= printResults($session1Day); ?></h3>

                <p>Sessions Present</p>
              </div>
              <div class="icon">
                <i style="font-size: 63px;" class="fa fa-line-chart"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?= printResults($session7Day); ?></h3>

                <p>Sessions 7 Days</p>
              </div>
              <div class="icon">
                <i class="ion ion-eye"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3><?= printResults($visitors7Day); ?></h3>

                <p>Visitors 7 Days</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <!-- <div class="col-lg-3 col-xs-6"> -->
            <!-- small box -->
            <!-- <div class="small-box bg-yellow">
              <div class="inner">
                <h3><?= printResults($Pageviews7Day); ?></h3>

                <p>Pageviews 7 Days</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div> -->
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3><?= number_format(printResultsNumber($sessionsPerUser),2); ?></h3>

                <p>Days Since Last Session</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row hidden">
          <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div>Sessions 7 Days</div>
                  <!-- <div class="huge" id="totalSessions"><?= printResults($test2); ?></div> -->
                <div class="huge" id="totalSessions"><?= printResults($session7Day); ?></div>
                <input type="hidden" id="sessionsUser" value="<?= printResults($session7Day); ?>">
              </div>
            </div>
          </div>                            
          <div class="col-sm-6 col-lg-3">
            <div class="panel panel-green">
              <div class="panel-heading">
                <div>Visitors 7 Days</div>
                <div class="huge" id="totalUsers"><?= printResults($visitors7Day); ?></div>
              </div>
            </div>
          </div>                            
          <div class="col-sm-6 col-lg-3">
            <div class="panel panel-yellow">
              <div class="panel-heading">
                <div>Pageviews 7 Days</div>
                <div class="huge" id="totalPageViews"><?= printResults($Pageviews7Day); ?></div>
              </div>
            </div>
          </div>                            
          <div class="col-sm-6 col-lg-3">
            <div class="panel panel-red">
              <div class="panel-heading">
                <div>Days Since Last Session</div>
                <div class="huge" id="averageSessionLength"><?= number_format(printResultsNumber($sessionsPerUser),2); ?></div>
                
               
              </div>
            </div>
          </div>                        
        </div>

        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <div class="well">
                  <div id="chart_div" style="height: 300PX; width: 100%;"></div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="well">
                <table class="table" style="border: 0;">
                      <tbody>
                        <tr>
                          <td class="bg-info"><b>New visitor</b></td>
                          <td class="bg-mute text-center"><?= printResults($session7Day); ?></td>
                        </tr>
                        <tr>
                          <td class="bg-info"><b>Returning visitor</b></td>
                          <td class="bg-mute text-center"><?=printResults($newUsers); ?></td>
                        </tr>
                        <tr>
                          <td class="bg-info"><b>Pageviews</b></td>
                          <td class="bg-mute text-center"><?= printResults($Pageviews7Day); ?></td>
                        </tr>
                        <tr>
                          <td class="bg-info"><b>Days Since Last Session</b></td>
                          <td class="bg-mute text-center"><?= number_format(printResultsNumber($sessionsPerUser),2); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-4">
            <div class="well">
              <div class="row">
                <div class="col-md-12">
                  <div id="piechart" style="height: 100%;"></div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th colspan="2" class="text-center">*ต้องการเช็ค Google Analytics โดยละเอียด</th>
                      </tr>
                    </thead>
                    <tbody>
                              <tr>
                        <td class="bg-mute">E-mail</td>
                        <td>thoresen.elearning@gmail.com</td>
                      </tr>
<!--                      <tr>
                        <td class="bg-mute">Password</td>
                        <td>lms@2020</td>
                      </tr>-->
                     <!--  <tr>
                        <td class="bg-mute">E-mail</td>
                        <td>thorcdpt@gmail.com</td>
                      </tr> -->
<!--                      <tr>
                        <td class="bg-mute">Password</td>
                        <td>thoresendigital</td>
                      </tr>-->
                      <tr>
                        <td class="bg-mute">ไปที่</td>
                        <td><a href="https://www.google.com/analytics/" class="btn btn-primary" target = "_blank">Google Analytics</a>  </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>

      </div>

  </section>

    <input type="hidden" id="newUser" value="<?=printResults($newUsers); ?>">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);


      function drawChart() {
        var sessionsPerUser = document.getElementById('sessionsUser').value;
        var newUsers = document.getElementById('newUser').value;

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['New visitor',       parseFloat(sessionsPerUser)],
          ['Returning visitor',     parseFloat(newUsers)],
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, {title:"Visitors",
                  height:400,
                  vAxis: {title: "Year"},
                  hAxis: {title: "Cups"},
                  backgroundColor: "transparent"});
      };
      google.charts.load('current2', {'packages2':['corechart2']});
      google.charts.setOnLoadCallback(drawChart2);

      function drawChart2() {

        var data = google.visualization.arrayToDataTable([
          ['Month', 'Visited'],
          ["<?=$month_name4?>",  <?=printResultsNumber($lastmonth4)?>],
          ["<?=$month_name3?>",  <?=printResultsNumber($lastmonth3)?>],
          ["<?=$month_name2?>",  <?=printResultsNumber($lastmonth2)?>],
          ["<?=$month_name?>",  <?=printResultsNumber($lastmonth)?>]
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, {title:"Visitors",
                  vAxis: {title: "Value"},
                  hAxis: {title: "Month"},
                  backgroundColor: "transparent"});
      }
    </script>

   <?php
          /* ['Month', 'Visited'],
           [<?=$month_name4?>,  <?=$lastmonth4?>],
           [<?=$month_name3?>,  <?=$lastmonth3?>],
           [<?=$month_name2?>,  <?=$lastmonth2?>],
           [<?=$month_name?>,  <?=$lastmonth?>]*/
   ?>