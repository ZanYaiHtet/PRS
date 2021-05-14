<style type="text/css">
    g[class^='raphael-group-'][class$='-creditgroup'] {
        display: none !important;
    }

    table {
        display: block;
        max-width: -moz-fit-content;
        max-width: fit-content;
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
</style>

<?php

require_once(ROOT . DS . 'vendor' . DS  . 'fusioncharts' . DS . 'fusioncharts.php');

use Cake\ORM\TableRegistry;

$productType = 1;
$categoryType = 1;

if (isset($_POST['peach'])) {

    foreach ($_POST['Color'] as $select) {
        $pinfo_query = getPieCharts($select);
    }
} else {
    $pinfo_query = getPieCharts($categoryType);
}

function getPieCharts($categoryType)
{
    $data = array();
    $pie_category_name = "";

    $proData = TableRegistry::get('products');
    $catData = TableRegistry::get('categories');

    $pinfo_query = $proData->find('all')->where(['category_id' => $categoryType, 'del_flg' => "not"]);
    $catName = $catData->find('all')->where(['id' => $categoryType]);
    foreach ($catName as $result1) {
        $pie_category_name = $result1->name;
    }

    foreach ($pinfo_query as $result) {
        $pid = $result->id;
        $pname = $result->name;
        $rateResult = getRatingForEachProduct($categoryType, $pid);
        $label = $pname;
        if ($rateResult != 0) {
            array_push(
                $data,
                array(
                    "label" => $label,
                    "value" => $rateResult
                )
            );
        }
    }
    $arrData = array(
        "chart" => array(
            "animation" => "0",
            "caption" => "Review for Category " . $pie_category_name,
            // "subCaption" => "",
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

    $arrData["data"] = $data;
    //echo "$data";
    $jsonPieData = json_encode($arrData);

    $columnChart = new FusionCharts("pie3d", "chart-1", "800", "500", "chart-container1", "json", $jsonPieData);

    // Render the chart
    $columnChart->render();
    return $pinfo_query;
}


function getRatingForEachProduct(int $categoryID, int $productID)
{
    $rate = $total_rate = $total_count = 0;
    $chartData = TableRegistry::get('answers');

    for ($i = 1; $i <= 5; $i++) {

        $query1 = $chartData->find('all', [
            'conditions' => ['category_id =' => $categoryID, 'product_id =' => $productID, 'rating =' => $i],
            'distinct' => ['survey_id']
        ])
            ->distinct('survey_id');

        $rowCount = $query1->count();

        if ($rowCount != 0) {
            $total_rate += $i * $rowCount;
            //echo ($total_rate);
            $total_count += $rowCount;
        }
    }
    if ($total_count != 0) {
        $rate = round($total_rate / $total_count);
    } else {
        $rate = 0;
    }
    //echo ("Rating Calculation for Product: " . $rate);
    return $rate;
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


?>


<div class="topnav z-depth-2">
    <a href="/DataAnalysis/menu">Data Analysis Result</a>
    <a class="active" href="/DataAnalysis/category">Category</a>
    <a href="/DataAnalysis/product">Product</a>
</div>
<br><br>
<form action="" method="post">
    <div class="row">
        <div class="col s4">
            <select id="ctype" name="Color[]">
                <option value="">Select Category</option>
                <?php foreach ($categories_list as $c) : ?>
                    <option value="<?= h($c->id) ?>"><?= h($c->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col s2">
            <button type="submit" name="peach" class="btn waves-effect indigo">View Results</button>
        </div>
    </div>
</form>
<br>

<div class="row">
    <div id="chart-container1"></div>
</div>
<div class="row">
    <table>
        <tr>
            <th>Product Name</th>
            <th>Model No</th>
            <th>Price</th>
        </tr>
        <?php foreach ($pinfo_query as $p) : ?>
            <tr>
                <td width="20"><?= h($p->name) ?></td>
                <td width="20"><?= h($p->model_no) ?></td>
                Product Price: <spanstyle="color:red"><?= number_format(floatval($p['pprice'])); ?></span>


                    <td width="20"><?= number_format(floatval($p->price)) . " MMK" ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('select').formSelect();
    });
</script>