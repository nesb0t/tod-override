<?php

###################################################
# Set our variables/constants/etc
###################################################

date_default_timezone_set('America/New_York');			// Not required, but usually a good idea in php

define("DSS_KEY_NUM", "4");								// Define the DSS key number where the script will be assigned (allows us to toggle the LED)
define("ENABLE_CODE", "*12");							// The star code you configured to ENABLE the time frame/answer rule
define("DISABLE_CODE", "*13");							// The star code you configured to DISABLE the time frame/answer rule

###################################################

?>
<?xml version="1.0" encoding="ISO-8859-1"?>					<!-- Generate file for Yealink XML browser -->

<YealinkIPPhoneExecute
Beep="no">

<?php

    $selection = htmlspecialchars($_GET['selection']);			// Sanitize user input just in case
	
	if ($selection != "enable" && $selection != "disable") {	// Sanity check so we don't write data that we don't trust.
		echo "Error";											// Just used for debugging
		exit;
	}
	
	$updateStatus = fopen("status.php", "w");				// Open file to store the current time frame status
    
	switch ($selection) {
		case "enable":														// User enabled the override
			echo '<ExecuteItem URI="Led:LINE'. DSS_KEY_NUM . '_RED=on" />';	// Set the LED to RED to indicate closed
			echo '<ExecuteItem URI="Dial:'. ENABLE_CODE . '" />';							// Have phone dial *12 to enable "Force Closed" override
			$newStatus = '<?php $status = "enable"; ?>';					// Status file will show "enable" status
			break;
			
		case "disable":										// User disabled the override
			echo '<ExecuteItem URI="Led:LINE'. DSS_KEY_NUM . '_GREEN=on" />';	// Set the LED to GREEN to indicate normal operation
			echo '<ExecuteItem URI="Dial:'. DISABLE_CODE . '" />';			// Have phone dial *13 to disable "Force Closed" override
			$newStatus = '<?php $status = "disable"; ?>';	// Status file will show "disable" status
			break;
			
		default:											// Received invalid input
			break;
	}

fwrite($updateStatus, $newStatus);							// Write status file
fclose($updateStatus);										// Close status file

?>

</YealinkIPPhoneExecute>	