<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- site metas -->
      <title class="title">Meedo Water System</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      
      <!-- site icon -->
      <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAnagAAZwAHABRCAAAnYAcASwYGAPv/+QA3ZwAAYggDAP78/wAbTgIA//z/AP38+AApagYAI1kAACFmAAD1+PIALy8vAPv//wAEBAQA8//qAPb29gD+//8A////APz/+AAnbAEA9//+APn//gD6//4ATQgAAChpAAASTgAAO0YTAPr6+gAePQgA/v/9AEAnKgD6+/4AImgHAJ2dnQD8/PwAUgUFACBPBAAoaQUAMQcFAPr//ADBwcEA/P7+AP7+/gD//v4AH1AIAClsBQAjaQQA+vv2AF0DAgAnaQQAJWcBAFkFBAD+//sAES0EAP//+wD+/f8A7f3wACdqAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAFhYWFhYWFhYWFhYWFhYWFhYWFgEWIAEWFgEWFgEWFhYWFhYWAQEWAQEWAQEvFhYWFhYULRYBCwEBNAEWEBYWFhYWJhYBARYrARYBARYSFhYWFi8BAQEWAQEWKCMBJxYWFhYWLhkBFQEBEQEaMBYWFhY8OgkpATYBATYBMQI6ORYWOgYBNgcfAQE2ATYBNjoWFjoDNQE4NgEBDQQBAQw6FhY6KjYBNhwBAQEeATYYIRYWFzoOJQE2AQE2ATMyOgUWFgoPOjo2Nh03PgA6OiQ7FhYWIiwbOjo2Njo6CDwWFhYWFhYWFjw9OjoTPBYWFhYWFhYWFhYWFhYWFhYWFhYWFgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=" rel="icon" type="image/x-icon">
    
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('pluto/css/bootstrap.min.css') }}" />
      <!-- site css -->
      <link rel="stylesheet" href="{{ asset('pluto/style.css') }}" />
      <!-- responsive css -->
      <link rel="stylesheet" href="{{ asset('pluto/css/responsive.css') }}" />
      <!-- color css -->
      <link rel="stylesheet" href="{{ asset('pluto/css/colors.css') }}" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="{{ asset('pluto/css/bootstrap-select.css') }}" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="{{ asset('pluto/css/perfect-scrollbar.css') }}" />
      <!-- custom css -->
      <link rel="stylesheet" href="{{ asset('pluto/css/custom.css') }}" />
      <!-- fontawesome icon -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
      {{-- <link rel="stylesheet" href="{{ asset('pluto/css/addCss/font-awesome.all.min.css') }}"> --}}
      
      {{-- DATATABLES --}}
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
      {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.1/css/buttons.dataTables.min.css"> --}}
      <link rel="stylesheet" type="text/css" href="{{ asset('pluto/css/addCss/1.11.5-jquery.dataTables.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('pluto/css/addCss/2.1.1-buttons.dataTables.min.css') }}">
      <style>


         .dataTables_wrapper {
            padding:10px;
         }
         .btn{
            transition: transform 0.3s;
         }
         .enlarge-on-hover:hover {
            transform: scale(1.1); 
         }
         .btn-copy {
            background-color: #337ab7 !important; 
            border-color: #2e6da4 !important; 
            color: #ffffff !important; 
         }

         .btn-csv {
            background-color: #f05619 !important; 
            border-color: #97320a !important;
            color: #ffffff !important;
         }

         .btn-print {
            background-color: #6c757d !important; 
            border-color: #454b50 !important;
            color: #ffffff !important;
         }
         .btn-excel {
            background-color: green !important; 
            border-color: rgb(0, 99, 0) !important;
            color: #ffffff !important;
         }
         .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
            color: #333;
            margin-bottom: 10px;
            margin-top: -10px;
         }

         div.dt-buttons {
            margin-bottom: 10px;
            margin-top: -10px;
         }
         .dataTables_wrapper .dataTables_paginate, .dataTables_wrapper .dataTables_info {
            margin-top: 10px;
         }
         table.dataTable {
            border-collapse: collapse !important;
         }
         table.dataTable.no-footer {
            border-bottom: 1px solid #dee2e6;
         }
         .table-bordered {
            border: 1px #dee2e6 !important;
         }
         .custom-file-input {
            display: none;
         }
         .custom-file-label {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s, box-shadow 0.2s;
            top: 25px !important;
            left: 15px !important;
            margin-right: 15px;
         }
         .custom-file-label:hover {
            background-color: #f1f1f1;
         }
         .custom-input-width {
            width: 100%; 
         }
         .clickable-image {
            cursor: pointer;
         }

         .table-image {
            max-width: 100px; 
            height: auto;
         }
         .table thead th{
            color: black;
            font-weight: bold !important;
            }

         .table td {
            color: black;
         }
         .prof-label{
            color: black;
         }
         .prof-border:hover{
            border: 1px green solid;
         }
         .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
         }
         #sidebar ul li a:hover {
            cursor: pointer;
            background-color:white;
            color:black;
         }
         
         .dataTable .action-column {
            white-space: nowrap;
            width: 110px !important;
         }

         .dataTable .action-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
         }
         .input-error {
            border-color: red !important; 
         }
         .is-invalid{
            margin-bottom: 10px;
         }
         .input-default {
            border-color: #d9d8d9;
         }
         .topbar {
            z-index: 3;
         }
         .text-wrap {
            white-space: normal;
            word-wrap: break-word;
         }
         .image-container {
            width: 80px; 
            height: 80px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
         }

         .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
         }
         .dataTables_info {
            font-size: 14px;
            color: #333;
            margin-top: 10px;
         }
         .dataTables_paginate {
            font-size: 14px;
            margin-top: 10px;
         }

         .dataTables_paginate a {
            display: inline-block;
            padding: 6px 12px;
            margin-right: 5px;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-decoration: none;
            background-color: #fff;
         }

         .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #393d42 !important;
            color: #fff !important;
            border-color: #121a23 !important;
         }

         .dataTables_paginate a:hover {
            background: #3f453f !important;
            color: white !important;
            border-color: #252b25 !important;
         }

         .list-unstyled.components li.active {
            background-color: #009688 !important; 
            width:90%;
            margin-left: 4%;
            border-radius: 5px;
         }
         #sidebar.active .list-unstyled.components li.active a {
            background-color: #009688; 
            border-radius: 5px;
         }
      </style>
      <style>
       
         .connected-status {
            background: linear-gradient(195deg,#66bb6a,#43a047);
            font-family: Roboto,Helvetica,Arial,sans-serif;
            text-transform: uppercase;
            border: 1px solid #43a047;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 15px;
            padding-right:15px; 
            font-size: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
           
         }

         .disconnected-status {
            background: rgb(202, 16, 16);
            font-family: Roboto,Helvetica,Arial,sans-serif;
            text-transform: uppercase;
            border: 1px solid rgb(202, 16, 16);
            border-radius: 10px;
            color: white;
            font-weight: 500;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right:8px;
            font-size: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         }
         .reconnected-status {
            background: linear-gradient(195deg,#42aad3,#42aad3);
            font-family: Roboto,Helvetica,Arial,sans-serif;
            text-transform: uppercase;
            border: 1px solid #42aad3;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 10px;
            padding-right:10px; 
            font-size: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         }

         .unknown-status {
            background: gray;
            font-family: Roboto,Helvetica,Arial,sans-serif;
            text-transform: uppercase;
            border: 1px solid gray;
            border-radius: 10px;
            color: white;
            font-weight: 500;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 20px;
            padding-right:20px;
            font-size: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         }
         .user-avatar {
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            margin-right: 10px; 
         }

         #user-list-container {
            list-style: none;
            padding: 0;
            margin: 0;
         }

         .container{
            padding: 0 0px !important;
            width: 100% !important;
         }

         .user-list-item {
            display: block;
            padding: 10px;
            cursor: pointer;
         }
         .user-list-item:hover {
            display: block;
            padding: 10px;
            cursor: pointer;
            background-color: #bac0d1;
            color: black;
         }

         .message-form {
            display: none;
         }
         .modal-header{
            background-color: #007bff;
           
         }
         .modal-title{
            color:white;
         }
      
         .user-avatar-header {
            width: 30px; 
            height: 30px; 
            margin-right: 10px; 
            border-radius: 50%; 
         }

        
         .search-bar {
         display: flex;
         align-items: center;
         padding: 10px;
         background-color: #5e616a;
         }

         #search-input {
         flex: 1;
         padding: 5px;
         border: 1px solid #bac0d1;
         background-color: #bac0d1;
         color:black;
         border-radius: 5px;
         }

         .search-icon {
            position: absolute;
            top: 6.5%;
            right: 20px;
            transform: translateY(-50%);
            color: black; 
            cursor: pointer;
         }
 

         body {
               cursor: url('cursor-pointer.png') 16 16, auto;
               overflow: hidden; 
            }

            .cursor-wave {
               position: absolute;
               width: 100px;
               height: 100px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.1);
               transform: translate(-50%, -50%) scale(0);
               animation: wave-animation 0.6s ease-out;
               pointer-events: none;
               z-index: 9999;
            }

            @keyframes ripple-animation {
               to {
                  transform: translate(-50%, -50%) scale(1);
                  opacity: 4;
               }
            }

         .action-button {
            position: relative;
            overflow: hidden;
            transition: transform 0.3s; 
         }

         .action-button:hover {
            transform: scale(1.4); 
         }

         .action-text {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%); 
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px;
            font-size: 12px;
            border-radius: 3px;
            white-space: nowrap;
            transition: transform 0.3s, opacity 0.3s;
            transform-origin: left center;
            opacity: 0;
         }

         .action-button:hover .action-text {
            transform: translateX(-100%) translateY(-50%);
            opacity: 1;
         }
         .header-table{
            color: white !important; 
            text-align:center;
         }
     </style>

     <style>
      .close:not(:disabled):not(.disabled) {
         font-size: 35px !important;
         color: white !important;
      }
      #addCustomerLabel, #editLabel, #addEmployeeLabel, #editCustomerLabel, #exampleModalLabel, #editCategoryLabel, #addCategoryLabel{
         font-size: 20px !important;
         margin-left: 15px;
      }

      .upload-image-btn{
         width: 15% !important;
         font-size: 25px !important;
         position: absolute;
         top: 170px;
         right: 100px;
      }

      #AdminModal {
         position: fixed;
         top: 50%; 
         left: 50%; 
         transform: translate(-50%, -50%);
         overflow-y: hidden;
         z-index: 9999; 
      }
      .center-content {
         display: flex !important;
         flex-direction: column !important;
         align-items: center !important;
         justify-content: center !important;
         height: 100% !important;
      }
      .back-arrow i {
         transition: transform 0.3s ease;
      }
      .back-arrow:hover i {
         transform: scale(1.2); 
         color: yellow;
      }
      .input-wrapper {
         display: flex;
         align-items: center;
      }

         .peso-sign {
         margin-right: 5px; 
         font-size: 18px; 
         color: #000; 
      }
      .dash{
         margin: 0 10px;
         vertical-align: middle;
      }
      .meterInputs{
         display: inline-flex; 
         align-items: center;
      }
      label{
         color:black;
      }
      .tab1:hover{
         color:black;
         font-size: 16px;
      }
      .tab2{
         font-weight:bold;
         color:black;
         cursor:auto;
         font-size:16px;
         text-decoration: underline !important;
      }
      hr{
         border-color: #000000; 
         border-width: 0.5px;
         /* margin: 20px auto;  */
      }
     </style>
      
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="dashboard dashboard_1">