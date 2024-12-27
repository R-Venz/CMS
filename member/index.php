<?php 
    require_once("../include/Initialize.php");
    if (!isset($_SESSION['CMS_member_id'])){
        redirect("Login.php");
    } 
    $title = "Error";
    $content='Page/dashboard.php';
    $pageSeq = 1;
    $designation = '';
    $p = isset($_GET['p']) ? $_GET['p'] : 1;
    $view = (isset($p) && $p != '') ? $p : '';
    switch ($view) {
        case '1' :
            $title="Dashboard";  
            $content='page/dashboard.php';
            break;
        case '2' :
            $title="Manage Member";  
            $content='page/member.php';
            break;
        case '4' :
            $title="Death Record";  
            $content='page/death.php';
            break;
        case '4' :
            $title="Membership Report";  
            $content='page/record.php';
            break;
        case 'account' :
            $title="Manage Account";  
            $content='page/account.php';
            break;
        case 'logout' :     
            unset($_SESSION['CMS_member_id']);
            unset($_SESSION['CMS_member_fname']);
            unset($_SESSION['CMS_member_lname']);
            unset($_SESSION['CMS_member_uname']);
            unset($_SESSION['CMS_member_status']);
            header('location:'.web_root.'member/Login.php');
            break;
        default :
            $title="Dashboard";  
            $content='../errorpage/404.php';
    }
    $dash = new Dashboard();
    $balance        = 0;
    $contribution   = 0;
    $totalmembers   = 0;
    $collectible    = 0;
    $pending        = 0;
    $inActive       = 0;
    $totalDeceased  = 0;
    $totalDeceasedClosed  = 0;
    $totalDeceasedPending  = 0;
    $totalDeceasedPosted  = 0;
    $totalForDeactivation  = 0;
    $unpaid  = 0;

    // get remaining balance contribution-release
    $balance = $dash->getMyBalance(base64_decode($_SESSION['CMS_member_id']))->total;

    $unpaid = $dash->getTotalUnpaid(base64_decode($_SESSION['CMS_member_id']))->total;

    // contribution sa settings
    $contribution   = $dash->getContribution()->contribution;
    // total member
    $totalmembers   = $dash->getTotalFamilyMembers(base64_decode($_SESSION['CMS_member_id']))->total;

    $pending        = $dash->getTotalMembers('Pending')->total;
    $inActive        = $dash->getTotalMembers('Inactive')->total;

    $totalDeceasedClosed  = $dash->getTotalDeceased('Closed')->total;
    $totalDeceasedPending  = $dash->getTotalDeceased('Pending')->total;
    $totalDeceasedPosted  = $dash->getTotalDeceased('Posted')->total;
    $totalDeceased = ($totalDeceasedClosed+$totalDeceasedPending+$totalDeceasedPosted);
    $totalForDeactivation  = $dash->getTotalForDeactivation()->total;
    // total collectible member * contribution
    $collectible = ($contribution * $totalmembers);


    require_once("theme/template.php");
?>