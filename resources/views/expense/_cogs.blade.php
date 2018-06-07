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
<table class="table table-bordered table-responsive" style="margin-top: 10px;">
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
        <th>Target COGS</th>
        <th>Actual COGS</th>
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
        <?php
        if (isset($_GET['food_cogs']))
        {
            $food_cogs = $_GET['food_cogs'];
            $budget->cogsTarget($food_cogs,'Food');

        }
        else
        {
            $food_cogs = $budget->getCOGS('Food');
        }
        ?>
        <td><form name="form" action="" method="get">
                <input type="number" name="food_cogs" id="food_cogs" value="{{$food_cogs}}">
                <input type="submit" name="cogs_button" value="SET"/>
            </form>
        </td>
        <td>
            {{ (int)($cogs->twenty_eight_day_food * 100) . "%"}}
        </td>
        <td>
           <?php
            if(isset($_GET['food_cogs'])){
                $food_budget_total = number_format((float)($budget->weekly_food) * 7, 2, '.', '');
                echo $food_budget_total;
                
            }
            else{
                $budget->cogsTarget($food_cogs,'Food');
               $food_budget_total = number_format((float)($budget->weekly_food) * 7, 2, '.', '');
                echo $food_budget_total;
            }?> 
        </td>
        <td></td>
        <td></td>

    </tr>
    <tr>
        <th>Alcohol</th>
        <td><b>
                {{"$"}}{{isset($totals['Alcohol']) ? $totals['Alcohol']:0}}
            </b></td>
        <td><b>{{"$" . ($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
        <?php
        if (isset($_GET['alcohol_cogs']))
        {
            $alcohol_cogs = $_GET['alcohol_cogs'];
            $budget->cogsTarget($alcohol_cogs,'Alcohol');

        }
        else
        {
            $alcohol_cogs = $budget->getCOGS('Alcohol');
        }
        ?>
        <td><form name="form" action="" method="get">
                <input type="number" name="alcohol_cogs" id="alcohol_cogs" value="{{$alcohol_cogs}}">
                <input type="submit" name="cogs_button" value="SET"/>
            </form>
        </td>
        <td>
            {{ (int)($cogs->twenty_eight_day_alcohol * 100) . "%"}}
        </td>
        <td>
           <?php
            if(isset($_GET['alcohol_cogs'])){
                $alcohol_budget_total = number_format((float)($budget->weekly_alcohol) * 7, 2, '.', '');
                echo $alcohol_budget_total;
                
            }
            else{
                $budget->cogsTarget($alcohol_cogs,'Alcohol');
               $alcohol_budget_total = number_format((float)($budget->weekly_alcohol) * 7, 2, '.', '');
                echo $alcohol_budget_total;
                
            }?> 
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>Beverages</th>
        <td><b>
                {{"$"}}{{isset($totals['Beverage']) ? $totals['Beverage']:0}}
            </b></td>
        <td><b>{{"$" . ($site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
        <?php
        if (isset($_GET['beverage_cogs']))
        {
            $beverage_cogs = $_GET['beverage_cogs'];
            $budget->cogsTarget($beverage_cogs,'Beverage');

        }
        else
        {
            $beverage_cogs = $budget->getCOGS('Beverage');
        }
        ?>
        <td><form name="form" action="" method="get">
                <input type="number" name="beverage_cogs" id="beverage_cogs" value="{{$beverage_cogs}}">
                <input type="submit" name="cogs_button" value="SET"/>
            </form>
        </td>
        <td>
            {{ (int)($cogs->twenty_eight_day_beverage * 100) . "%"}}
        </td>
        <td>
           <?php
            if(isset($_GET['beverage_cogs'])){
                $beverage_budget_total = number_format((float)($budget->weekly_beverage) * 7, 2, '.', '');
                echo $beverage_budget_total;
                
            }
            else{
                $budget->cogsTarget($beverage_cogs,'Beverage');
               $beverage_budget_total = number_format((float)($budget->weekly_beverage) * 7, 2, '.', '');
                echo $beverage_budget_total;
                
            }?> 
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
