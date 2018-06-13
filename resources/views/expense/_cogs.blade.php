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
<br>
<h1>Cost Of Goods Sold (COGS) ||Expense Budget</h1>
<table class="table table-hover table-striped table-responsive" style="margin-top: 10px;">
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
        <th class="border-left">Budget</th>
        <th>Actual</th>
        <th>Remaining</th>
    </tr>
    </thead>
    <tbody>

    <!-- All Food Row Columns-->
    <tr>
        <th>Food</th>
        <td><b>

                <?php
                    if(isset($totals['Food'])  ? $totals['Food']:0){
                        $roundedFoodTotal = (round($totals['Food'] /50) * 50);
                    } else {
                        $roundedFoodTotal = 0;
                    }
                ?>
                    {{"$"}}{{$roundedFoodTotal}}

            </b></td>
        <td><b>{{"$" . (round((int)($site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100) / 50)) * 50   }}</b></td>
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
        <td class="border-left border-dark">
           <?php
            if(isset($_GET['food_cogs'])){
                $food_budget_total = (round(number_format((int)($budget->weekly_food) * 7, 0, '.', '') / 50) * 50);
                echo "$" . $food_budget_total;
                
            }
            else{
                $budget->cogsTarget($food_cogs,'Food');
               $food_budget_total = (round(number_format((int)($budget->weekly_food) * 7, 0, '.', '') / 50) * 50);
                echo "$" . $food_budget_total;
            }?> 
        </td>
        <td>{{"$"}}{{number_format($food_actual = (isset($weekly_totals['Food']) ? $weekly_totals['Food']:0) / 100, 0, '.', '')}}</td>
        <td>{{"$"}}{{number_format((float)($food_budget_total - $food_actual), 0, '.', '')}}</td>
    </tr>


    <!-- All Alcohol Row Columns-->
    <tr>
        <th>Alcohol</th>
        <td><b>
                <?php
                if(isset($totals['Alcohol'])  ? $totals['Alcohol']:0){
                    $roundedAlcoholTotal = (round($totals['Alcohol'] /50) * 50);
                } else {
                    $roundedAlcoholTotal = 0;
                }
                ?>
                {{"$"}}{{$roundedAlcoholTotal}}
            </b></td>
        <td><b>{{"$" . (round((int)($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100) / 50)) * 50   }}</b></td>
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
        <td class="border-left border-dark">
           <?php
            if(isset($_GET['alcohol_cogs'])){
                $alcohol_budget_total = (round(number_format((int)($budget->weekly_alcohol) * 7, 0, '.', '') / 50) * 50);
                echo "$" . $alcohol_budget_total;
                
            }
            else{
                $budget->cogsTarget($alcohol_cogs,'Alcohol');
                $alcohol_budget_total = (round(number_format((int)($budget->weekly_alcohol) * 7, 0, '.', '') / 50) * 50);
                echo "$" . $alcohol_budget_total;
                
            }?> 
        </td>
        <td>{{"$"}}{{number_format($alcohol_actual = (isset($weekly_totals['Alcohol']) ? $weekly_totals['Alcohol']:0) / 100, 0, '.', '' ) }}</td>
        <td>{{"$"}}{{number_format((float)($alcohol_budget_total - $alcohol_actual), 0, '.', '')}}</td>
    </tr>

    <!-- All Beverage Row Columns-->
    <tr>
        <th>Beverages</th>
        <td><b>
                <?php
                if(isset($totals['Beverage'])  ? $totals['Beverage']:0){
                    $roundedBeverageTotal = (round($totals['Beverage'] /50) * 50);
                } else {
                    $roundedBeverageTotal = 0;
                }
                ?>
                {{"$"}}{{$roundedBeverageTotal}}
            </b></td>
        <td><b>{{"$" . (round((int)($site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100) / 50)) * 50}}</b></td>
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
        <td class="border-left border-dark">
           <?php
            if(isset($_GET['beverage_cogs'])){
                $beverage_budget_total = (round(number_format((int)($budget->weekly_beverage) * 7, 0, '.', '') / 50) * 50);
                echo "$" . $beverage_budget_total;
                
            }
            else{
                $budget->cogsTarget($beverage_cogs,'Beverage');
               $beverage_budget_total = (round(number_format((int)($budget->weekly_beverage) * 7, 0, '.', '') / 50) * 50);
                echo "$" . $beverage_budget_total;
                
            }?> 
        <td>{{"$"}}{{number_format($beverage_actual = (isset($weekly_totals['Beverage']) ? $weekly_totals['Beverage']:0) / 100, 0, '.', '')}}</td>
        <td>{{"$"}}{{number_format((float)($beverage_budget_total - $beverage_actual), 0, '.', '')}}</td>
    </tr>

    <!-- All Totals Row Columns-->
    <tr>
        <th>Total</th>
        <td><b>{{"$" . (round(array_sum($totals) /50) * 50)   }}</b></td>
        <td><b>{{"$" . (round((int)(($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) + $site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) +  $site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) / 100) / 50 )) * 50}}</b></td>
        <td></td>
        <td></td>
        <td class="border-left border-dark">{{"$"}}{{$total_budget = ($food_budget_total + $alcohol_budget_total + $beverage_budget_total)}}</td>
        <td>{{"$"}}{{number_format($total_actual = ($food_actual + $alcohol_actual + $beverage_actual), 0, '.', '')}}</td>
        <td>
            {{"$"}}{{number_format((float)($total_budget - $total_actual), 0, '.', '')}}
        </td>
    </tr>

    </tbody>
</table>
