<?php
define("SCRIPT_DIRECTORY", "pi-network");

//echo $_POST["topology"];
//echo $_POST["aLogic"];
//echo $_POST["fwStrategy"];

// server-side check of validity of POST-params
if(empty($_POST["topology"])){
  exit("given network-topology is empty");
}
if(!in_array($_POST["aLogic"], array("player::SVCBufferAdaptationLogic","player::SVCRateBasedAdaptationLogic"))){
  exit($_POST["aLogic"] . " is a unknown adaption-logic");
}
if(!in_array($_POST["fwStrategy"], array("saf", "broadcast", "best-route", "ncc", "omccrf"))){
  exit($POST["fwStrategy"] . " is a unknown forwarding-strategy");
}


//
// write topology-file
//
if (file_put_contents(SCRIPT_DIRECTORY . "/generated_network_top.txt", $_POST["topology"]) === false) {
    exit("Topology-file could not be written. Please check file/directory permissions.");
}


//
// Update contents of apps.py (adaption-logic and forwarding-strategy)
//
// get content of apps.py
if ($appsContent = file_get_contents(SCRIPT_DIRECTORY . "/apps.py")){
}else {
  exit(SCRIPT_DIRECTORY."/apps.py could not be read. Please check file/directory permissions.");
}

// replace adaption-logic with selected one ($_POST["aLogic"])
// replace forwarding-strategy with selected one ($_POST["fwStrategy"])
$patterns = array('/CONSUMER_ADAPTATION_LOGIC = ".*"/', '/FORWARDING_STRATEGY = ".*"/');
$replacements = array('CONSUMER_ADAPTATION_LOGIC = "' . $_POST["aLogic"] . '"',
                      'FORWARDING_STRATEGY = "' . $_POST["fwStrategy"] . '"');
$newAppsContent = preg_replace($patterns,$replacements,$appsContent);

// write new version of apps.py
if (file_put_contents(SCRIPT_DIRECTORY . "/apps.py", $newAppsContent) === false) {
    exit("apps.py could not be written. Please check file/directory permissions.");
}



//
// (Re-)start emulation
//
// End execution of emulation.py
exec("pkill -9 -f emulation.py");

// Perform cleanup (necessary?)
// TODO: stop logging?

//
// Start the emulation
//
$command = "python " . SCRIPT_DIRECTORY ."/emulation.py --network generated_network_top.txt";
exec("cd " . SCRIPT_DIRECTORY . "; "$command . " > /dev/null 2>&1 &"); // run emulation.py in background (avoid stalling php-script)

?>
