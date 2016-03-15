import os
import sys
from nfd_kill import *
from pi_logging import *

MNG_PREFIX = "192.168.0."
PI_START_SUFFIX = 10
PI_END_SUFFIX = 29


# kill emulation.py
os.system("pkill -9 -f emulation.py")

# available pis: PREFIX.NR = IP
pi_list = range(PI_START_SUFFIX,PI_END_SUFFIX+1)

#stop logging
stopLogging(pi_list, PI_START_SUFFIX, MNG_PREFIX)

#kill all NFDs
killNFDs(pi_list, MNG_PREFIX, PI_START_SUFFIX)

print "Stopped Emulation Run"
