<?php
session_start();
include_once('classes/clients.php');
$clients = new clients();
$clientsInfo = $clients->fetchAllClients();
$allSkills = $clients->fetchAllSkills();
//print_r($allSkills);
//foreach ($clientsInfo as $key => $val){
//    print_r($val['Name']);
//
//}
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
        <?php
            if($clientsInfo){
                count($clientsInfo);
                echo '<div class="search_employees_subTxt">There are '.count($clientsInfo).' employees.</div>';
            }else{
                echo '<div class="search_employees_subTxt">No Employees</div>';
            }
        ?>

    </div>
    <div class="search_employees_wrapper">
        <div><input class="genInputField" id="text_search" type="text" placeholder="Search"> </div>
        <div class="filter_wrapper">
            <select id="filter" class="genSelect">
                <option value="dob">Date of Birth</option>
                <?php
                if($allSkills){
                    foreach ($allSkills as $key => $val){
                        echo '<option value="'.$val['Skill'].'">'.$val['Skill'].'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="searchSkillBtn">Search</div>
    </div>
    <div class="add_employees_wrapper">
        <div class="addEmployeesBtn"><img src="images/addIEmployee.svg" width="30"></div>
        <div class="addEmployeesTxt">New Employee</div>
    </div>
</div>
<div class="displayClientSearchRes">
    <?php

        if ($clientsInfo){
            $clientCount = 1;
            foreach ($clientsInfo as $clientID => $val){
                echo '<div class="clientDisplay_wrapper" data-clientid="'.$clientID.'" >
                            <div class="clientCount">'.$clientCount++.'</div>
                            <div>'.$val['Name'].'</div>
                            <div>'.$val['Surname'].'</div>
                            <div>'.$val['Number'].'</div>
    
                      </div>';
            }
        }else{
            echo '<div class="no_resultsWrapper">
            <div><img src="images/Icon.JPG"></div>
            <div class="no_resul_paragraph1">There is nothing here</div>
            <div>Create a new employee bt clicking the</div>
            <div><strong>New employee</strong> button to get started</div>
            </div>';
        }


    ?>
</div>
<div id="addEmployeeRes_wrapper"><div id="addEmployeeRes"><?php echo clients::clientFormDisplay(); ?></div></div>

<script src="jslib/jquery-3.3.1.min.js"></script>
<script src="jsscript/search.js"></script>
<script src="jsscript/addEmployee.js"></script>

</body>


</html>