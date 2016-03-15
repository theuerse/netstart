<?php
 function isEmulationRunning(){
   exec("pgrep -f emulation.py",$output);
   return (sizeof($output) > 1) ? 1 : 0; // sizeof($options) == 1 -> only PID of pgrep given
 }
?>
