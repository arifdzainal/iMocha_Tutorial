<?php
include('config.php');
include('test_devl_trim_data.php');

$user = 'root';
$pass = '';
$db = 'phpmyadmin';
$con = mysqli_connect("localhost", $user, $pass, $db);
?> <br>

<form action="" method="post" name="form1" id="form1">
    <table width="100%" border="0">
        <thead>
            <tr valign="top" bgcolor="#3399FF" style="color:#fff; text-transform:uppercase">
                <td width="250" align="center">ACCOUNT NUMBER</td>
                <td width="350" align="center">COST FOR CALL FOR EACH ACCOUNT</td>
            </tr>
        </thead>
        <tbody>   
            <?php
            $sql = "SELECT * FROM test_imocha GROUP BY ACCNUM";
            $result = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $totalCost = 0;
                $sqlDetail = "SELECT * FROM test_imocha WHERE ACCNUM = '" . $row['ACCNUM'] . "' AND CALL_TYPE = 'P'";
                $result2 = mysqli_query($con, $sqlDetail);
                $accNumber = $row['ACCNUM'];
                while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                    $callFrom = $row2['A_NUM'];
                    $callTo = $row2['B_NUM'];
                    $time1 = $row2['STT_TIME'];
                    $time2 = $row2['END_TIME'];
                    $rate = $row2['CALL_COST'];
                    if ($row2['CALL_TYPE'] == "P") {
                        $type = "PHONE CALL";
                    } else {
                        $type = "OTHERS";
                    }
                    $cost = get_duration_minit1($time1, $time2) * $rate;
                    $totalCost += $cost;
                }
                ?>
                <tr id="row<?php echo $i; ?>" style="color:#CCC">
                    <td width="150" align="center"><?php echo $accNumber; ?></td>
                    <td width="150" align="center"><?php echo get_rate($totalCost);?></td>
                </tr>
                <?php
            }
            ?> 
        </tbody> 
    </table>
</form>