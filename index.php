<?php
session_start();
include_once('classes/clients.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sa Software</title>
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/addEmployeeForm.css">
</head>

<body>
<div class="search_wrapper">
    <div class="search_employees_wrapper_Txt">
        <div class="search_employees_Title">Employees</div>
        <div class="search_employees_subTxt">No Employees</div>
    </div>
<!--    // TODO Make this into a function-->
    <div class="search_employees_wrapper">
        <div><input class="genInputField" id="text_search" type="text" placeholder="Search"> </div>
        <div class="filter_wrapper">
            <select id="filter" class="genSelect">
                <option>Date of Birth</option>
                <option>Skills</option>
<!--                TODO Add skill here when i add te DB-->
            </select>
        </div>
        <div class="searchSkillBtn">Search</div>
    </div>
    <div class="add_employees_wrapper">
        <div class="addEmployeesBtn"><img src="images/addIEmployee.svg" width="30"></div>
        <div class="addEmployeesTxt">New Employee</div>
    </div>
</div>
<div class="no_resultsWrapper">
    <div><img src="images/Icon.JPG"></div>
    <div class="no_resul_paragraph1">There is nothing here</div>
    <div>Create a new employee bt clicking the</div>
    <div><strong>New employee</strong> button to get started</div>
</div>
<div id="addEmployeeRes_wrapper"><div id="addEmployeeRes"><?php echo clients::clientFormDisplay(); ?></div></div>

<script src="jslib/jquery-3.3.1.min.js"></script>
<script src="jsscript/search.js"></script>
<script src="jsscript/addEmployee.js"></script>

</body>


</html>