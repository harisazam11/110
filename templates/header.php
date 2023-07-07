<?php

include("./classes/config.php");

?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./css/style.css" />
  
  <style>
    /* Styles for the tabs */
    .tab {
      display: none;
    }
    
    /* Styles for the tab buttons */
    .tab-button {
      background-color: #ffffff;
      border: none;
      color: #000;
      padding: 10px 20px;
      cursor: pointer;
    }
    
    /* Active tab button */
    .tab-button.active {
      background-color: #d3dcdc;
    }
    
    /* Styles for the tab content */
    .tab-content {
      display: none;
      padding: 20px;
      border: 1px solid #d3dcdc;
    }
    
    /* Show active tab content */
    .tab-content.active {
        width:80%;
      display: block;
    }
  </style>
  <title>Project</title>
</head>

