#!/bin/bash
SOURCEDIR=${1%/}  # directory to observe for changes of *.log, *.json.
TARGETDIR=${2%/}  # directory changed files get saved in
echo "started recording in '$SOURCEDIR', writing to '$TARGETDIR'"

inotifywait -mrq -e close_write --format %w%f $1 | while read FILE
do
    filename=$(basename "$FILE")
    extension="${filename##*.}"
    filename="${filename%.*}"

    if [[ $extension == "json" ]]; then
      #"JSON-file $FILE was modified, saving..."
      cp $FILE "$TARGETDIR/stat-PI_${filename#PI}_$(date +"%Y-%m-%d_%H:%M:%S").json"
    elif [[ $extension == "log" ]]; then
      #"rtLOG-file $FILE was modified, saving..."
      cp $FILE $TARGETDIR/$filename.$extension
    else
      echo "ignored file $FILE"
    fi
done
