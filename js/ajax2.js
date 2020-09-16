function getXMLHTTPRequest() {
    var req = false;
    try {
        /* for Firefox */
        req = new XMLHttpRequest();
    } catch (err) {
        try {
            /* for some versions of IE */
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err) {
            try {
                /* for some other versions of IE */
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err) {
                req = false;
            }
        }
    }
    return req;
}

function view_input_get() {
    var xmlhttp = getXMLHTTPRequest();
    //get input value
    var id = encodeURI(document.getElementById('btn-update').value);
    var address = encodeURI(document.getElementById('address').value);
    var city = encodeURI(document.getElementById('city').value);
    //set url and inner
    var url = "process_form_get.php?name=" + name + "&address=" + address + "&city=" + city;
    var inner = "user_input";
    //open request 
    xmlhttp.open('GET', url, true);
    xmlhttp.onreadystatechange = function () {
        document.getElementById(inner).innerHTML = '<img src="images/ajax_loader.jpg" /> ';
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            document.getElementById(inner).innerHTML = xmlhttp.responseText;
        }
        return false;
    }
    xmlhttp.send(null);
}

function view_input_post_kat(id) {
    var xmlhttp = getXMLHTTPRequest();
    //get input value

    //set url and inner
    var inner = "input_kategori";
    var url = "process_form_post.php";
    var params = "id=" + id;
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded ");

    xmlhttp.onreadystatechange = function () {
        // document.getElementById(inner).innerHTML = '<img src="images/ajax_loader.jpg" /> ';
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            document.getElementById(inner).innerHTML =
                xmlhttp.responseText;
        }
        return false;
    }
    xmlhttp.send(params);
}

function view_input_post_skat(id) {
    var xmlhttp = getXMLHTTPRequest();
    //get input value

    //set url and inner
    var inner = "input_skategori";
    var url = "process_form_post_skat.php";
    var params = "id=" + id;
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded ");

    xmlhttp.onreadystatechange = function () {
        // document.getElementById(inner).innerHTML = '<img src="images/ajax_loader.jpg" /> ';
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            document.getElementById(inner).innerHTML =
                xmlhttp.responseText;
        }
        return false;
    }
    xmlhttp.send(params);
}

function view_input_post_peg(id) {
    var xmlhttp = getXMLHTTPRequest();
    //get input value

    //set url and inner
    var inner = "input_kategori";
    var url = "process_form_post_peg.php";
    var params = "id=" + id;
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded ");

    xmlhttp.onreadystatechange = function () {
        // document.getElementById(inner).innerHTML = '<img src="images/ajax_loader.jpg" /> ';
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            document.getElementById(inner).innerHTML =
                xmlhttp.responseText;
        }
        return false;
    }
    xmlhttp.send(params);
}

function view_input_post_pro(id, kat, skat) {
    var xmlhttp = getXMLHTTPRequest();
    //get input value
    console.log("masuk");
    //set url and inner
    var inner = "input_kategori";
    var url = "process_form_post_pro.php";
    var params = "id=" + id + "&kat=" + kat + "&skat=" + skat;
    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded ");

    xmlhttp.onreadystatechange = function () {
        // document.getElementById(inner).innerHTML = '<img src="images/ajax_loader.jpg" /> ';
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            document.getElementById(inner).innerHTML =
                xmlhttp.responseText;
        }
        return false;
    }
    xmlhttp.send(params);
}