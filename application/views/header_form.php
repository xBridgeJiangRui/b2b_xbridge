<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>B2B | Training </title>
  <link rel="icon" type="image/png" href="<?php echo base_url('asset/dist/img/rexbridge.JPG');?>">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/fontawesome-free/css/all.min.css');?>">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css');?>">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/daterangepicker/daterangepicker.css');?>">

  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css');?>">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/select2/css/select2.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');?>">

  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url('asset/plugins/summernote/summernote-bs4.min.css');?>">

  <!--Old version -->
  <!-- <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.js'); ?>"></script> -->
  <!-- <script src="<?php echo base_url('asset/modernizr.js') ?>"></script> -->
  <script src="<?php echo base_url('asset/jquery.min.js') ?>"></script>
  

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('asset/dist/css/adminlte.min.css');?>">

  <style type="text/css">
    .no-js #loader {
      display: none;
    }

    .js #loader {
      display: block;
      position: absolute;
      left: 100px;
      top: 0;
    }

    .se-pre-con {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url("<?php echo base_url('assets/loading2.gif') ?>") center no-repeat #fff;
      /*background:   #fff;*/
    }

    #highlight {
      background-color: #f8f9c7;
    }

    #highlight2 {
      background-color: #9df9a6;
    }

    #highlight3 {
      background-color: #DD4B39;
    }

    #highlight4 {
      background-color: #FFFF00;
    }

    #highlight5 {
      background-color: #B0B0B0;
    }

    @keyframes blink {
      50% {
        background-color: #fff;
      }
    }

    @media print {
      a[href]:after {
        display: none;
        visibility: hidden;
      }
    }

    @media (min-width: 768px) {
      .modal-xl {
        width: 90%;
        !important max-width: 1200px;
      }
    }

    .media:hover {
      background-color:#007bff;
      color: black;
    }

    body {
      width: 100%;
      height: 100%;
      background:none !important;
      background-image:none !important;
    }

    .btn-group-fab {
      position: fixed;
      width: 50px;
      height: auto;
      right: 20px;
      bottom: 20px;
    }

    .btn-group-fab div {
      position: relative;
      width: 100%;
      height: auto;
    }

    .btn-group-fab .btn {
      position: absolute;
      bottom: 0;
      border-radius: 50%;
      display: block;
      margin-bottom: 4px;
      width: 40px;
      height: 40px;
      margin: 4px auto;
    }

    .btn-group-fab .btn-main {
      width: 50px;
      height: 50px;
      right: 50%;
      margin-right: -25px;
      z-index: 9;
    }

    .btn-group-fab .btn-sub {
      bottom: 0;
      z-index: 8;
      right: 50%;
      margin-right: -20px;
      -webkit-transition: all 2s;
      transition: all 0.5s;
    }

    .btn-group-fab.active .btn-sub:nth-child(2) {
      bottom: 60px;
    }

    .btn-group-fab.active .btn-sub:nth-child(3) {
      bottom: 110px;
    }

    .btn-group-fab.active .btn-sub:nth-child(4) {
      bottom: 160px;
    }

    .btn-group-fab .btn-sub:nth-child(5) {
      bottom: 210px;
    }

    .pill_button {
      background-color: #222d32;
      border: none;
      color: white;
      font-weight: bold;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      margin: 4px 2px;
      border-radius: 16px;
      font-family: sans-serif;
    }

    .col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9 {
      display: flow-root;
    }

    .open-button {
      background-color: #555;
      color: white;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      opacity: 0.8;
      position: fixed;
      bottom: 23px;
      right: 28px;
      border-radius: 50px;
      z-index: 1000000;
    }

    /* The popup chat - hidden by default */
    .chat-popup {
      display: none;
      position: fixed;
      bottom: 0;
      right: 15px;
      border: 3px solid #f1f1f1;
      z-index: 1000000;
    }

    /* Add styles to the form container */
    .form-container {
      max-width: 300px;
      padding: 10px;
      background-color: white;
    }

    /* Full-width textarea */
    .form-container textarea {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      border: none;
      background: #f1f1f1;
      resize: none;
      min-height: 200px;
    }

    /* When the textarea gets focus, do something */
    .form-container textarea:focus {
      background-color: #ddd;
      outline: none;
    }

    /* Set a style for the submit/send button */
    .form-container .btn_chat {
      background-color: #4CAF50;
      color: white;
      padding: 8px 10px;
      border: none;
      cursor: pointer;
      width: 100%;
      margin-bottom: 10px;
      opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
      background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn_chat:hover,
    .open-button:hover {
      opacity: 1;
    }

    .tooltip9 {
      position: relative;
      display: inline-block;
    }

    .tooltip9 .tooltiptext {
      visibility: hidden;
      width: 200px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;

      /* Position the tooltip */
      position: absolute;
      z-index: 1000000;
    }

    .tooltip9:hover .tooltiptext {
      visibility: visible;
    }

    /* -- Force the design follow below (SVG Problem) --*/
    .was-validated .custom-select:invalid, .custom-select.is-invalid {
      background:none !important;
    }

    .was-validated .custom-select:valid, .custom-select.is-valid {
      background:none !important;
    }

    .custom-select {
      background:none !important;
    }

  </style>

  <script type="text/javascript">
    $(window).load(function() {
      // Animate loader off screen
      $(".se-pre-con").fadeOut("slow");
    });
  </script>

</head>

<body class="layout-top-nav" style="height: auto;"></body>
    

