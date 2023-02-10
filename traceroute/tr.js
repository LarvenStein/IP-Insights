const urlParams = new URL(window.location).searchParams
fetch("traceroute.php?query="+urlParams.get('query'))
    .then(response=>response.text())
    .then(data=>{ 
        document.getElementById("tr").innerHTML = "<h3>Whois request for "+urlParams.get('query')+":</h3><pre>"+data+"</pre>";
    });