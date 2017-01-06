<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
function getData(){
        
		return array(
                '0' => array(
                        'id' => 1234,
                        'price' => 20,
                        'name' => 'BA',
                        'percentage' => 10
                ),
                '1' => array(
                        'id' => 2345,
                        'price' => 30,
                        'name' => 'MA',
                        'percentage' => -10
                ),
                '2' => array(
                        'id' => 23451,
                        'price' => 35,
                        'name' => 'NIFTY',
                        'percentage' => -10
                )

        );
}
function getStockPrices(){
	$stocks = API_HIT_TO_GET_UPDATED_PRICES;
	$p = @$_REQUEST['p'];
	$stocksData = getData();			
	$stocks = json_encode($stocksData);
        //creating history, it will run in thread
 //       exec('insert it into db for history');
        //return directly to view
        return $stocks;
}
$stocksDetails = getStockPrices();
$stocks = json_decode($stocksDetails);
//echo "stocks <pre>";print_r($stocks);echo "</pre>";
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>jQuery simplyScroll - Logicbox</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js">
</script>
<!--<script type="text/javascript" src="/js/common.js"></script>-->
<script type="text/javascript" src="js/jquery.simplyscroll.js"></script>
<link rel="stylesheet" href="css/jquery.simplyscroll.css" media="all" type="text/css">
<script type="text/javascript">
(function($) {
        $(function() {
                $("#scroller").simplyScroll();
        });
setInterval(function(){getUpdatedStockPrices();}, 2000);

function getUpdatedStockPrices(){
	var stockPrices = $.ajax({
        	type: "GET",
        	url: "getTicker.php",
	        async: false
	    }).success(function(){
	        setTimeout(function(){getUpdatedStockPrices();}, 2000);
	    }).responseText;
	if(stockPrices != ''){
		var obj = JSON.parse(stockPrices);
		if(obj){
			for(key in obj){
				if(obj[key] != undefined){
					var stockPriceId = 0;
					console.log('id '+obj[key]['id']);
					if(obj[key]['id'] != undefined){
						stockPriceId = obj[key]['id'];
					}
					if(stockPriceId > 0){
						for(fieldName in obj[key]){
							if(fieldName == 'price'){
								var displayPrice = $('.stockPrice_'+stockPriceId).val();
								var newPrice = obj[key]['price'];
								if(newPrice != displayPrice){
console.log('update new price '+newPrice);
									$('.stockPrice_'+stockPriceId).val(newPrice);
								}
							}
						}
					}
				}
			}
		}
	}
}
})(jQuery);
</script>
</head>

<body>
<h1> Stock Exchange Data</h1>
<?php if(count($stocks) > 0){?>
<ul id="scroller">
	<?php foreach($stocks as $stock){?>
		<li>
			<table width=”100%” border=”0” cellspacing="0" cellpadding="0">
                                                <tr>
                                                        <td>
                                                                <?php echo $stock->name;?>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td>
                                                                <input type="text" class="stockPrice_<?php echo $stock->id?>" value="<?php echo $stock->price?>" />
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td>
                                                                <?php if($stock->percentage > 0){
                                                                        echo "up image";
                                                                }else{
                                                                        echo "down image";
                                                                }?>
                                                        </td>
                                                </tr>
                                        </table>

		</li>
	<?php }?>
</ul>
<?php }?>

</body>
</html>
