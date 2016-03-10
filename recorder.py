import os
import sys

def startRecording(SOURCEDIR, TARGETDIR):
    os.system("bash recorder.sh " + SOURCEDIR + " " + TARGETDIR + " > /dev/null 2>&1 &")

def stopRecording():
    os.system("pkill -9 -f recorder.sh")
