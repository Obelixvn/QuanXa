<!DOCTYPE html>
<html>
<head>


<script type="text/javascript" src="fusioncharts.js"></script>


</head>
<body>
<?php
/**
* This example describes the X-Y chart preparation using FusionCharts PHP wrapper
*/
// Including the wrapper file in the page
include("fusioncharts.php");
// Preparing the object of FusionCharts with needed informations
    /**
    * The parameters of the constructor are as follows
    * chartType   {String}  The type of chart that you intend to plot. e.g. Column3D, Column2D, Pie2D etc.
    * chartId     {String}  Id for the chart, using which it will be recognized in the HTML page. Each chart on the page should have a unique Id.
    * chartWidth  {String}  Intended width for the chart (in pixels). e.g. 400
    * chartHeight {String}  Intended height for the chart (in pixels). e.g. 300
    * containerId {String}  The id of the chart container. e.g. chart-1
    * dataFormat  {String}  Type of data used to render the chart. e.g. json, jsonurl, xml, xmlurl
    * dataSource  {String}  Actual data for the chart. e.g. {"chart":{},"data":[{"label":"Jan","value":"420000"}]}
    */
    
    // Create the chart - Pie 3D Chart with data given in constructor parameter 
    // Syntax for the constructor - new FusionCharts("type of chart", "unique chart id", "width of chart", "height of chart", "div id to render the chart", "type of data", "actual data")
    $mscombi2dChart = new FusionCharts("mscombi2d", "ex3", "100%", 400, "chart-1", "json", '{
        "chart": {
            "caption": "Actual Revenues, Targeted Revenues & Profits",
            "subcaption": "Last year",
            "xaxisname": "Month",
            "yaxisname": "Amount (In USD)",
            "numberprefix": "$",
            "theme": "ocean"
        },
        "categories": [
            {
                "category": [
                    {
                        "label": "Jan"
                    },
                    {
                        "label": "Feb"
                    },
                    {
                        "label": "Mar"
                    },
                    {
                        "label": "Apr"
                    },
                    {
                        "label": "May"
                    },
                    {
                        "label": "Jun"
                    },
                    {
                        "label": "Jul"
                    },
                    {
                        "label": "Aug"
                    },
                    {
                        "label": "Sep"
                    },
                    {
                        "label": "Oct"
                    },
                    {
                        "label": "Nov"
                    },
                    {
                        "label": "Dec"
                    }
                ]
            }
        ],
        "dataset": [
            {
                "seriesname": "Actual Revenue",
                "data": [
                    {
                        "value": "16000"
                    },
                    {
                        "value": "20000"
                    },
                    {
                        "value": "18000"
                    },
                    {
                        "value": "19000"
                    },
                    {
                        "value": "15000"
                    },
                    {
                        "value": "21000"
                    },
                    {
                        "value": "16000"
                    },
                    {
                        "value": "20000"
                    },
                    {
                        "value": "17000"
                    },
                    {
                        "value": "25000"
                    },
                    {
                        "value": "19000"
                    },
                    {
                        "value": "23000"
                    }
                ]
            },
            {
                "seriesname": "Projected Revenue",
                "renderas": "line",
                "showvalues": "0",
                "data": [
                    {
                        "value": "15000"
                    },
                    {
                        "value": "16000"
                    },
                    {
                        "value": "17000"
                    },
                    {
                        "value": "18000"
                    },
                    {
                        "value": "19000"
                    },
                    {
                        "value": "19000"
                    },
                    {
                        "value": "19000"
                    },
                    {
                        "value": "19000"
                    },
                    {
                        "value": "20000"
                    },
                    {
                        "value": "21000"
                    },
                    {
                        "value": "22000"
                    },
                    {
                        "value": "23000"
                    }
                ]
            },
            {
                "seriesname": "Profit",
                "renderas": "area",
                "showvalues": "0",
                "data": [
                    {
                        "value": "4000"
                    },
                    {
                        "value": "5000"
                    },
                    {
                        "value": "3000"
                    },
                    {
                        "value": "4000"
                    },
                    {
                        "value": "1000"
                    },
                    {
                        "value": "7000"
                    },
                    {
                        "value": "1000"
                    },
                    {
                        "value": "4000"
                    },
                    {
                        "value": "1000"
                    },
                    {
                        "value": "8000"
                    },
                    {
                        "value": "2000"
                    },
                    {
                        "value": "7000"
                    }
                ]
            }
        ]
    }');
    // Render the chart
    $mscombi2dChart->render();
    
    
    
?>
<div id="chart-1"><!-- Fusion Charts will render here--></div>
 
</body>
</html>