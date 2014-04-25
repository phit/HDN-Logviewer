HDN-Logviewer
=============

Very basic webbased chatlog reader for a Hidden Source (SRCDS) server

## Info

Tested on a Windows IIS webserver. Based on https://forums.alliedmods.net/showpost.php?p=1424808&postcount=2  

[*] you can easily add more servers

Required CVAR's

// Log settings  
log 1 // Turn on logging  
sv_log_onefile 0 // Log server information to only one file.  
sv_logflush 1 // Flush the log file to disk on each write (slow).  
