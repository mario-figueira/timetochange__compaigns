#!/bin/bash

#################
#requirements	#
#################
# msgfmt http://linux.die.net/man/1/msgfmt

#remove mo files
find . -name '*.mo' -type f | while read NAME ; 
do 
	rm "${NAME}"; 
	echo removed ${NAME};
done

#generate files
find . -name '*.po' -type f | while read NAME ; 
do 
        msgfmt "${NAME}" -o "${NAME%.*}".mo;
	echo generated "${NAME%.*}".mo;
done

echo have a nice day!;

