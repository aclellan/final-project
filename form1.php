<?php
include 'top.php';
?>
<link rel="stylesheet" type='text/css' href="css/custom.css"

<?php
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//       
print  PHP_EOL . '<!-- SECTION: 1 Initialize variables -->' . PHP_EOL;       
// These variables are used in both sections 2 and 3, otherwise we would
// declare them in the section we needed them
print  PHP_EOL . '<!-- SECTION: 1a. debugging setup -->' . PHP_EOL;
// We print out the post array so that we can see our form is working.
// Normally i wrap this in a debug statement but for now i want to always
// display it. when you first come to the form it is empty. when you submit the
// form it displays the contents of the post array.
if ($debug){ 
    print '<p>Post Array:</p><pre>';
    print_r($_POST);
    print '</pre>';
 }
 
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1b form variables -->' . PHP_EOL;
//
// Initialize variables one for each form element
// in the order they appear on the form
$favoritePlayer = "";

$December29th = true;
$January10th = false;
$January31st = false;
$February19th = false;
$March21st = false;
$April1st = false;

$firstName = ""; 

$lastName = "";  

$gender = "Female";

$comments = '';

$email = "Austin.Clelland@uvm.edu";



//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1c form error flags -->' . PHP_EOL;
//
// Initialize Error Flags one for each form element we validate
// in the order they appear on the form
$favoritePlayerERROR = false;
$dateERROR = false;
$totalChecked = 0;
$firstNameERROR = false;
$lastNameERROR = false;
$genderERROR = false;
$commentsERROR = false;
$emailERROR = false;

////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
print PHP_EOL . '<!-- SECTION: 1d misc variables -->' . PHP_EOL;
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();    

$dataRecord = array();
 
// have we mailed the information to the user, flag variable?
$mailed = false;       
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
print PHP_EOL . '<!-- SECTION: 2 Process for when the form is submitted -->' . PHP_EOL;
//
if (isset($_POST["btnSubmit"])) {
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2a Security -->' . PHP_EOL;
    
   // the url for this form
    $thisURL = DOMAIN . PHP_SELF;
    
    
    if (!securityCheck($thisURL)) {
        $msg = '<p>Sorry you cannot access this page.</p>';
        $msg.= '<p>Security breach detected and reported.</p>';
        die($msg);
    }
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2b Sanitize (clean) data  -->' . PHP_EOL;
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.
    $favoritePlayer = htmlentities($_POST["txtFavorite"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $favoritePlayer;
   
    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
    
    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender;
    
    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
    
    if (isset($_POST["checkDecember29th"])){
        $December29th = true;
        $totalChecked++;
    } else {
        $December29th = false;
    }
    
    $dataRecord[] = $December29th;
    
    if (isset($_POST["checkJanuary10th"])){
        $January10th = true;
        $totalChecked++;
    } else {
        $January10th = false;
    }
    
    $dataRecord[] = $January10th;

    if (isset($_POST["checkJanuary31st"])){
        $January31st = true;
        $totalChecked++;
    } else {
        $January31st = false;
    }
    
    $dataRecord[] = $January31st;
    
    if (isset($_POST["February19th"])){
        $February19th = true;
        $totalChecked++;
    } else {
        $February19th = false;
    }
    
    $dataRecord[] = $February19th;
    
    if (isset($_POST["checkMarch21st"])){
        $March21st = true;
        $totalChecked++;
    } else {
        $March21st = false;
    }
    
    $dataRecord[] = $March21st;
    
    if (isset($_POST["checkApri1st"])){
        $April1st = true;
        $totalChecked++;
    } else {
        $April1st = false;
    }
    
    $dataRecord[] = $April1st;
    
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2c Validation -->' . PHP_EOL;
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.
    if($favoritePlayer == ""){
        $errorMsg[] = "Please list a player";
        $favoritePlayerERROR = true;
    }
    
    if($totalChecked < 1){
        $errorMsg[] = "Please choose at least one date";
        $dateERROR = true;
    }
    
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have an extra character.";
        $firstNameERROR = true;
    }
    
    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have an extra character.";
        $lastNameERROR = true;
    }
    
    if($gender != "Male" and $gender != "Female"){
        $errorMsg[] = "Please choose a gender";
        $genderError = true;
    }
    
    if ($comments != ""){
        if (!verifyAlphaNum($comments)){
            $errorMsg[] = "Your comments appear to have extra charaters that are not allowed.";
            $commentsERROR = true;
        }
    }
    
    if ($email == "") {
        $errorMsg[] = 'Please enter your email address';
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {       
        $errorMsg[] = 'Your email address appears to be incorrect.';
        $emailERROR = true;    
    }    
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    print PHP_EOL . '<!-- SECTION: 2d Process Form - Passed Validation -->' . PHP_EOL;
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if ($debug)
                print '<p>Form is valid</p>';
             
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2e Save Data -->' . PHP_EOL;
        //
        // This block saves the data to a CSV file.   
        
        // array used to hold form values that will be saved to a CSV file
        $dataRecord = array();       
        
        // assign values to the dataRecord array

        // setup csv file
        $myFolder = 'data/' ;
        $myFileName = 'registration';
        $fileExt = '.csv';
        $filename = $myFolder . $myFileName . $fileExt;
    
        if ($debug) print PHP_EOL . '<p>filename is ' . $filename;
    
        // now we just open the file for append
        $file = fopen($filename, 'a');
    
        // write the forms informations
        fputcsv($file, $dataRecord);
    
        // close the file
        fclose($file);       
    
     
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2f Create message -->' . PHP_EOL;
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).
        $message = '<h3>The Devils Den</h3>';       
        foreach ($_POST as $htmlName => $value) {
            
            $message .= '<p>';
            // breaks up the form names into words. for example
            // txtFirstName becomes First Name       
            $camelCase = preg_split('/(?=[A-Z])/', substr($htmlName, 3));
            foreach ($camelCase as $oneWord) {
                $message .= $oneWord . ' ';
            }
    
            $message .= ' = ' . htmlentities($value, ENT_QUOTES, "UTF-8") . '</p>';
        }
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        print PHP_EOL . '<!-- SECTION: 2g Mail to user -->' . PHP_EOL;
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form     
        $cc = '';       
        $bcc = '';
        $from = 'The Devils Den';
        // subject of mail should make sense to your form
        $subject = 'Season Tickets';
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    } // end form is valid     
}   // ends if form was submitted.
//#############################################################################
//
print PHP_EOL . '<!-- SECTION 3 Display Form -->' . PHP_EOL;
//
?>       
<main>     
  <article>
    <figure>
        <img alt="The New Jersey Devil" class="roundedCornersSmall" src="images/NewJerseyDevil.jpg">
        <figcaption>Join the Devil at a free game by entering your information!</figcaption>
    </figure>
    <?php
    //####################################
    //
    print PHP_EOL . '<!-- SECTION 3a  -->' . PHP_EOL;
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print '<h2>Thank you for entering the ticket sweepstakes! Our team at the Devils Den will e-mail you within a week if you are chosen! Good luck!.</h2>';
    
        print '<p>For your records a copy of this data has ';
        if (!$mailed) {    
            print "not ";         
        }
    
        print 'been sent:</p>';
        print '<p>To: ' . $email . '</p>';
    
        print $message;
    } else {
        print '<h2>Register Today</h2>';
        print '<p class="form-heading">Enter your information for a chance to win free tickets to a New Jersey Devils home game!.</p>';
        //####################################
        //
        print PHP_EOL . '<!-- SECTION 3b Error Messages -->' . PHP_EOL;
        //
        // display any error messages before we print out the form
        
        if ($errorMsg) {    
           print '<div id="errors">' . PHP_EOL;
           print '<h2>Your form has the following mistakes that need to be fixed.</h2>' . PHP_EOL;
           print '<ol>' . PHP_EOL;
           foreach ($errorMsg as $err) {
               print '<li>' . $err . '</li>' . PHP_EOL;       
           }
            print '</ol>' . PHP_EOL;
            print '</div>' . PHP_EOL;
         }
       //####################################
        //
        print PHP_EOL . '<!-- SECTION 3c html Form -->' . PHP_EOL;
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
            is defined in top.php
            NOTE the line:
            value="<?php print $email; ?>
            this makes the form sticky by displaying either the initial default value (line ??)
            or the value they typed in (line ??)
            NOTE this line:
            <?php if($emailERROR) print 'class="mistake"'; ?>
            this prints out a css class so that we can highlight the background etc. to
            make it stand out that a mistake happened here.
       */
?>    
<form action = "<?php print $phpSelf; ?>"
          id = "frmRegister"
          method = "post">

                <p>
                   <label class="required" for="txtFavoritePlayerName">Favorite Player's Name</label>  
                   <input autofocus
                            <?php if ($favoritePlayerERROR) print 'class="mistake"'; ?>
                            id="txtFirstName"
                            maxlength="45"
                            name="txtFavoritePlayerName"
                            onfocus="this.select()"
                            placeholder="Enter your favorite player's name"
                            tabindex="100"
                            type="text"
                            value="<?php print $favoritePlayer; ?>"                    
                        >                    
                    </p>
                    
          <fieldset class="checkbox <?php if ($dateERROR) print ' mistake'; ?>">
            <legend>Check the date(s) of games you would like to attend!</legend>
            <p>
                <label class="check-part">
                    <input <?php if ($December29th) print " checked "; ?>
                        id="checkDecember29th"
                        name="checkDecember29th"
                        tabindex="420"
                        type="checkbox"
                        value="December 29th">December 29th</label>
            </p>
     <p>
                <label class="check-part">
                    <input <?php if ($January10th) print " checked "; ?>
                        id="checkJanuary10th"
                        name="checkJanuary10th"
                        tabindex="430"
                        type="checkbox"
                        value="January 10th">January 10th</label>
            </p>
            
             
            <p>
                <label class="check-part">
                    <input <?php if ($January31st) print " checked "; ?>
                        id="checkJanuary31st"
                        name="checkJanuary31st"
                        tabindex="430"
                        type="checkbox"
                        value="January 31st">January 31st</label>
            </p>
            
             <p>
                <label class="check-part">
                    <input <?php if ($February19th) print " checked "; ?>
                        id="checkFebruary19th"
                        name="checkFebruary19th"
                        tabindex="430"
                        type="checkbox"
                        value="February 19th">February 19th</label>
            </p>
            
              <p>
                <label class="check-part">
                    <input <?php if ($March21st) print " checked "; ?>
                        id="checkMarch21st"
                        name="checkMarch21st"
                        tabindex="430"
                        type="checkbox"
                        value="March 21st">March 21st</label>
            </p>
            
             <p>
                <label class="check-part">
                    <input <?php if ($April1st) print " checked "; ?>
                        id="checkApril1st"
                        name="checkApril1st"
                        tabindex="430"
                        type="checkbox"
                        value="April 1st">April 1st</label>
            </p>
                </fieldset>
                    
            <fieldset class="textarea">
            <p>
                <label class="required" for="txtComments">Comments</label>
                <textarea <?php if($commentsERROR) print 'class="mistake"';?>
                    id="txtComments"
                    name="txtComments"
                    onfocus="this.select()"
                    tabindex="200"><?php print $comments; ?></textarea>
            </p>
            </fieldset>
            
             <fieldset class="radio <?php if ($genderERROR) print ' mistake'; ?>">
            <legend>Please select your gender!</legend>
            <p>
                <label class ="radio-part">
                    <input type="radio"
                           id="radGenderMale"
                           name="radGender"
                           value="Male"
                           tabindex="572"
                           <?php if ($gender == "Male") echo ' checked="checked"'; ?>>
                    Male</label>
            </p>
            
            <p>
                <label class="radio-part">
                    <input type="radio"
                           id="radGenderFemale"
                           name="radGender"
                           value="Female"
                           tabindex="582"
                           <?php if ($gender == "Female") echo ' checked="checked" '; ?>>
                Female</label>
            </p>
            </fieldset>
                    
            <fieldset class = "contact">
            <legend>Contact Information</legend>
                <p>
                    <label class="required" for="txtFirstName">First Name</label>  
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
                    
                    
                 <p>
                    <label class="required" for="txtLastName">Last Name</label>  
                    <input autofocus
                                <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                                id="txtLastName"
                                maxlength="45"
                                name="txtLastName"
                                onfocus="this.select()"
                                placeholder="Enter your last name"
                                tabindex="100"
                                type="text"
                                value="<?php print $lastName; ?>"                    
                        >                    
                </p>
                    
                    
           
                
             <p>
                    <label class = "required" for = "txtEmail">Email</label>
                    <input 
                        <?php if ($emailERROR) print 'class="mistake"'; ?>
                        id = "txtEmail"     
                        maxlength = "70"
                        name = "txtEmail"
                        onfocus = "this.select()"
                        placeholder = "Enter a valid email address"
                        tabindex = "120"
                        type = "text"
                        value = "<?php print $email; ?>"
                    >
            </p>     
            </fieldset> <!-- ends contact -->
                    
        <fieldset class="buttons, shadowEffect">
            <legend></legend>
            <input class="buttons" id="btnSubmit" name="btnSubmit" tabindex="900"
                   type="submit" value="Register">
        </fieldset>
</form>
<?php
      } // ends body submit
         
?>
    </article>     
</main>     

<?php include 'footer.php'; ?>
</body>     
</html>
           
                    
            
                    
                   
            
          
            
            
            
                    
           
