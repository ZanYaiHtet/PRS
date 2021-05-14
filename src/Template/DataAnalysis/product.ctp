<style type="text/css">
    g[class^='raphael-group-'][class$='-creditgroup'] {
        display: none !important;
    }

    table {
        display: block;
        max-width: -moz-fit-content;
        max-width: fit-content;
        margin: 0 auto;
        overflow-x: auto;
        white-space: nowrap;
    }

    .hline {
        text-align: center;
        background-color: #CEF6CE;
        border: 2px solid green;
    }

    h3 {
        color: #298A08;

    }

    .button {
        border: 2px;
        width: 200px;
        height: 50px;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        background-color: #4CAF50;

    }

    .striped-border {
        border: 1px dashed #000;
        width: 50%;
        margin: auto;
        margin-top: 5%;
        margin-bottom: 5%;
        background-color: #4CAF50;

    }

    .checked {
        color: orange;
    }

    .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav {
        overflow: hidden;
        background-color: #5c6bc0;
    }

    .topnav a:hover {
        background-color: #9fa8da;
        color: black;
    }

    .topnav a.active {
        background-color: #4CAF50;
        color: white;
    }

    .left-row {
        margin-left: 15px;
    }
</style>

<div class="topnav z-depth-2">
    <a href="/DataAnalysis/menu">Data Analysis Result</a>
    <a href="/DataAnalysis/category">Category</a>
    <a class="active" href="/DataAnalysis/product">Product</a>
</div>

<?php

require_once(ROOT . DS . 'vendor' . DS  . 'fusioncharts' . DS . 'fusioncharts.php');

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

if (isset($_POST['showproduct'])) {

    $jsPid = $_POST['Pro'];
    if ($jsPid[0] != "") {

        $prodFeed = getFeedback($jsPid[0]);
        getColunCharts($jsPid[0]);
    } else {
        getColunCharts(1);
        echo '<div class="error-alert">
<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
<center><strong>Please Choose the Product Name!</strong> </center>
</div>';
    }
} else {
    //getColunCharts(1);
    $pid = getFirstPid();
    getColunCharts($pid);
    $prodFeed = getFeedback($pid);
}

function getFirstPid()
{
    $firstId = 1;
    $proFirst = TableRegistry::get('products');
    $pquery = $proFirst->find('all');
    $pquery = $proFirst->find()->where(['del_flg' => "not"])->order(['id' => 'ASC']);
    foreach ($pquery as $result1) {
        $firstId = $result1->id;
    }
    return $firstId;
}

function getColunCharts($productID)
{
    $chart_product_name = "";
    $proData = TableRegistry::get('products');
    $pquery = $proData->find('all')->where(['id' => $productID, 'del_flg' => "not"]);
    foreach ($pquery as $result1) {
        $chart_product_name = $result1->name;
    }
    $dataChart = getAvgRating($productID);
    $arrData1 = array(
        "chart" => array(
            "animation" => "0",
            "caption" => "Review by Age for Product: " . $chart_product_name,
            // "subCaption" => "No. Of Visitors Last Week",
            "xAxisName" => "Age",
            "yAxisName" => "No. Of Rating",
            "showValues" => "0",
            // "paletteColors"=> "#81BB76", 
            "useDataPlotColorForLabels" => "1",
            "showHoverEffect" => "1",
            "use3DLighting" => "0",
            "showaxislines" => "1",
            "baseFontSize" => "13",
            "theme" => "fint"
        )
    );

    $arrData1["data"] = $dataChart;

    $jsonEncodedData1 = json_encode($arrData1);
    //echo "$jsonEncodedData1 ";
    $columnChart1 = new FusionCharts("column2d", "chart-2", "600", "300", "chart-container2", "json", $jsonEncodedData1);

    // Render the chart
    $columnChart1->render();
}

function getAvgRating(int $pid)
{
    $connection = ConnectionManager::get('default');
    $results1 = $connection->execute('SELECT avg(rating) as rating from `answers` WHERE product_id=? and user_id IN' . '(SELECT id FROM `users` WHERE age<=16)', [$pid])->fetchAll('assoc');
    $results2 = $connection->execute('SELECT avg(rating) as rating from `answers` WHERE product_id=? and user_id IN' . '(SELECT id FROM `users` WHERE 16<age and age<=30)', [$pid])->fetchAll('assoc');
    $results3 = $connection->execute('SELECT avg(rating) as rating from `answers` WHERE product_id=? and user_id IN' . '(SELECT id FROM `users` WHERE 30<age and age<=50)', [$pid])->fetchAll('assoc');
    $results4 = $connection->execute('SELECT avg(rating) as rating from `answers` WHERE product_id=? and user_id IN' . '(SELECT id FROM `users` WHERE age>50)', [$pid])->fetchAll('assoc');

    $avg1 = getAvgResult($results1);
    $avg2 = getAvgResult($results2);
    $avg3 = getAvgResult($results3);
    $avg4 = getAvgResult($results4);

    $data = array();
    $labels = array("age<=16", "16<age<=30", "30<age<=50", "age>50");
    $avg = array($avg1, $avg2, $avg3, $avg4);
    for ($i = 0; $i <= 3; $i++) {
        array_push(
            $data,
            array(
                "label" => $labels[$i],
                "value" => $avg[$i]
            )
        );
    }
    return $data;
}

function getAvgResult($results)
{

    foreach ($results as $results) {
        $average_rating = $results['rating'];
        if ($average_rating == null) {
            $average_rating = 0;
        }
    }
    return $average_rating;
}

function getFeedback($pid)
{
    //echo ("product_id" . $pid);
    $connection = ConnectionManager::get('default');
    $prodFeed = $connection->execute('SELECT users.name as fname, answers.remark as fremark , answers.rating as frating, answers.created as fdate FROM answers,users where product_id=? and users.id=answers.user_id group by user_id', [$pid])->fetchAll('assoc');
    return $prodFeed;
}
?>

<form method="post" style="margin-top: 2rem;">
    <div class="row">
        <div class="col s4">
            <select id="ptype" name="Pro[]">
                <option value="">Select Product</option>
                <?php foreach ($products_list as $p) : ?>
                    <option value="<?= h($p->id) ?>"><?= h($p->name) ?></option>

                <?php endforeach; ?>
            </select>
        </div>
        <div class="col s2">
            <button type="submit" name="showproduct" class="btn waves-effect indigo" />View Results</button>
        </div>
    </div>
</form>
<div class="row">
    <div id="chart-container2" class="col"></div>
</div>
<br>
<div>
    <div class="row">
        <h5 style="font-weight:bold;">Rating and Reviews</h5>
    </div>
    <?php $var = 1; ?>
    <?php foreach ($prodFeed as $p) : ?>
        <?php if ($p['fremark'] != "") : ?>

            <div class="row">
                <p><?= "<span style=\"font-weight:bold;\">" . $this->Number->format($var++) ?><?= ". " . $p['fname'] . "</span>" ?>
                </p>
                <div class="left-row">
                    <?php for ($i = 0; $i < $p['frating']; $i++)
                        echo '<span class="fa fa-star checked"></span>';
                    ?>
                    <p><?= date('d.m.Y', strtotime($p['fdate'])); ?></p>
                    <p><?= $p['fremark'] ?></p>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>


<script>
    $(document).ready(function() {
        $('select').formSelect();
    });
</script>