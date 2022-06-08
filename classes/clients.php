<?php

// DB connection variables
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sasoft';
// DB connection string



if(!isset($GLOBALS['DBSasoft'])){
    $GLOBALS['DBSasoft'] = new mysqli($servername, $username, $password, $dbname);
}

if( $GLOBALS['DBSasoft']->connect_error){
    die('Connection failed'.  $GLOBALS['DBSasoft']->connect_error);
}

class clients
{
    /**
     * displays a generic client form
     * @return string
     */
    public function clientFormDisplay($clientID = null):string{
        $clientInfo = null;
        // existing client
        if(isset($clientID) && $clientID){
            $clientInfo = $this->fetchAllClients($clientID);
        }
        ob_start();
        ?>
        <form id="ClientInfo" name="ClientInfo" method="POST" autocomplete="off"  action=" " >
            <?php if(isset($clientID) && $clientID){
                echo '<input id="clientID" type="hidden" name="ClientInfo[clientID]" value="'.$clientID.'">' ;
                echo '<h1 class="title">Update Employee</h1>';
            }else{
                echo '<h1 class="title">New Employee</h1>';
            }

            ?>
            <h4>Basic Info</h4>
            <div class="gen_wrapper">
                <div>
                <div class="sub_title">Name</div>
                <div><input class="genInputField" id="name" type="text" name="ClientInfo[name]" placeholder="Name" value="<?php echo $clientInfo[$clientID]['Name'] ?? '' ?>" required > </div>
                </div>
                <div>
                <div class="sub_title">Surname</div>
                <div><input class="genInputField" id="surname" type="text" name="ClientInfo[surname]" placeholder="Surname" value="<?php echo $clientInfo[$clientID]['Surname'] ?? '' ?>" required > </div>
                </div>
            </div>
            <div class="sub_title">Contact Number</div>
            <div><input class="genInputField" id="tel" type="number" name="ClientInfo[number]"  placeholder="0813367987 or 0333915315" pattern="[0-9]{10}" value="<?php echo $clientInfo[$clientID]['Number'] ?? '' ?>"    required ></div>

            <div class="sub_title">Email Address</div>
            <div><input class="genInputField" id="email" type="email" name="ClientInfo[email]"  placeholder="Email Address" value="<?php echo $clientInfo[$clientID]['Email'] ?? '' ?>" required ></div>

            <div class="sub_title">Date Of Birth</div>
            <div><input class="genInputField" id="dob" type="date" name="ClientInfo[dob]"  value="<?php echo $clientInfo[$clientID]['DOB'] ?? '' ?>" required></div>
            <h4>Address Info</h4>
            <div class="sub_title">Street Address</div>
            <div><input class="genInputField" id="streetAddress" type="text" name="ClientInfo[streetAddress]" placeholder="Street Address" value="<?php echo $clientInfo[$clientID]['StreetAddress'] ?? '' ?>" required ></div>
            <div class="gen_wrapper">
                <div>
                    <div class="sub_title">City</div>
                    <div><input class="genInputField" id="city" type="text" name="ClientInfo[city]" placeholder="City" value="<?php echo $clientInfo[$clientID]['City'] ?? '' ?>" required ></div>
                </div>
                <div>
                    <div class="sub_title">Postal Code</div>
                    <div><input class="genInputField" id="postalCode" type="number" name="ClientInfo[postalCode]" placeholder="Postal Code" value="<?php echo $clientInfo[$clientID]['PostalCode'] ?? '' ?>" required ></div>
                </div>
                <div>
                    <div class="sub_title">Country</div>
                    <div><input class="genInputField" id="country" type="text" name="ClientInfo[country]" placeholder="Country" value="<?php echo $clientInfo[$clientID]['Country'] ?? '' ?>" required ></div>
                </div>
            </div>
            <h4>Skills</h4>
            <?php
            if(isset($clientInfo[$clientID]['Skills']) && $clientInfo[$clientID]['Skills']){
                $count = 0;
            foreach ($clientInfo[$clientID]['Skills'] as $skillID => $skillInfo){
                $count++;
            ?>
            <div class="gen_wrapper skillsRow" >
                <div>
                    <div class="sub_title">Skill</div>
                    <div><input class="genInputField" id="skill" type="text" name="ClientInfo[skill][]" placeholder="Skill" value="<?php echo $skillInfo['Skill'] ?? '' ?>" required ></div>
                </div>
                <div>
                    <div class="sub_title">Yrs Exp</div>
                    <div><input class="genInputField" id="exp" type="text" name="ClientInfo[exp][]" placeholder="Yrs Exp" value="<?php echo $skillInfo['Exp'] ?? '' ?>" required ></div>
                </div>
                <div>
                    <div class="sub_title">Seniority Rating</div>
                    <div class="selectBtn_wrapper">
                        <select class="genSelect"  name="ClientInfo[rating][]" id="rating" required >
                            <option value="Beginner" <?php  if(isset($skillInfo['Rating']) && $skillInfo['Rating'] == 'Beginner'){ echo 'selected'; }?> >Beginner</option>
                            <option value="Intermediate" <?php  if(isset($skillInfo['Rating']) && $skillInfo['Rating'] == 'Intermediate' ){ echo 'selected'; }?> >Intermediate</option>
                            <option value="Expert" <?php  if(isset($skillInfo['Rating']) && $skillInfo['Rating'] == 'Expert'){ echo 'selected'; }?> >Expert</option>
                        </select>
                        <?php if($count > 1 ){ ?>
                            <div class="removeSkillBtn">
                               <div><img src="images/remove.svg" width="30" ></div>
                            </div>
                       <?php } ?>
                    </div>
                </div>
            </div>
            <?php }} ?>
            <div class="skillsRes"></div>
            <div class="skillBtn_wrapper">
                <div class="skillBtn"><img src="images/addEmployee.svg" width="20"></div>
                <div class="skillTxt">Add New Skill</div>
            </div>
            <div class="<?php if(isset($clientID) && $clientID) { echo 'employeesFormBtnUpdate_wrapper'; }else{ echo 'employeesFormBtn_wrapper';}  ?> ">
                <div class="<?php if(isset($clientID) && $clientID) { echo 'employeesUpdateBtn'; }else{ echo 'employeesBtn';}  ?>"><img src="images/addEmployee.svg" width="30"></div>

                <div class="employeesTxt"> <?php if(isset($clientID) && $clientID) { echo ' Update Employee'; }else{ echo ' Save & Add Employees';}  ?></div>
            </div>

            <?php  if(isset($clientID) && $clientID){ ?>
                <div class="deleteEmployeeBtn_wrapper ">
                    <div class="employeesDeleteBtn"><img src="images/remove.svg" width="30"></div>

                    <div class="employeesTxt">Delete Employee</div>
                </div>
            <?php } ?>
            <div class="deleteDialogRes">
                <div class="deleteQuestion">Are You Sure you want to delete this employee?</div>
                <div class="deleteBtn_wrapper">
                    <div class="confirmDeleteYes">Yes</div>
                    <div class="cancelDelete">No</div>
                </div>
            </div>
            <input id="ClientInfoBtn" name="ClientInfo[save]" type="submit" >
            <div class="formRes">
        </form>
        <script src="jslib/jquery-3.3.1.min.js"></script>
        <script src="jsscript/addEmployee.js"></script>

        <script>
            $(function () {
                // form validity check
                function displayClientErrors(){
                    $('.formRes ').html('');
                    var validForm = true;
                    $('#ClientInfo').find(":invalid" ).each(function(index, node){

                        if(node.id === 'name'){
                            $('.formRes ').append('<div style="margin: 4px;background: red;border-radius: 6px; padding: 6px;">Please enter valid name</div>');
                            validForm = false;
                        }
                        if(node.id === 'surname'){
                            $('.formRes ').append('<div style="margin: 4px;background: red;border-radius: 6px; padding: 6px;">Please enter valid surname</div>');
                            validForm = false;
                        }
                        if(node.id === 'number'){
                            $('.formRes ').append('<div style="margin: 4px;background: red;border-radius: 6px; padding: 6px;">Please enter valid number</div>');
                            validForm = false;
                        }
                        if(node.id === 'email'){
                            $('.formRes ').append('<div style="margin: 4px;background: red;border-radius: 6px; padding: 6px;">Please enter valid email</div>');
                            validForm = false;
                        }
                        if(node.id === 'dob'){
                            $('.formRes ').append('<div style="margin: 4px;background: red;border-radius: 6px; padding: 6px;">Please enter valid date of birth</div>');
                            validForm = false;
                        }
                        if(node.id === 'streetAddress'){
                            $('.formRes ').append('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Please enter valid street address</div>');
                            validForm = false;
                        }
                        if(node.id === 'postalCode'){
                            $('.formRes ').append('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Please enter valid postal code</div>');
                            validForm = false;
                        }
                        if(node.id === 'country'){
                            $('.formRes ').append('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Please enter valid country</div>');
                            validForm = false;
                        }
                        if(node.id === 'skill'){
                            $('.formRes ').append('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Please enter valid skill</div>');
                            validForm = false;
                        }
                        if(node.id === 'exp'){
                            $('.formRes ').append('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Please enter valid exp</div>');
                            validForm = false;
                        }
                    });
                    return validForm;
                }

                $('.employeesFormBtn_wrapper').on('click', function (e) {
                    e.preventDefault();
                    if(displayClientErrors()) {
                        addClientInfoRequestCheck($('#ClientInfo'));
                    }else{
                        displayClientErrors();
                    }
                });

                var addClientInfoRequest = false;

                function addClientInfoRequestCheck(data){
                    if(addClientInfoRequest && addClientInfoRequest.readyState !== 4){
                        addClientInfoRequest.abort();
                    }
                    addClientInfoRequest = addClientInfoRequestRun(data);
                }

                function addClientInfoRequestRun(data){
                    var elemRes =  $('.formRes ').html('');
                    var addClientInfoRequest = $.ajax({
                        cache: false,
                        url: 'clients.ajax.php?addClientInfo=1&hk=<?php echo password_hash('addClientInfo', PASSWORD_DEFAULT); ?>',
                        dataType: 'text',
                        type: 'post',
                        data: data.serialize(),
                        contentType: 'application/x-www-form-urlencoded',
                        beforeSend: function(){
                            elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Submitting...</div>');
                        },
                        error: function(){
                            elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Failed to submit.</div>');
                        },
                        success: function(data){
                            if( data){
                                elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Successfully saved. Page reloading</div>');
                                window.location.reload();
                            }else{
                                elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Could not submit. '+data+'</div>');
                            }
                        }
                    });
                    return addClientInfoRequest;
                }

                $('.employeesFormBtnUpdate_wrapper').on('click', function (e) {
                    e.preventDefault();
                    if(displayClientErrors()) {
                        updateClientInfoRequestCheck($('#ClientInfo'));
                    }else{
                        displayClientErrors();
                    }
                });

                var updateClientInfoRequest = false;

                function updateClientInfoRequestCheck(data){
                    if(updateClientInfoRequest && updateClientInfoRequest.readyState !== 4){
                        updateClientInfoRequest.abort();
                    }
                    updateClientInfoRequest = updateClientInfoRequestRun(data);
                }

                function updateClientInfoRequestRun(data){
                    var elemRes =  $('.formRes ').html('');
                    var updateClientInfoRequest = $.ajax({
                        cache: false,
                        url: 'clients.ajax.php?updateClientInfo=1&hk=<?php echo password_hash('updateClientInfo', PASSWORD_DEFAULT); ?>',
                        dataType: 'text',
                        type: 'post',
                        data: data.serialize(),
                        contentType: 'application/x-www-form-urlencoded',
                        beforeSend: function(){
                            elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Updating...</div>');
                        },
                        error: function(){
                            elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Failed to Update.</div>');
                        },
                        success: function(data){
                            if( data){
                                elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Successfully Updated. Page reloading</div>');
                                window.location.reload();
                            }else{
                                elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Could not Update. '+data+'</div>');
                            }
                        }
                    });
                    return updateClientInfoRequest;
                }


                $('.deleteEmployeeBtn_wrapper').on('click', function (e) {
                    e.preventDefault();
                    $('.deleteDialogRes').toggle();
                    $('.deleteDialogRes').scrollIntoView();
                });


                $('.cancelDelete').on('click', function (e) {
                    e.preventDefault();
                    $('.deleteDialogRes').hide();

                });

                $('.confirmDeleteYes').on('click', function (e) {
                    e.preventDefault();
                    deleteClientInfoRequestCheck($('#clientID').val());
                });


                var deleteClientInfoRequest = false;

                function deleteClientInfoRequestCheck(clientID){
                    if(deleteClientInfoRequest && deleteClientInfoRequest.readyState !== 4){
                        deleteClientInfoRequest.abort();
                    }
                    deleteClientInfoRequest = deleteClientInfoRequestRun(clientID);
                }

                function deleteClientInfoRequestRun(clientID){
                    var elemRes =  $('.formRes ').html('');
                    var deleteClientInfoRequest = $.ajax({
                        cache: false,
                        url: 'clients.ajax.php?deleteClientInfo=1&clientID='+clientID+'&hk=<?php echo password_hash('deleteClientInfo', PASSWORD_DEFAULT); ?>',
                        dataType: 'text',
                        type: 'post',
                        contentType: 'application/x-www-form-urlencoded',
                        beforeSend: function(){
                            elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">deleting...</div>');
                        },
                        error: function(){
                            elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Failed to delete.</div>');
                        },
                        success: function(data){
                            if( data){
                                elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Successfully deleted. Page reloading</div>');
                                window.location.reload();
                            }else{
                                elemRes.html('<div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;">Could not delete. '+data+'</div>');
                            }
                        }
                    });
                    return deleteClientInfoRequest;
                }



            });

        </script>
        <?php
        return ob_get_clean();
    }

    /**
     * inserts client information into the database
     * @param array $data
     * @return int
     */
    public function addClient(array $data):int{
        $clientID = '';

        if(isset($data['name']) && $data['name']){
            $data['name'] = htmlentities($data['name']);
        }
        if(isset($data['surname']) && $data['surname']){
            $data['surname'] = htmlentities($data['surname']);
        }
        if(isset($data['number']) && $data['number']){
            $data['number'] = htmlentities($data['number']);
        }
        if(isset($data['email']) && $data['email']){
            $data['email'] = htmlentities($data['email']);
        }
        if(isset($data['dob']) && $data['dob']){
            $data['dob'] = htmlentities($data['dob']);
        }
        if(isset($data['streetAddress']) && $data['streetAddress']){
            $data['streetAddress'] = htmlentities($data['streetAddress']);
        }

        if(isset($data['city']) && $data['city']){
            $data['city'] = htmlentities($data['city']);
        }

        if(isset($data['postalCode']) && $data['postalCode']){
            $data['postalCode'] = htmlentities($data['postalCode']);
        }
        if(isset($data['country']) && $data['country']){
            $data['country'] = htmlentities($data['country']);
        }

        if ($stmt = $GLOBALS['DBSasoft']->prepare("INSERT INTO `clientsinfo` (`Name`, `Surname`, `Number`, `Email`, `DOB`, `StreetAddress`, `City`, `PostalCode`, `Country` ) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssssssss", $data['name'], $data['surname'], $data['number'], $data['email'], $data['dob'], $data['streetAddress'], $data['city'], $data['postalCode'], $data['country']);
            if ($stmt->execute()) {
                $clientID = $stmt->insert_id;
                $_SESSION['clientInfo']['clientID'] = $stmt->insert_id;
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }

        if(isset($data['skill']) && $data['skill'] && $clientID){
            foreach ($data['skill'] as $key => $value){
                // inserts the skill list into the database
                $this->insertSkillList($clientID, htmlentities($data['skill'][$key]), htmlentities($data['exp'][$key]), htmlentities($data['rating'][$key]));
            }
        }

        return $clientID;
    }

    /**
     * inserts the skill list into the database
     * @param int $clientID client unique identifier
     * @param string $skill name of the skill
     * @param string $exp years of experience
     * @param string $rating rating level
     * @return void
     */
    private function insertSkillList(int $clientID, string $skill, string $exp, string $rating): void{
        $skillID = '';
        if ($stmt = $GLOBALS['DBSasoft']->prepare("INSERT INTO `clientskills` (`ClientID`, `Skill`, `Exp`, `Rating`) VALUES(?, ?, ?, ?)")) {
            $stmt->bind_param("isss", $clientID, $skill, $exp, $rating);
            if ($stmt->execute()) {
                $skillID = $stmt->insert_id;
                $_SESSION['clientInfo'][$clientID]['skillID'] = $stmt->insert_id;
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }

    }

    public function fetchAllClients($clientID = null): array{
        $return = $where = $fields = null;
        if($clientID){
            $fields = ", `Email`, `DOB`, `StreetAddress`, `City`, `PostalCode`, `Country`";
            $where = "WHERE `ClientID` = ?";
            $params[0] = "i";
            $params[] = &$clientID;
        }
        if ($stmt = $GLOBALS['DBSasoft']->prepare("SELECT `ClientID`, `Name`, `Surname`, `Number` $fields FROM `clientsinfo` $where ")) {
            if($clientID){
                call_user_func_array(array($stmt, "bind_param"), $params);
            }
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $return[$row['ClientID']] = $row;
                }
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }

        if($clientID && $return){
            // fetchs all the skills assigned to the client
            $return[$clientID]['Skills'] = $this->fetchAllSkillsForClient($clientID);
        }
        return $return;
    }

    public function fetchAllSkillsForDropDown(){
        $return = null;
        if ($stmt = $GLOBALS['DBSasoft']->prepare("SELECT `Skill` FROM `clientskills` ")) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $return[$row['Skill']] = $row;
                }
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }
        return $return;
    }

    private function fetchAllSkillsForClient($clientID){
        $return = null;
        $param[0] = "i";
        $param[] = &$clientID;
        if ($stmt = $GLOBALS['DBSasoft']->prepare("SELECT * FROM `clientskills` WHERE `ClientID` = ? ")) {
            call_user_func_array(array($stmt, "bind_param"), $param);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $return[$row['SkillID']] = $row;
                }
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }
        return $return;
    }

    public function updateClientInfo($data){
        $return = null;
        if(isset($data['name']) && $data['name']){
            $data['name'] = htmlentities($data['name']);
        }
        if(isset($data['surname']) && $data['surname']){
            $data['surname'] = htmlentities($data['surname']);
        }
        if(isset($data['number']) && $data['number']){
            $data['number'] = htmlentities($data['number']);
        }
        if(isset($data['email']) && $data['email']){
            $data['email'] = htmlentities($data['email']);
        }
        if(isset($data['dob']) && $data['dob']){
            $data['dob'] = htmlentities($data['dob']);
        }
        if(isset($data['streetAddress']) && $data['streetAddress']){
            $data['streetAddress'] = htmlentities($data['streetAddress']);
        }

        if(isset($data['city']) && $data['city']){
            $data['city'] = htmlentities($data['city']);
        }

        if(isset($data['postalCode']) && $data['postalCode']){
            $data['postalCode'] = htmlentities($data['postalCode']);
        }
        if(isset($data['country']) && $data['country']){
            $data['country'] = htmlentities($data['country']);
        }

        $query = "UPDATE `clientsinfo` SET `Name` = ?, `Surname` = ?, `Number` = ? , `Email` =? , `DOB` = ?, `StreetAddress` = ?, `City` =? , `PostalCode` = ? , `Country` = ?  WHERE  `ClientID` = ? LIMIT 1";
        if ($stmt = $GLOBALS['DBSasoft']->prepare($query)) {
            $stmt->bind_param("sssssssssi", $data['name'], $data['surname'], $data['number'], $data['email'], $data['dob'], $data['streetAddress'], $data['city'], $data['postalCode'], $data['country'], $data['clientID']);
            if ($stmt->execute()) {
                $return = true;
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }

        if($return && isset($data['skill']) && $data['skill'] && isset($data['clientID']) &&  $data['clientID']){
            $return = $this->deleteClientSkill($data['clientID']);
            if($return){
                foreach ($data['skill'] as $key => $value){
                    // inserts the skill list into the database
                    $this->insertSkillList($data['clientID'], htmlentities($data['skill'][$key]), htmlentities($data['exp'][$key]), htmlentities($data['rating'][$key]));
                }
            }

        }
        return $return;
    }

    public function deleteClientSkill($clientID){
        $return = false;
        $query = "DELETE FROM `clientskills` WHERE `ClientID` = ? ";
        if ($stmt = $GLOBALS['DBSasoft']->prepare($query)) {
            $stmt->bind_param("i", $clientID);
            if ($stmt->execute()) {
                $return = true;
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }
        return $return;
    }

    public function deleteClient($clientID){
        $return = false;
        $query = "DELETE FROM `clientsinfo` WHERE `ClientID` = ? ";
        if ($stmt = $GLOBALS['DBSasoft']->prepare($query)) {
            $stmt->bind_param("i", $clientID);
            if ($stmt->execute()) {
                $return = true;
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }
        return $return;
    }

    public function searchClientInfo($searchTerm = '', $filter){
        $return = $searchBy = null;
        $response = array();
            $searchTerm = htmlentities($searchTerm);
            $filter = htmlentities($filter);
            if($filter != 'dob'){
                $searchBy =" || cs.`Skill` LIKE '%$filter%' ";
            }
            $field = "ci.`Name` LIKE '%$searchTerm%' || ci.`Surname` LIKE '%$searchTerm%'  || ci.`Email` LIKE '%$searchTerm%' $searchBy ";

            if($filter == 'dob'){
                $orderBy = "ORDER BY ci.`DOB`, cs.`Skill` ";
            }else{
                $orderBy = "ORDER BY cs.`Skill`, ci.`DOB` ";
            }


        if ($stmt = $GLOBALS['DBSasoft']->prepare("SELECT ci.`ClientID`, ci.`Name`, ci.`Surname`, ci.`Number` FROM `clientsinfo` AS ci LEFT JOIN `clientskills` AS cs ON ci.`ClientID` = cs.`ClientID`  WHERE $field ")) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $return[$row['ClientID']] = $row;
                }
            }else{
                echo($stmt);
            }
            $stmt->close();
        } else {
            echo($GLOBALS['DBSasoft']->error);
        }

        ob_start();
        if($return && is_array($return)){
            $clientCount = 1;
            foreach ($return as $key => $value){
                echo '<div class="clientDisplay_wrapper_wrap"><div class="clientDisplay_wrapper" data-clientid="'.$value['ClientID'].'" >
                            <div class="clientCount">'.$clientCount++.'</div>
                            <div>'.$value['Name'].'</div>
                            <div>'.$value['Surname'].'</div>
                            <div>'.$value['Number'].'</div>
                      </div></div>';
            }
            $response['count'] = $clientCount;
        }else{
            $response['count'] = 0;
            ?><div style="margin: 4px; background: red;border-radius: 6px; padding: 6px;"> No results Found</div><?php
        }
        $response['content'] = ob_get_clean();


        return $response;
    }

    /**
     * deletes a employee along with their skills
     * @param $clientID
     * @return bool
     */
    public function deleteClientInfo($clientID): bool{
        $return = false;
        $return = $this->deleteClient($clientID);
        if($return){
            $return = $this->deleteClientSkill($clientID);
        }
        return $return;
    }

}