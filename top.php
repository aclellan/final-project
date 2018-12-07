<?php
include "lib/constants.php";
$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
$path_parts = pathinfo($phpSelf);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>The Devils Den</title>

        <meta charset="utf-8">
        <meta name="author" content="The Devils Den">
        <meta name="description" content="A web site devoted to your New Jersey Devils">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/custom.css" type="text/css" media="screen">
<?php
        $debug = false;
        // This if statement allows us in the classroom to see what our variables are
        // This is NEVER done on a live site 
        if (isset($_GET["debug"])) {
            $debug = true;
        } 
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
$domain = '//';
$server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, 'UTF-8');
$domain .= $server;
if ($debug) {
    print '<p>php Self: ' . $phpSelf;
    print '<pdomain: ' . $domain;
    print '<p>Path Parts<pre>';
    print_r($path_parts);
    print '</pre></p>';
} 
        
// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries. 
// 
print  PHP_EOL . '<!-- include libraries -->' . PHP_EOL; 

print "<!-- require Database.php -->";

require_once(LIB_PATH . '/Database.php');

print "<!-- make Database connections -->";
$dbUserName = get_current_user() . '_reader';
$whichpass = 'r';
$dbName = ACLELLAN_FinalProject;

$thisDatabaseReader = new Database($dbUserName, $whichpass, $dbName);

require_once 'lib/security.php';

if ($path_parts['filename'] == "ticketform") {
    print PHP_EOL . '<!-- include form libraries -->' . PHP_EOL;
 
 include LIB_PATH . 'lib/Connect-With-Database.php';
    include 'lib/constants.php';
    include 'lib/pass.php';
    include 'lib/Database.php';
}

if ($path_parts['filename'] == "form1") {
    print PHP_EOL . '<!-- include form libraries -->' . PHP_EOL;
     include_once 'lib/validation-functions.php';     
     include_once 'lib/mail-message.php';  
}
print  PHP_EOL . '<!-- finished including libraries -->' . PHP_EOL;        
?>
    </head>
<!-- ######################       Body Section       #####################/# -->     
<?php
print '<body id="' . $path_parts['filename'] . '">' . PHP_EOL;
include 'header.php';
print  PHP_EOL;
include 'nav.php';
print  PHP_EOL;
if ($debug) {
    print '<p>DEBUG MODE IS ON</p>';
}
    
print "<!-- End of top.php -->";
?>

<!-- ######################       Main Section       ######################## -->


