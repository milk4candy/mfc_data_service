#! /usr/bin/php

<?php
    // Load API
    require(dirname(__DIR__).DIRECTORY_SEPARATOR."api".DIRECTORY_SEPARATOR."mfc_data_service.php");

    // Create a data service obj
    $service = new mfc_data_service();

    // Set service URL and authetication infomation
    $service->set_url("http://mfc.cwb.gov.tw/index.php/ctrl_web_service/regular_product_service/506/num_now_3/rsort_by_filename");
    $service->set_basic_authorization("username", "password");

    // Fetch data and print it out
    $service->fetch_file_list();

    // Download files to local directory
    $service->save_file("/tmp/test");

    exit();
