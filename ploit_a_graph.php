<!DOCTYPE html>
<html>
<head>



<script type="text/javascript" src="fusioncharts.js"></script>
<script type="text/javascript" src="fusioncharts.theme.ocean.js"></script>
</head>
<body>
<?php
// This is a simple example on how to draw a chart using FusionCharts and PHP.
// We have included includes/fusioncharts.php, which contains functions
// to help us easily embed the charts.
include("fusioncharts.php");
// Create the chart - Column 2D Chart with data given in constructor parameter 
// Syntax for the constructor - new FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "type of data", "actual data")
$columnChart = new FusionCharts("column2d", "ex1", "100%", 400, "chart-1", "json", '{  
                "chart":{  
                  "caption":"Harry\'s SuperMart",
                  "subCaption":"Top 5 stores in last month by revenue",
                  "numberPrefix":"$",
                  "theme":"ocean"
                },
                "data":[  
                  {  
                     "label":"Bakersfield Central",
                     "value":"880000"
                  },
                  {  
                     "label":"Garden Groove harbour",
                     "value":"730000"
                  },
                  {  
                     "label":"Los Angeles Topanga",
                     "value":"590000"
                  },
                  {  
                     "label":"Compton-Rancho Dom",
                     "value":"520000"
                  },
                  {  
                     "label":"Daly City Serramonte",
                     "value":"330000"
                  }
                ]
            }');
// Render the chart
$columnChart->render();
?>

<div id="chart-1"><!-- Fusion Charts will render here--></div>
 
 
</body>
</html>