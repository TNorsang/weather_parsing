#!/bin/bash

if [ ! -f "tagsoup-1.2.1.jar" ]
then
wget "https://repo1.maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar"
fi

while :
do
STATES=(NY CA IL TX AZ PA FL)
i=0
for state in "${STATES[@]}";
do
    fileName=$(date +"%Y-%m-%d-%I-%M-%S-${STATES[$i]}.html")
    link=$(sed -n "$(($i+1))"p sources.txt)
    curl "$link" > "$fileName"
    ((i++))
    java -jar tagsoup-1.2.1.jar --files $fileName
    rm *.html
    python3 parser.py "${fileName%.html}.xhtml"
done

sleep 21600
rm *.xhtml 
done


