<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/6/2018
 * Time: 12:26 PM
 */
?>

<!------------------------------------ Forecast Table ------------------------>
<br>
<h1>Upcoming Sales Forecast</h1>
<table class="table table-bordered table-responsive" style="margin-top: 10px;">
    <thead>
    <tr>
        <th colspan="3">Sales Forecast</th>
    </tr>
    <tr>
        <th>Average Daily Sales Over Previous 28 Days</th>
        <th>Sales Forecast Adjustment</th>
        <th>Projected Sales </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <!-- This displays the 7 day average of the past week -->
        <td rowspan="3">{{"$" . number_format((float)($cogs->twenty_eight_day_avg /100), 2, '.', '')}}</td>

        <?php
        if (isset($_GET['subject']))
        {
            $fore_percent = $_GET['subject'];
            $forecast->growth($fore_percent);
            $forecast->date();
            $forecast->forecastCalculation();

        }
        else
        {
            $forecast->forecastCalculation();
            $forecast->getPercentage();
            $fore_percent = $forecast->growth_rate;
        }
        ?>
        <td><form name="form" action="" method="get">
                <input type="number" name="subject" id="subject" value="{{$fore_percent}}">
                <input type="submit" name="forecast_button"
                       value="SCALE"/>
            </form>
        </td>
        <td><?php
            if(isset($_GET['subject'])){
                $fore_percent = $_GET['subject'];
                $forecast->growth($fore_percent);
                $forecast->date();
                $forecast->forecastCalculation();
                echo "$" . number_format((float)$forecast->seven_day, 2, '.', '');
            }
            else{
                $forecast->getPercentage();
                $forecast->forecastCalculation();
                $fore_percent = $forecast->growth_rate;
                echo "$" . number_format((float)$forecast->seven_day, 2, '.', '');
            }?>
        </td>
    </tr>
    </tbody>
</table>
