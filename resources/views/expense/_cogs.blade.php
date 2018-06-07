<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/6/2018
 * Time: 12:26 PM
 */
?>

<!------------------------------------ COGS Table ------------------------>
<br>
<h1>Cost Of Goods Sold (COGS)</h1>
<table class="table table-responsive" style="margin-top: 10px;">
    <thead>
    <tr>
        <th  bgcolor="#b3b3b3" >DARKBlack</th>
        <th colspan="4"><center>COGS for the Last 4 Weeks</center></th>
        <th colspan="3">Expenses This Week</th>
    </tr>
    <tr>
        <th>Category</th>
        <th>Expenses</th>
        <th>Sales</th>
        <th>Target</th>
        <th>Actual</th>
        <th>Budget</th>
        <th>Actual</th>
        <th>Remaining</th>
    </tr>
    </thead>
    <tbody>
    <tr>

        <th>Food</th>
        <td><b>
                {{"$"}}{{isset($totals['Food']) ? $totals['Food']:0}}
            </b></td>
        <td><b>{{"$" . ($site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
        <td>{!! Form::number('number', 33) !!} % </td>
        <td>
            {{ (int)($cogs->twenty_eight_day_food * 100) . "%"}}
        </td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
    <tr>
        <th>Alcohol</th>
        <td><b>
                {{"$"}}{{isset($totals['Alcohol']) ? $totals['Alcohol']:0}}
            </b></td>
        <td><b>{{"$" . ($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
        <td>33%</td>
        <td>
            {{(int)($cogs->twenty_eight_day_alcohol * 100) . "%"}}
        </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>Beverages</th>
        <td><b>
                {{"$"}}{{isset($totals['Beverage']) ? $totals['Beverage']:0}}
            </b></td>
        <td><b>{{"$" . ($site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
        <td>33%</td>
        <td>
            {{(int)($cogs->twenty_eight_day_beverage * 100) . "%"}}
        </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>Total</th>
        <td><b>{{"$" . array_sum($totals)}}</b></td>
        <td><b>{{"$" . (($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) + $site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) +  $site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) / 100)}}</b></td>
    </tr>

    </tbody>
</table>
