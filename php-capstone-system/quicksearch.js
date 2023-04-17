"use strict";

var active_request = null;

function $( id )
{
  return document.getElementById( id );
}

window.onload = function()
{
    $("qsearch").onkeyup = propqs;
    $("qsearch").focus();
    $("reset").onclick = resetSearchForm;
}

function propqs()
{
    if (active_request)
    {
        active_request.abort();
        active_request = null;
    }
    
    var qstext = $("qsearch").value;
    resetSearchForm();
    if (!qstext)
    {
        $("proptablebody").innerHTML = "";
    }
    else
    {
        active_request = new XMLHttpRequest();

        active_request.open("GET", "get_prop_table.php?&srch=" + qstext, true);
        active_request.onload = function () {
            $("proptablebody").innerHTML = active_request.responseText;
        }
        active_request.send();
    }
}

function resetSearchForm()
{
    $("lastname").value = "";
    $("firstname").value = "";
    $("company").value = "";
    $("proptype").selectedIndex = "0";
    $("propstatus").selectedIndex = "0";
    $("prof1").selectedIndex = "0";
    $("order").selectedIndex = "0";
    $("proptablebody").innerHTML = "";
}
