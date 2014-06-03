HDN-Logviewer
=============

basic web chatlog parser for Hidden Source (SRCDS) servers
no cache support, really slowish not meant for massive use

code is very poorly written mostly because im lazy and just wanted a dirty solution without much effort

logpaths in srv_1.php, srv_2.php etc. you can easily copy paste the most part to add more servers

Required CVAR's for the gameservers

// Log settings  
log 1 // Turn on logging  
sv_log_onefile 0 // Log server information to only one file.  
sv_logflush 1 // Flush the log file to disk on each write (slow).  

logflush is not required but if you dont do it logs will only update after mapchange
