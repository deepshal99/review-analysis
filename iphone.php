<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

<?php require 'vendor/autoload.php'; // include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->review_db->iphone_textAnalysis;
$cursor = $collection->find();

// Naviye Baies Classification


$pos=0;
$neg=0;
$neu=0;
$total=0;
foreach($cursor as $document)
{       //echo $document["TextAnalysis"]["score_tag"]."\n";
 	$total+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "N") == 0)
	$neg+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "P") == 0)
	$pos+=1;
        if(strcmp( $document["TextAnalysis"]["score_tag"], "NONE") == 0)
	$neu+=1;

}
//echo $neu;
//echo $pos;
//echo $neg;
//echo $total;
?>

<!DOCTYPE HTML> 
<html>
 <head> 

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> <script 
type="text/javascript"> window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
		title:{
			text: "iphone"
		},
		data: [
		{
			// Change type to "doughnut", "line", "splineArea", etc.
			type: "column",
			dataPoints: [
				{ label: "TOTAL", y: <?php echo $total; ?>  },
				{ label: "NEUTRAL", y: <?php echo $neu; ?>  },
				{ label: "POSITIVE", y: <?php echo $pos; ?>  },
				{ label: "NEGATIVE", y: <?php echo $neg; ?>  }
			]
		}
		]
	});
	chart.render();
}
</script> </head> 
<body>
 <div id="chartContainer" style="height: 400px; width: 70%; margin:100px;"></div>
 </body>
</html>
<?php include 'includes/scripts.php'; ?>
</body>
</html>

