    let tested = false;
        function testping(target) {
        if(tested === false) {
        document.getElementById("ping").innerHTML = '<img src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Lightness_rotate_36f_cw.gif" height="16px">';
        fetch("ping.php?ip="+target).then(response=>response.text())
        .then(data=>{ 
            document.getElementById("ping").innerHTML = data;
            document.getElementById("ping").classList.add('testedping')
            tested = true;
          });
        }
        }
