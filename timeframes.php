<?php

/**
*
*		Time Frame Override for Yealink & Netsapiens by Brent Nesbit
*		Details: https://github.com/nesb0t/tod-override
*		Version 1.0.0 -- Last updated: 2017-06-15
*
**/

###################################################
# Header: Set our variables/constants/etc
###################################################

date_default_timezone_set('America/New_York');				// Not required, but usually a good idea in php

define("URI", "http://timeframe.example.com/ClientName");	// Set your URL here to the location of where you uploaded these files (no trailing slash). Example: If your file is at http://timeframe.example.com/ClientName/status.php, put "http://timeframe.example.com/ClientName" here

###################################################

require('status.php');							// Pull the current status of the override

?>
<?xml version="1.0" encoding="ISO-8859-1"?>			<!-- Generate file for Yealink XML browser  -->
<YealinkIPPhoneTextMenu
destroyOnExit="yes"
style="numbered"
wrapList="yes"
Timeout="5"
LockIn="yes">

<Title>Override: * indicates current selection</Title>

<?php

if ($status == "enable"){							// If our override status is currently set to "enable"
	?>
	<MenuItem>
	<Prompt> [*] Override to Closed</Prompt>
	<URI><?= URI ?>/selection.php</URI>				<!-- Fill in the uri from above -->
	<Selection>disable</Selection>
	</MenuItem>
	
	<MenuItem>
	<Prompt> [ ] Normal Operation</Prompt>
	<URI><?= URI ?>/selection.php</URI>				<!-- Fill in the uri from above -->
	<Selection>disable</Selection>
	</MenuItem>
	<?php

}

else if ($status == "disable"){						// If our override status is currently set to "disable"
	?>
	<MenuItem>
	<Prompt> [ ] Override to Closed</Prompt>
	<URI><?= URI ?>/selection.php</URI>
	<Selection>enable</Selection>
	</MenuItem>
	
	<MenuItem>
	<Prompt> [*] Normal Operation</Prompt>
	<URI><?= URI ?>/selection.php</URI>
	<Selection>enable</Selection>
	</MenuItem>
	<?php


}
else {												// If our override status is currently unknown
	?>
	<MenuItem>
	<Prompt> [ ] Override to Closed</Prompt>
	<URI><?= URI ?>/selection.php</URI>
	<Selection>enable</Selection>
	</MenuItem>
	
	<MenuItem>
	<Prompt> [ ] Normal Operation</Prompt>
	<URI><?= URI ?>/selection.php</URI>
	<Selection>disable</Selection>
	</MenuItem>
	<?php

}

// This sets the soft keys for the XML browser window
?>
<SoftKey index = "1">
<Label>OK</Label>
<URI>SoftKey:Select</URI>
</SoftKey>

<SoftKey index="2">
<Label>Refresh</Label>
<URI><?= URI ?>/timeframes.php</URI>
</SoftKey>

<SoftKey index = "4">
<Label>Exit</Label>
<URI>SoftKey:Exit</URI>
</SoftKey>

</YealinkIPPhoneTextMenu>