<?php
session_start();
include_once('classes/clients.php');
$clients = new clients();
$clientsInfo = $clients->fetchAllClients();
$allSkills = $clients->fetchAllSkillsForDropDown();
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
                echo '<div class="search_employees_subTxt">There are <span id="employeeCount"> '.count($clientsInfo).' </span> employees.</div>';
            }else{
                echo '<div class="search_employees_subTxt">No Employees</div>';
            }
        ?>

    </div>
    <div class="search_employees_wrapper">
        <div><input class="genInputField" id="text_search" type="text" placeholder="Search"> </div>
        <div class="filter_wrapper">
            <select id="filter" class="genSelect"  >
                <option value="">Filter</option>
                <option value="dob">date of birth</option>
                <option value="skill">Skill</option>
                <?php
                if($allSkills){
                    foreach ($allSkills as $key => $val){
                        echo '<option value="'.$val['Skill'].'">'.strtolower($val['Skill']).'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="searchSkillBtn">Search</div>
    </div>
    <div class="add_employees_wrapper">
        <div class="addEmployeesBtn"><img class="addBtnImg" src="images/addEmployee.svg" width="30"></div>
        <div class="addEmployeesTxt">New Employee</div>
    </div>
</div>
<div class="displayClientSearchRes">
    <?php
        if ($clientsInfo){
            $clientCount = 1;
            foreach ($clientsInfo as $clientID => $val){
                echo '<div class="clientDisplay_wrapper_wrap"><div class="clientDisplay_wrapper" data-clientid="'.$clientID.'" >
                            <div class="clientCount">'.$clientCount++.'</div>
                            <div>'.$val['Name'].'</div>
                            <div>'.$val['Surname'].'</div>
                            <div>'.$val['Number'].'</div>
                      </div></div>';
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
<div id="addEmployeeRes_wrapper"><div id="addEmployeeRes"></div></div>

<script src="jslib/jquery-3.3.1.min.js"></script>
<script>
    $(function () {

        $('.add_employees_wrapper').on('click', function (e) {
            e.preventDefault();
            $('#addEmployeeRes_wrapper').toggle();
            if($('#addEmployeeRes_wrapper').is(':visible')){
                displayClientFormRequestCheck();
                $('.addEmployeesTxt').text('Close');
                $('.addBtnImg').attr('src', 'images/remove.svg');
                $('.filter_wrapper').trigger('focus');
            }else{

                $('.addEmployeesTxt').text('New Employee');
                $('.addBtnImg').attr('src', 'images/addEmployee.svg');
            }
        });

        var displayClientFormRequest = false;
        function displayClientFormRequestCheck(){
            if(displayClientFormRequest && displayClientFormRequest.readyState !== 4){
                displayClientFormRequest.abort();
            }
            displayClientFormRequest = displayClientFormRequestRun();
        }

        function displayClientFormRequestRun(){
            var elemRes =  $('#addEmployeeRes');
            var displayClientFormRequest = $.ajax({
                cache: false,
                url: 'clients.ajax.php?displayClientForm=1&hk=<?php echo password_hash('displayClientForm', PASSWORD_DEFAULT); ?>',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                beforeSend: function(){
                    elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Submitting...</div>');
                },
                error: function(){
                    elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Failed to submit.</div>');
                },
                success: function(data){
                    if(data){
                        elemRes.html(data);
                    }else{
                        elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Could not submit. '+data+'</div>');
                    }
                }
            });
            return displayClientFormRequest;
        }
        $('body').on('click', '.clientDisplay_wrapper', function (e){
            if($('#addEmployeeRes_wrapper').is(':visible')){
                $('#addEmployeeRes_wrapper').hide();
                $('.addEmployeesTxt').text('New Employee');
                $('.addBtnImg').attr('src', 'images/addEmployee.svg');
            }else{
                $('#addEmployeeRes_wrapper').show();

                $('.addEmployeesTxt').text('Close');
                $('.addBtnImg').attr('src', 'images/remove.svg');
                editClientFormRequestCheck($(this).data('clientid'));
            }
        });
        var editClientFormRequest = false;
        function editClientFormRequestCheck(clientID){
            if(editClientFormRequest && editClientFormRequest.readyState !== 4){
                editClientFormRequest.abort();
            }
            editClientFormRequest = editClientFormRequestRun(clientID);
        }

        function editClientFormRequestRun(clientID){
            var elemRes =  $('#addEmployeeRes');
            var editClientFormRequest = $.ajax({
                cache: false,
                url: 'clients.ajax.php?editClientForm=1&clientID='+clientID+'&hk=<?php echo password_hash('editClientForm', PASSWORD_DEFAULT); ?>',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                beforeSend: function(){
                    elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Submitting...</div>');
                },
                error: function(){
                    elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Failed to submit.</div>');
                },
                success: function(data){
                    if(data){
                        elemRes.html(data);
                    }else{
                        elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Could not submit. '+data+'</div>');
                    }
                }
            });
            return editClientFormRequest;
        }

        $('.searchSkillBtn').on('click', function (e) {
            if($('#text_search').val() && $('#filter').val()){
                searchClientRequestCheck($('#text_search').val(),  $('#filter').val())
            }else if(!$('#text_search').val()) {
                alert('Please Select a search term');
            }else if(!$('#filter').val()){
                alert('Please Select a filter');
            }
        });


        var searchClientRequest = false;
        function searchClientRequestCheck(searchTerm, filter){
            if(editClientFormRequest && searchClientRequest.readyState !== 4){
                searchClientRequest.abort();
            }
            searchClientRequest = searchClientRequestRun(searchTerm, filter);
        }

        function searchClientRequestRun(searchTerm, filter){
            var elemRes =  $('.displayClientSearchRes');
            var searchClientRequest = $.ajax({
                cache: false,
                url: 'clients.ajax.php?searchClient=1&searchTerm='+searchTerm+'&filter='+filter+'&hk=<?php echo password_hash('searchClient', PASSWORD_DEFAULT); ?>',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                beforeSend: function(){
                    elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Submitting...</div>');
                },
                error: function(){
                    elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Failed to submit.</div>');
                },
                success: function(data){
                    if(data){
                        var dataJSON = JSON.parse(data);
                        elemRes.html(dataJSON['content']);
                        $('#employeeCount').html(dataJSON['count']);
                    }else{
                        elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Could not submit. '+data+'</div>');
                    }
                }
            });
            return searchClientRequest;
        }


    });
</script>
</body>


</html>