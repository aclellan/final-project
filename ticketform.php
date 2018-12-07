<?php
include 'top.php';
?>
<link rel="stylesheet" type='text/css' href="css/custom.css"
      
<?php
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1 Initialize Variables -->' . PHP_EOL;
// These variables are used in both sections 2 and 3, otherwise we would
// declare them in the section we needed them


print PHP_EOL . '<!-- SECTION: 1a. debugging setup -->' . PHP_EOL;
// We print out the post array so that we can see our form is working.
// Normally I wrap this in a debug statement but for now I want to always
// display it. When you first come to the form it is empty. when you submit the
// form it displays the contents of the post array.
if ($debug){
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
}
    
//%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1b form variables -->' . PHP_EOL;
//
// Initialize variables one for each form element
// in the order they appear on the form

if (isset($_GET['id'])) {
    $pmkForwardsId = (int) htmlentities($_GET['id'], ENT_QUOTES, 'UTF-8');
    
    $query = 'SELECT fldFirstName, fldLastName, ';
    $query .= 'FROM tblForwards WHERE pmkForwardsId = ?';
    
    $data = array($pmkForwardsId);
    
    if ($thisDatabaseReader->querySecurityOk($query, 1)) {
        $query = $thisDatabaseReader->sanitizeQuery($query);
        $Forward = $thisDatabaseReader->select($query, $data);
    }
    $firstName = $Forward[0]['fldFirstName'];
    $lastName = $Forward[0]['fldLastName'];
} else {
    $pmkForwardsId = -1;
    $firstName = '';
    $lastName = '';
}

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form
$pmkForwardsId = -1;
$firstNameERROR = false;
$lastNameERROR = false;
///%^%^%^%^%^%^%^%^%%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1d misc variables -->' . PHP_EOL;
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();
$mailed = false;
$dataEntered = false;



//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
print PHP_EOL . '<!-- SECTION: 2 Process for when the form is submitted -->' . PHP_EOL;
//
if (isset($_POST["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2a Security -->' . PHP_EOL;
    
    // the url for this form
    $yourURL = DOMAIN . PHP_SELF;
    
    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page.</p>';
        $msg.= '<p>Security breach detected and reported.</p>';
        die($msg);
    }
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2b Sanitize (clean) data -->' . PHP_EOL;
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.
    
    $firstName = htmlentities($_POST['txtFirstName'], ENT_QUOTES, 'UTF-8');
    $data[] = $firstName;
    
    $lastName = htmlentities($_POST['txtLastName'], ENT_QUOTES, 'UTF-8');
    $data[] = $lastName;
    
    //@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2c Validation -->' . PHP_EOL;
    //
    // Validation section. Check each value for possible errors,
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.
   
    if($firstName = "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = 'Your first name appears to have extra characters.';
        $firstNameERROR = true;
    }
    
    if($lastName = "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = 'Your last name appears to have extra characters.';
        $lastNameERROR = true;
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2d Process Form - Passed Validation -->' . PHP_EOL;
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if (DEBUG) {
                print '<p>Form is valid</p>';
        }
        print PHP_EOL . '<!-- SECTION: 2e Save Data -->' . PHP_EOL;
        
        $dataEntered = false;
        $data = array();
        
        $data[] = $firstName;
        $data[] = $lastName;
        
        try{
            $thisDatabaseWriter->db->beginTransaction();
            
            $query = 'INSERT INTO tblForwards SET ';
            
            $query .= 'fldFirstName = ?, ';
            $query .= 'fldLastName = ?, ';
            
            if (DEBUG) {
                $thisDatabaseWriter->TestSecurityQuery($query, 0);
                print_r($data);
            }
            
            if ($thisDatabaseWriter->querysecurityOk($query, 0)) {
                $query = $thisDatabaseWriter->sanitizeQuery($query);
                
                $results = $thisDatabaseWriter->insert($query, $data);
                
                $primaryKey = $thisDatabaseWriter->lastInsert();
                
                if (DEBUG) {
                    print "<p>pmk= " . $primaryKey;
                }
            }
           
             $dataEntered = $thisDatabaseWriter->db->commit();
             
             if (DEBUG)
                 print "<P>transaction complete ";
        } catch (PDOException $e) {
            $thisDatabaseWriter->db->rollback();
            if (DEBUG)
                print "Error!: " . $e->getMessage() . "</br>";
            $errorMsg[] = "There was a problem accepting your data please
    contact us directly.";
        }
    
print PHP_EOL . '<!-- SECTION: 2g Mail to user -->' . PHP_EOL;

    }
}      
                
print PHP_EOL . '<!-- SECTION: 3 Display Form -->' . PHP_EOL;
//
?>
<main>
    <article>
<?php
    //#########################
//
print PHP_EOL . '<!-- SECTION: 3a -->' . PHP_EOL;
//
// If its the first time coming to the form or there are errors we are going
// to display the form.
      if ($dataEntered) { // closing of if marked with: end body submit
          print '<h1>Record Saved</h1> ';
    } else {
 //################################
 //
    print PHP_EOL . '<!-- SECTION: 3b Error Messages -->' . PHP_EOL;
    //
    // display any error messages before we print out the form
    
    if ($errorMsg) {
        print '<div id="errors">' . PHP_EOL;
        print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
        print '<ol>' . PHP-EOL;
        foreach ($errorMsg as $err) {
            print '<li>' . $err . '</li>' . PHP_EOL;
        }
         print '</ol>/n';
         print '</div>' ;
    }
    
     //##############################
    //
    print PHP_EOL . '<!-- SECTION: 3c html Form -->' . PHP_EOL;
    //
    /* Display the HTML form. note that the action is to this same page. $phpSelf
       is defined in top.php
     * NOTE the line:
     * value="<?php print $email; ?>
     * this makes the form sticky by displaying either the initial default line (line ??)
     * or the value they typed in (line ??)
     * NOTE this line:
     * <?php if($emailERROR) print 'class=mistake"'; ?>
     * this prints out a css class so that we can highlight the background, etc.
     * to make it stand out that a mistake happened here.
     */
?>
        <h2>Forwards</h2>
        <form action="<?php print PHP_SELF; ?>"
              method="post"
              id="frmRegister">
            <fieldset class= "contact">           
            
            <p>
                <label for='txtFirstName' class='required'>First Name </label>
                <input autofocus
                <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                                id="txtFirstName"
                                maxlength="45"
                                name="txtFirstName"
                                onfocus="this.select()"
                                placeholder="Enter your first name"
                                tabindex="100"
                                type="text"
                                value="<?php print $firstName; ?>"                    
                        >                    
            </p>
               
          </p>
          
         <p>
                        <label class="required" for="txtLastName">Last Name</label>  
                        <input
                                <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                                id="txtFirstName"
                                maxlength="45"
                                name="txtLastName"
                                onfocus="this.select()"
                                placeholder="Enter your last name"
                                tabindex="110"
                                type="text"
                                value="<?php print $lastName; ?>"                    
                        >                    
        </p>
          
          <fieldset class="buttons">
              <input type="submit" id="btnSubmit" name="btnSubmit" value="Save"
tabindex="900" class="button">
          </fieldset> <!-- ends buttons -->
        </form>
        <?php
    } // ends body submit
?>
    
</main>

<?php 
include 'footer.php';
if (DEBUG)
    print "<p>END OF PROCESSING</p>";
?>
</article>
</body>
</html>