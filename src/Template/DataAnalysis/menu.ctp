<style type="text/css">
    g[class^='raphael-group-'][class$='-creditgroup'] {
        display: none !important;
    }

    table {
        display: block;
        max-width: -moz-fit-content;
        max-width: fit-content;
        margin: 0 auto;
        /* overflow-x: auto; */
        white-space: nowrap;
        table-layout: auto;
        width: 100%;
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

    img {
        border-radius: 10px;
    }
</style>

<div class="topnav z-depth-2">
    <a class="active" href="/DataAnalysis/menu">Data Analysis Result</a>
    <a href="/DataAnalysis/category">Category</a>
    <a href="/DataAnalysis/product">Product</a>
</div>

<br><br>
<div><a class="btn-large teal lighten-2">Trending Products</a></div>

<!-- <div>
    <table>
        <tbody>
            <tr>
                <?php foreach ($product_list as $p) : ?>
                    <?php if ($p['pimage'] != null) ?>
                    <?php $imgName = "/upload/images/" . $p['pimage']; ?>
                    <td width="20">
                        <?php echo "<img src='" . $imgName . " ' width=\"160px\" height=\"160px\">"; ?>
                    </td>
                    <td width="20">

                        Product Model No: <span style="color:red"><?= h($p['pmodel_no']) ?></span><br>
                        Product Name: <span style="color:red"><?= h($p['pname']) ?></span>

                    </td>
                <?php endforeach; ?>

            </tr>
        </tbody>
    </table>
</div> -->

<div>
    <br>
    <table>
        <tbody>
            <?php $var = 1; ?>
            <tr>
                <?php foreach ($product_list as $p) : ?>

                    <?php if ($p['pimage'] != null) ?>
                    <?php $imgName = "/upload/images/" . $p['pimage']; ?>
                    <td width="20">
                        <?php echo "<img src='" . $imgName . " ' width=\"160px\" height=\"160px\">"; ?>
                    </td>
                    <td width="20">
                        Product Model No: <span style="color:red"><?= h($p['pmodel_no']) ?></span><br>
                        Product Name: <span style="color:red"><?= h($p['pname']) ?></span><br>
                        Product Price: <span style="color:red"><?= number_format(floatval($p['pprice'])) . " MMK"; ?></span>
                    </td>
                    <?php if ($var % 2 == 0) : ?>
            </tr>
            <tr>
            <?php endif; ?>
            <?php $var++; ?>
        <?php endforeach; ?>

        </tbody>

    </table>
<<<<<<< HEAD
</div>

<div>
    <br>
    <table class="table2">
        <tbody>
 
            <?php $var = 1; ?>
            <tr>
                <?php foreach ($product_list as $p) : ?>
 
                    <?php if ($p['pimage'] != null) ?>
                    <?php $imgName = "/upload/images/" . $p['pimage']; ?>
                    <td width="20">
                        <?php echo "<img src='" . $imgName . " ' width=\"160px\" height=\"160px\">"; ?>
                        <br>
                        Product Model No: <span style="color:red"><?= h($p['pmodel_no']) ?></span><br>
                        Product Name: <span style="color:red"><?= h($p['pname']) ?></span><br>
                        Product Price: <span style="color:red"><?= h($p['pprice']) ?></span>
                    </td>
 
                    <?php if ($var % 4 == 0) : ?>
            </tr>
            <tr><?php endif; ?>
            <?php $var++; ?>
        <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
=======
>>>>>>> 0e337383331b6d0ed65a398a93dfe714b4d4f655
</div>