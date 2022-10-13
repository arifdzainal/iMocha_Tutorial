<?php
include('config.php');
include('test_devl_trim_data.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpmyadmin";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (($_FILES['file_candidate_list']['name'] != "")) {
    // Where the file is going to be stored
    $target_dir = "daily_report/";
    $file = $_FILES['file_candidate_list']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $temp_name = $_FILES['file_candidate_list']['tmp_name'];
    $path_filename_ext = $target_dir . $filename . "." . $ext;

    // Check if file already exists
    if (file_exists($path_filename_ext)) {
//        echo "Sorry, file already exists. >> " . $path_filename_ext;
    } else {
        move_uploaded_file($temp_name, $path_filename_ext);
//        echo "Congratulations! File Uploaded Successfully. >> " . $path_filename_ext;
    }
} else {
    
}
?>

<table width="100%" border="0">
    <thead>
        <tr valign="top" bgcolor="#3399FF" style="color:#fff; text-transform:uppercase">
            <td width="250" align="center">ACCOUNT NUMBER</td>
            <td width="100" align="center">CALL FROM</td>
            <td width="150" align="center">CALL TO</td>
<!--            <td width="150" align="center">DATE START</td>
            <td width="250" align="center">TIME START</td>
            <td width="50" align="center">DATE END</td>
            <td width="200" align="center">TIME END</td>-->
            <td width="200" align="center">START CALL</td>
            <td width="200" align="center">END CALL</td>
            <td width="200" align="center">DURATION</td>
            <td width="200" align="center">CALL TYPE</td>
            <td width="80" align="center">RATE</td>
            <td width="350" align="center">COST</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $file_content = file($path_filename_ext);
        $i = 1;
        $costP = 0;
        $costM = 0;
        $costS = 0;
        
        $truncatetable = mysql_query("TRUNCATE TABLE test_imocha");
        if($truncatetable !== FALSE) {
            echo("All rows have been deleted.");
        } else {
            echo("No rows have been deleted.");
        }
        
        foreach ($file_content as $line) {
            $cost = 0;
            $line = explode(" ", $line);
            $result1 = substr($line[3], 0, 8);
            $result2 = substr($line[3], 8, 6);
            $result3 = substr($line[3], 14, 8);
            $result4 = substr($line[3], 22, 6);
            $result5 = substr($line[3], 28, 1);
            $result6 = substr($line[3], 29, 2);

            $accNumber = $line[0];
            $callFrom = $line[1];
            $callTo = $line[2];
            $dateStart = $result1;
            $timeStart = $result2;
            $dateEnd = $result3;
            $timeEnd = $result4;
            $type = $result5;
            $rate = $result6;
            ?>

            <tr id="row<?php echo $i; ?>" style="color:#CCC">
                <td width="150" align="center"><?php echo $accNumber; ?></td>
                <td width="150" align="center"><?php echo $callFrom; ?></td>
                <td width="150" align="center"><?php echo $callTo; ?></td>
    <!--                <td width="150" align="center"><?php echo trim_date1($dateStart); ?></td>
                <td width="150" align="center"><?php echo getAmPm($timeStart); ?></td>
                <td width="150" align="center"><?php echo trim_date1($dateEnd); ?></td>
                <td width="150" align="center"><?php echo getAmPm($timeEnd); ?></td>-->
                <td width="150" align="center"><?php echo trim_date1($dateStart) . ' ' . getAmPm($timeStart); ?></td>
                <td width="150" align="center"><?php echo trim_date1($dateEnd) . ' ' . getAmPm($timeEnd); ?></td>
                <td width="150" align="center"><?php
                    if ($type == "P") {
                        echo get_duration($dateStart, $timeStart, $dateEnd, $timeEnd);
                    } else {
                        echo 1;
                    }
                    ?></td>
                <td width="150" align="center"><?php echo view_type($type); ?></td>
                <td width="150" align="center"><?php echo get_rate($rate); ?></td>
                <td width="150" align="center"><?php
                    if ($type == "P") {
                        $cost = get_duration_minit($dateStart, $timeStart, $dateEnd, $timeEnd) * $rate;
                        $costP += $cost;
                    } else if ($type == "S") {
                        $cost = $rate;
                        $costS += $cost;
                    } else if ($type == "M") {
                        $cost = $rate;
                        $costM += $cost;
                    }
                    echo get_rate($cost);

                    $masa1 = trim_date2($dateStart, $timeStart);
                    $masa2 = trim_date2($dateEnd, $timeEnd);
                    
                    $queryInsert = "INSERT INTO `test_imocha` (`ACCNUM`, `A_NUM`, `B_NUM`, `STT_TIME`, `END_TIME`, `CALL_TYPE`, `CALL_COST`, `FILE`)
                                VALUES ('$accNumber', '$callFrom', '$callTo', '$masa1', '$masa2', '$type', '$rate', '$filename') ";
//                    echo 'data >>> ' . $queryInsert;
//                    $rInsert = mysql_query($queryInsert);
                    if (mysqli_query($conn, $queryInsert)) {
//                        echo "New record created successfully";
                    } else {
//                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    ?>
                </td>
            </tr>
            <?php
            $i++;
        }
        ?> 
    </tbody> 
</table>

<table>
    <tr>
        <td colspan="3">TOTAL DATA UPLOADED</td>
    </tr>
    <tr>
        <td>Phone Call</td>
        <td> : </td>
        <td><?php echo get_rate($costP); ?></td>
    </tr>
    <tr>
        <td>SMS</td>
        <td> : </td>
        <td><?php echo get_rate($costS); ?></td>
    </tr>
    <tr>
        <td>Multimedia Message</td>
        <td> : </td>
        <td><?php echo get_rate($costM); ?></td>
    </tr>
    <tr>
        <td>TOTAL ALL</td>
        <td> : </td>
        <td><?php echo get_rate($costP+$costS+$costM); ?></td>
    </tr>
</table>
<br><br><br>
<form name="imocha_report" id="imocha_report" method="post" action="test_devl_imocha_summary.php?fail=<?php echo $filename; ?>" style="padding-left: 92%">
    <table>
        <tr class="no-print" style="padding-left: 30%">
            <td>
                <input type="submit" name="back" id="back" value="GO TO REPORT SUMMARY" class="search_btn no-print"  onclick="this.form.submit()" />
                <input type="hidden" name="fail" id="fail" value="<?php echo $filename; ?>" />
            </td>
        </tr>
    </table>
</form>

</table>

<?php
mysqli_close($conn);
