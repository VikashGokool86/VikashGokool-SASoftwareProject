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
    public static function clientFormDisplay():string{
        ob_start();
        ?>
        <form id="ClientInfo" name="ClientInfo" method="POST" autocomplete="off"  action="clients.ajax.php?ClientInfo=1&hk=<?php echo password_hash('ClientInfo', PASSWORD_DEFAULT); ?>" >
            <h2 class="title">New Employee</h2>
            <h4>Basic Info</h4>
            <div class="gen_wrapper">
                <div>
                <div class="sub_title">Name</div>
                <div><input class="genInputField" id="name" type="text" name="ClientInfo[name]" placeholder="Name" required > </div>
                </div>
                <div>
                <div class="sub_title">Surname</div>
                <div><input class="genInputField" id="surname" type="text" name="ClientInfo[surname]" placeholder="Surname" required > </div>
                </div>
            </div>
            <div class="sub_title">Contact Number</div>
            <div><input class="genInputField" id="tel" type="number" name="ClientInfo[number]"  placeholder="0813367987 or 0333915315" pattern="[0-9]{10}"     required ></div>

            <div class="sub_title">Email Address</div>
            <div><input class="genInputField" id="email" type="email" name="ClientInfo[email]"  placeholder="Email Address" required ></div>

            <div class="sub_title">Date Of Birth</div>
            <div><input class="genInputField" id="dob" type="date" name="ClientInfo[dob]"  required></div>
            <h6>Address Info</h6>
            <div class="sub_title">Street Address</div>
            <div><input class="genInputField" id="streetAddress" type="text" name="ClientInfo[streetAddress]" placeholder="Street Address" required ></div>
            <div class="gen_wrapper">
                <div>
                    <div class="sub_title">City</div>
                    <div><input class="genInputField" id="city" type="text" name="ClientInfo[city]" placeholder="City" required ></div>
                </div>
                <div>
                    <div class="sub_title">Postal Code</div>
                    <div><input class="genInputField" id="postalCode" type="number" name="ClientInfo[postalCode]" placeholder="Postal Code" required ></div>
                </div>
                <div>
                    <div class="sub_title">Country</div>
                    <div><input class="genInputField" id="country" type="text" name="ClientInfo[country]" placeholder="Country" required ></div>
                </div>
            </div>
            <h6>Skills</h6>
            <div class="gen_wrapper skillsRow" >
                <div>
                    <div class="sub_title">Skill</div>
                    <div><input class="genInputField" id="skill" type="text" name="ClientInfo[skill][]" placeholder="Skill" required ></div>
                </div>
                <div>
                    <div class="sub_title">Yrs Exp</div>
                    <div><input class="genInputField" id="exp" type="text" name="ClientInfo[exp][]" placeholder="Yrs Exp" required ></div>
                </div>
                <div>
                    <div class="sub_title">Seniority Rating</div>
                    <div class="selectBtn_wrapper">
                        <select class="genSelect"  name="ClientInfo[rating][]" id="rating" required >
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="skillsRes"></div>
            <div class="skillBtn_wrapper">
                <div class="skillBtn"><img src="images/addIEmployee.svg" width="20"></div>
                <div class="skillTxt">Add New Skill</div>
            </div>
            <div class="employeesFormBtn_wrapper">
                <div class="employeesBtn"><img src="images/addIEmployee.svg" width="30"></div>

                <div class="employeesTxt">Save & Add Employees</div>
            </div>
            <input id="ClientInfoBtn" name="ClientInfo[save]" type="submit" >
            <div class="formRes">
        </form>
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
        if($skillID){
            $_SESSION['clientInfo'][$clientID][$skillID]['skill'] = $skill;
            $_SESSION['clientInfo'][$clientID][$skillID]['exp'] = $exp;
            $_SESSION['clientInfo'][$clientID][$skillID]['rating'] = $rating;
        }
    }

}