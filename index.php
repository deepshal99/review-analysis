
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">
<?php require 'vendor/autoload.php'; // include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->review_db->vivo_textAnalysis;
$cursor = $collection->find();

// Naviye Baies Classification


$pos_vivo=0;
$neg_vivo=0;
$neu_vivo=0;
$total_vivo=0;
foreach($cursor as $document)
{       //echo $document["TextAnalysis"]["score_tag"]."\n";
 	$total_vivo+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "N") == 0)
	$neg_vivo+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "P") == 0)
	$pos_vivo+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "NONE") == 0)
	$neu_vivo+=1;

}

?>
<?php 
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->review_db->samsung_textAnalysis;
$cursor = $collection->find();

// Naviye Baies Classification


$pos_samsung=0;
$neg_samsung=0;
$neu_samsung=0;
$total_samsung=0;
foreach($cursor as $document)
{       //echo $document["TextAnalysis"]["score_tag"]."\n";
 	$total_samsung+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "N") == 0)
	$neg_samsung+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "P") == 0)
	$pos_samsung+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "NONE") == 0)
	$neu_samsung+=1;

}
//echo $neu;
//echo $pos;
//echo $neg;
//echo $total;
?>
<?php 

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->review_db->redmi_textAnalysis;
$cursor = $collection->find();

// Naviye Baies Classification


$pos_redmi=0;
$neg_redmi=0;
$neu_redmi=0;
$total_redmi=0;
foreach($cursor as $document)
{       //echo $document["TextAnalysis"]["score_tag"]."\n";
 	$total_redmi+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "N") == 0)
	$neg_redmi+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "P") == 0)
	$pos_redmi+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "NONE") == 0)
	$neu_redmi+=1;

}
//echo $neu;
//echo $pos;
//echo $neg;
//echo $total;
?>
<?php 

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->review_db->oppo_textAnalysis;
$cursor = $collection->find();

// Naviye Baies Classification


$pos_oppo=0;
$neg_oppo=0;
$neu_oppo=0;
$total_oppo=0;
foreach($cursor as $document)
{       //echo $document["TextAnalysis"]["score_tag"]."\n";
 	$total_oppo+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "N") == 0)
	$neg_oppo+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "P") == 0)
	$pos_oppo+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "NONE") == 0)
	$neu_oppo+=1;

}
//echo $neu;
//echo $pos;
//echo $neg;
//echo $total;
?>
<?php require 'vendor/autoload.php'; // include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->review_db->iphone_textAnalysis;
$cursor = $collection->find();

// Naviye Baies Classification


$pos_iphone=0;
$neg_iphone=0;
$neu_iphone=0;
$total_iphone=0;
foreach($cursor as $document)
{       //echo $document["TextAnalysis"]["score_tag"]."\n";
 	$total_iphone+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "N") == 0)
	$neg_iphone+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "P") == 0)
	$pos_iphone+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "NONE") == 0)
	$neu_iphone+=1;

}
//echo $neu;
//echo $pos;
//echo $neg;
//echo $total;
?>
  
  
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "COMBINED REVIEW"
	},	
	axisY: {
		title: "TOTAL",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY3: {
		title: "NEGATIVE",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},
	axisY2: {
		title: "POSITIVE",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},
	
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "TOTAL",
		legendText: "TOTAL",
		showInLegend: true, 
		dataPoints:[
			{ label: "vivo", y: <?php echo $total_vivo;?> },
			{ label: "samsung", y:<?php echo $total_samsung;?> },
			{ label: "redmi", y: <?php echo $total_redmi;?>},
			{ label: "oppo", y: <?php echo $total_oppo;?> },
			{ label: "iphone", y: <?php echo $total_iphone;?>},
			
		]
	},
         {
		type: "column",
		name: "NEGATIVE",
		legendText: "NEGATIVE",
		showInLegend: true, 
		dataPoints:[
			{ label: "vivo", y: <?php echo $neg_vivo;?> },
			{ label: "samsung", y:<?php echo $neg_samsung;?> },
			{ label: "redmi", y: <?php echo $neg_redmi;?>},
			{ label: "oppo", y: <?php echo $neg_oppo;?> },
			{ label: "iphone", y: <?php echo $neg_iphone;?>},
			
		]
	},

	{
		type: "column",	
		name: "POSITIVE",
		legendText: "POSITIVE",
		axisYType: "secondary",
		showInLegend: true,
		dataPoints:[
			{ label: "vivo", y: <?php echo $pos_vivo;?> },
			{ label: "samsung", y:<?php echo $pos_samsung;?> },
			{ label: "redmi", y: <?php echo $pos_redmi;?>},
			{ label: "oppo", y: <?php echo $pos_oppo;?> },
			{ label: "iphone", y: <?php echo $pos_iphone;?>},
			
		]
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>      
<?php include 'includes/scripts.php'; ?>
</body>
</html>