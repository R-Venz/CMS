<?php  
  $t = "- Login";
  if (isset($title)) {
    $t = "- " . $title;
  }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CMS <?=$t?></title>

    <link rel="shortcut icon" type="x-icon" href="../assets/images/logo.png">

    <link type="text/css" href="<?php echo web_root; ?>assets/css/vendor-morris.css" rel="stylesheet">
    <link type="text/css" href="<?php echo web_root; ?>assets/css/vendor-bootstrap-datepicker.css" rel="stylesheet">

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- App CSS -->
    <link type="text/css" href="<?php echo web_root; ?>assets/css/app.css" rel="stylesheet">
    <link type="text/css" href="<?php echo web_root; ?>assets/css/app.rtl.css" rel="stylesheet">
    <!-- switches -->
    <link type="text/css" href="<?php echo web_root; ?>assets/css/vendor-bootstrap-switch.css" rel="stylesheet">

    <!-- Simplebar -->
    <link type="text/css" href="<?php echo web_root; ?>assets/vendor/simplebar.css" rel="stylesheet">
    <style type="text/css">
      .modal-backdrop {
        z-index: -1 !important;
        display: none;
      }
      .modal {
        position: fixed!important;
        top: 70px!important;
      }
    </style>
</head>
