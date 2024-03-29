<?php

use App\Helpers\AdminHelper;
use App\Http\Controllers\WebMainController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #    defWebAssets
if (!function_exists('defWebAssets')) {
    function defWebAssets($path, $secure = null): string{
        return app('url')->asset('assets/web/' . $path, $secure);
    }
}

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #    underAssets
if (!function_exists('underAssets')) {
    function underAssets($path, $secure = null): string{
        return app('url')->asset('assets/under/' . $path, $secure);
    }
}

#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     getPhotoPath
if (!function_exists('getPhotoPath')) {
    function getPhotoPath($file,$defPhoto="dark_logo",$defPhotoThum="photo"){
        $defPhoto_file = WebMainController::getDefPhotoById($defPhoto);
        if($file){
            $sendImg = defImagesDir($file);
        }else{
            $sendImg = defImagesDir($defPhoto_file->$defPhotoThum ?? '');
        }
        return $sendImg ;
    }
}
#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #    getDefPhotoPath
if (!function_exists('getDefPhotoPath')) {
    function getDefPhotoPath($DefPhotoList,$cat_id,$defPhotoThum="photo"){
        if ($DefPhotoList->has($cat_id)) {
            $file =  $DefPhotoList[$cat_id][$defPhotoThum] ;
            $sendImg = defImagesDir($file);
        }else{
            $sendImg = ""  ;
        }
        return $sendImg ;
    }
}
#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     webChangeLocale
if (!function_exists('webChangeLocale')) {
    function webChangeLocale(){
        $Current =  LaravelLocalization::getCurrentLocale() ;
        if($Current == 'ar'){
            $change = 'en';
        }else{
            $change = 'ar';
        }
        return $change;
    }
}
//#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//#|||||||||||||||||||||||||||||||||||||| #     webChangeLocaletext
if (!function_exists('webChangeLocaletext')) {
    function webChangeLocaletext(){
        $Current =  LaravelLocalization::getCurrentLocale() ;
        if($Current == 'ar'){
            $change = 'English';
        }else{
            $change = 'عربى';
        }
        return $change;
    }
}
#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     GetCopyRight
if (!function_exists('GetCopyRight')) {
    function GetCopyRight($StartDate,$CompanyName) {
        if($StartDate > date("Y")) {
            $StartDate = date("Y");
        }
        $Lang =  LaravelLocalization::getCurrentLocale() ;
        switch($Lang) {
            case 'ar':
                $copyname = "جميع الحقوق محفوظة";
                if($StartDate == date("Y")) {
                    $CopyRight = $copyname." &copy; ".date("Y").' <span class="clr-tertiary-300">'.$CompanyName.'</span>';
                } else {
                    $CopyRight = $copyname. '<span class="En_Font footerYears">'." &copy; ".$StartDate." - ".date("Y")
                        .'</span> <span class="clr-tertiary-300">' .$CompanyName.'</span>';
                }
                break;
            default:
                $copyname = "All Rights Reserved";
                if($StartDate == date("Y")) {
                    $CopyRight = $copyname." &copy; ".date("Y").' <span class="clr-tertiary-300">'.$CompanyName.'</span>';
                } else {
                    $CopyRight = $copyname." &copy; ".$StartDate." - ".date("Y").' <span class="clr-tertiary-300">'
                        .$CompanyName.'</span>';
                }
        }
        return $CopyRight;
    }
}
#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| #     ChangeText
if (!function_exists('ChangeText')) {
    function ChangeText($value) {
        $WebConfig = WebMainController::getWebConfig();
        $CompanyName = '<span>'.$WebConfig->name.'</span>';
        $rep1 = array("[CompanyName]","[WebSiteName]");
        $rep2 = array($CompanyName,$WebConfig->def_url);
        $value = str_replace($rep1,$rep2,$value);
        return $value;
    }
}

if (!function_exists('PrintShortDes')) {
    function PrintShortDes($row,$limit=160) {
        if($row->g_des == null){

            $value =  AdminHelper::seoDesClean($row->des,$limit);
        }else{
            $value =  $row->g_des ;
        }

        return $value;
    }
}






#@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
#|||||||||||||||||||||||||||||||||||||| # activeMenu
if (!function_exists('activeMenu')) {
    function activeMenu($pageView, $current){
        if(isset($pageView['SelMenu']) and $pageView['SelMenu'] == $current ){
            return " active ";
        }else{
            return null;
        }
    }
}
