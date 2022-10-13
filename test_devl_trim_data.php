<?php

function trim_tarikh2($tarikh) {
    $tarikh_temp = explode("-", substr($tarikh, 0, 10));

    $tarikh_fix = $tarikh_temp[2] . "/" . $tarikh_temp[1] . "/" . $tarikh_temp[0];
    return $tarikh_fix;
}

function trim_date1($tarikh) {
    $tahun = substr($tarikh, 0, 4);
    $bulan = substr($tarikh, 4, 2);
    $hari = substr($tarikh, 6, 2);

    $tarikhBaru = $tahun . '-' . $bulan . '-' . $hari;

    return $tarikhBaru;
}

function trim_date2($tarikh, $masa) {
    $tahun = substr($tarikh, 0, 4);
    $bulan = substr($tarikh, 4, 2);
    $hari = substr($tarikh, 6, 2);

    $jam = substr($masa, 0, 2);
    $min = substr($masa, 2, 2);
    $saat = substr($masa, 4, 2);

    $tarikhBaru = $tahun . '-' . $bulan . '-' . $hari . ' ' . $jam . ':' . $min . ':' . $saat;

    return $tarikhBaru;
}

function trim_date3($tarikh) {
    $tahun = substr($tarikh, 0, 4);
    $bulan = substr($tarikh, 4, 2);
    $hari = substr($tarikh, 6, 2);

    $tarikhBaru = $tahun . '/' . $bulan . '/' . $hari;

    return $tarikhBaru;
}

function get_duration($tarikh1, $masa1, $tarikh2, $masa2) {

    $start1 = new DateTime(trim_date2($tarikh1, $masa1));
    $start2 = new DateTime(trim_date2($tarikh2, $masa2));

    $duration = date_diff($start1, $start2);

    $tempoh = '';

    if ($duration->y != 0) {
        $tempoh .= $duration->y . ' year ';
    }
    if ($duration->m != 0) {
        $tempoh .= $duration->m . ' month ';
    }
    if ($duration->d != 0) {
        $tempoh .= $duration->d . ' day ';
    }
    if ($duration->h != 0) {
        $tempoh .= $duration->h . ' hour ';
    }
    if ($duration->i != 0) {
        $tempoh .= $duration->i . ' minute ';
    }
    if ($duration->s != 0) {
        $tempoh .= $duration->s . ' second ';
    }

    return $tempoh;
}

function get_duration2($datetime1, $datetime2) {

    $start = date_create($datetime1);
    $end = date_create($datetime2);
    
    $duration = date_diff($start, $end);

    $tempoh = '';

    if ($duration->y != 0) {
        $tempoh .= $duration->y . ' year ';
    }
    if ($duration->m != 0) {
        $tempoh .= $duration->m . ' month ';
    }
    if ($duration->d != 0) {
        $tempoh .= $duration->d . ' day ';
    }
    if ($duration->h != 0) {
        $tempoh .= $duration->h . ' hour ';
    }
    if ($duration->i != 0) {
        $tempoh .= $duration->i . ' minute ';
    }
    if ($duration->s != 0) {
        $tempoh .= $duration->s . ' second ';
    }

    return $tempoh;
}

function getAmPm($time) {
    $hour = substr($time, 0, 2);
    if ($hour > 12) {
        $am_pm = $hour - 12;
        return $am_pm . ":" . substr($time, 3, 2) . " PM";
    } else {
        if ($hour == 12) {
            return ltrim($time, '0') . " PM";
        } else {
//            return ltrim($time, '2') . " AM";
            return $hour . ":" . substr($time, 3, 2) . " AM";
        }
    }
}

function view_type($type) {
    if ($type == "P") {
        echo 'Phone Call';
    } else if ($type == "S") {
        echo 'SMS';
    } else if ($type == "M") {
        echo "Multimedia Message";
    } else {
        echo "Code Missing";
    }
}

function get_duration_minit($tarikh1, $masa1, $tarikh2, $masa2) {

    $start1 = new DateTime(trim_date2($tarikh1, $masa1));
    $start2 = new DateTime(trim_date2($tarikh2, $masa2));

    $duration = date_diff($start1, $start2);

    $total = 0;

    // skip month and year since no call will be more than a day

    if ($duration->d != 0) {
        $total = $total + $duration->h * 60 * 24;
    }
    if ($duration->h != 0) {
        $total = $total + $duration->h * 60;
    }
    if ($duration->i != 0) {
        $total = $total + $duration->i;
    }
    if ($duration->s != 0) {
        $total = $total + 1;
    }

    return $total;
}

function get_duration_minit1($datetime1, $datetime2) {
    
    $tarikh1 = date_create($datetime1);
    $tarikh2 = date_create($datetime2);

    $duration = date_diff($tarikh1, $tarikh2);
    $total = 0;

    // skip month and year since no call will be more than a day

    if ($duration->d != 0) {
        $total = $total + $duration->h * 60 * 24;
    }
    if ($duration->h != 0) {
        $total = $total + $duration->h * 60;
    }
    if ($duration->i != 0) {
        $total = $total + $duration->i;
    }
    if ($duration->s != 0) {
        $total = $total + 1;
    }

    return $total;
}

function get_rate($number) {
    $ringgit = $number / 100;
    return 'RM ' . number_format($ringgit, 2);
}