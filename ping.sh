ping -qc1 $1 2>&1 | awk -F'/' 'END{ print (/^rtt/? "OK "$5" ms":"FAIL") }'
