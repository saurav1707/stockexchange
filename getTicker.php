<?php 
function getData(){
                return array(
                '0' => array(
                        'id' => 1234,
                        'price' => 30,
                        'name' => 'BA',
                        'percentage' => 10
                ),
                '1' => array(
                        'id' => 2345,
                        'price' => 40,
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
$stockDetails = getData();
$stocks = json_encode($stockDetails);
echo $stocks;

?>
