<?php 
    require_once("../include/Initialize.php");
    if (!isset($_SESSION['CMS_secretary_id'])){
        redirect("Login.php");
    } 
    $title = "Error";
    $content='Page/dashboard.php';
    $pageSeq = 1;
    $designation = '';
    $designation = $_SESSION['CMS_secretary_role'];
    $p = isset($_GET['p']) ? $_GET['p'] : 1;
    $view = (isset($p) && $p != '') ? $p : '';
    if ($designation==="Secretary") {
        switch ($view) {
            case '1' :
                $title="Dashboard";  
                $content='page/dashboard.php';
                break;
            case '2' :
                $title="Manage Member";  
                $content='page/member.php';
                break;
            case '3' :
                $title="Death Record";  
                $content='page/death.php';
                break;
            case 'account' :
                $title="Manage Account";  
                $content='page/account.php';
                break;
            case 'logout' :     
                unset($_SESSION['CMS_secretary_id']);
                unset($_SESSION['CMS_secretary_fname']);
                unset($_SESSION['CMS_secretary_lname']);
                unset($_SESSION['CMS_secretary_role']);
                unset($_SESSION['CMS_secretary_uname']);
                unset($_SESSION['CMS_secretary_status']);
                header('location:'.web_root.'secretary/Login.php');
                break;
            default :
                $title="Dashboard";  
                $content='../errorpage/404.php';
        }
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

    // get remaining balance contribution-release
    $balance = $dash->getBalance()->balance;

    // contribution sa settings
    $contribution   = $dash->getContribution()->contribution;
    // total member
    $totalmembers   = $dash->getTotalMembers('Active')->total;

    $pending        = $dash->getTotalMembers('Pending')->total;
    $inActive        = $dash->getTotalMembers('Inactive')->total;

    $totalDeceasedClosed  = $dash->getTotalDeceased('Closed')->total;
    $totalDeceasedPending  = $dash->getTotalDeceased('Pending')->total;
    $totalDeceasedPosted  = $dash->getTotalDeceased('Posted')->total;
    $totalDeceased = ($totalDeceasedClosed+$totalDeceasedPending+$totalDeceasedPosted);
    // total collectible member * contribution
    $collectible = ($contribution * $totalmembers);


    require_once("theme/template.php");
?>