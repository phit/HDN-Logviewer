HDN-Logviewer
=============

Very basic webbased chatlog reader for a Hidden Source (SRCDS) server

## URL Variables

m = numeric month, without leading zeros  
d = day of the month without leading zeros  
y = year 4 digits  
join = if set to 1 hide join/leave messages  
debug = debugtests  

exmaple: logviewer.php?m=4&d=24&y=2014&join=2&debug

## Info

Tested on a Windows IIS webserver. Based on https://forums.alliedmods.net/showpost.php?p=1424808&postcount=2

Required CVAR's

// Log settings  
log 1 // Turn on logging  
sv_log_onefile 0 // Log server information to only one file.  
sv_logflush 1 // Flush the log file to disk on each write (slow).  
