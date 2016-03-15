<?php
require 'emulationUtils.php';
define("SCRIPT_DIRECTORY", "pi-network");

if(isEmulationRunning()){
  $command = "/usr/bin/python stopEmulation.py";
  exec("cd " . SCRIPT_DIRECTORY . " && " . $command . " > log.txt 2>&1 &");
}
?>
