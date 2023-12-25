<?php
defined('BASEPATH') OR exit('No direct script access allowed');


function date_to_timestamp($stFormat, $stData) {

    $aDataRet = array();

    $aPieces = preg_split('[\.|-| |:|/]', $stFormat);
    $aDatePart = preg_split('[\.|-| |:|/]', $stData);

    foreach ($aPieces as $key => $chPiece) {
        switch ($chPiece) {
            case 'd':
            case 'j':
                $aDataRet['day'] = $aDatePart[$key];
                break;

            case 'F':
            case 'M':
            case 'm':
            case 'n':
                $aDataRet['month'] = @$aDatePart[$key];
                break;

            case 'o':
            case 'Y':
            case 'y':
                $aDataRet['year'] = @$aDatePart[$key];
                break;

            case 'g':
            case 'G':
            case 'h':
            case 'H':
                $aDataRet['hour'] = $aDatePart[$key];

                break;

            case 'i':
                $aDataRet['minute'] = $aDatePart[$key];
                break;

            case 's':
                $aDataRet['second'] = $aDatePart[$key];
                break;
        }
    }

    return mktime(@$aDataRet['hour'], @$aDataRet['minute'], 0, $aDataRet['month'], $aDataRet['day'], $aDataRet['year']);
}

function get_price_calculation($start_date, $end_date, $option_arr_values) {
       
    $hours = ($end_date - $start_date) / (60 * 60);
    $hours = ceil($hours);

    $days = 0;
    $calculate_type = $option_arr_values;
    
    switch ($calculate_type){
        case 'perday':
            $days = ($end_date - $start_date) / (24 * 60 * 60);
            $days = ceil($days);
            $hours = 0;
            break;
        case 'perhour':
            $days = 0;
            break;
        case 'both':
            if ($hours >= 24) {
                $days = floor($hours / 24);
            }
            $hours = $hours - $days * 24;
            break;
    }
    return array('h' => $hours, 'd' => $days);
}

function space_remover($str){
    return str_replace(' ', '', $str);
}


function get_js_date_format($php_format) {

    $dateFormats['Y-m-d'] = array('js' => 'yy-mm-dd', 'php' => 'Y-m-d', 'separator' => '-', 'iso' => 'YYYY-MM-DD');
    $dateFormats['Y/m/d'] = array('js' => 'yy/mm/dd', 'php' => 'Y/m/d', 'separator' => '/', 'iso' => 'YYYY/MM/DD');
    $dateFormats['Y.m.d'] = array('js' => 'yy.mm.dd', 'php' => 'Y.m.d', 'separator' => '.', 'iso' => 'YYYY.MM.DD');
    $dateFormats['m-d-Y'] = array('js' => 'mm-dd-yy', 'php' => 'm-d-Y', 'separator' => '-', 'iso' => 'MM-DD-YYYY');
    $dateFormats['m/d/Y'] = array('js' => 'mm/dd/yy', 'php' => 'm/d/Y', 'separator' => '/', 'iso' => 'MM/DD/YYYY');
    $dateFormats['m.d.Y'] = array('js' => 'mm.dd.yy', 'php' => 'm.d.Y', 'separator' => '.', 'iso' => 'MM.DD.YYYY');
    $dateFormats['d-m-Y'] = array('js' => 'dd-mm-yy', 'php' => 'd-m-Y', 'separator' => '-', 'iso' => 'DD-MM-YYYY');
    $dateFormats['d/m/Y'] = array('js' => 'dd/mm/yy', 'php' => 'd/m/Y', 'separator' => '/', 'iso' => 'DD/MM/YYYY');
    $dateFormats['d.m.Y'] = array('js' => 'dd.mm.yy', 'php' => 'd.m.Y', 'separator' => '.', 'iso' => 'DD.MM.YYYY');

    if (!empty($php_format)) {
        if (array_key_exists($php_format, $dateFormats)) {
            return $dateFormats[$php_format]['js'];
        }
    }
    return $dateFormats['d.m.Y']['js'];
}
