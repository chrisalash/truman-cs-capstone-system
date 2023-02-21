"use strict";

//Ensure info entered for student is valid
function $(id)
{
    return document.getElementById( id );
}

window.onload = function()
{
    $("submit").onclick = validate;
    document.title = "Edit Information";
}

function validate()
{
    var f_name = $("first_name").value;
    var l_name = $("last_name").value;
    var banner = $("banner_id").value;
    var hours = $("hours").value;
    var grad_month = $("grad_month").value;
    var grad_year = $("grad_year").value;
  
    //FIXME: when we move to ECMAScript 6, change this to allow unicode chars
    var name_regex = /^[A-Za-z][a-zA-Z\-\' ]+$/;
  
    if(!f_name.match(name_regex))
    {
        alert("Please enter a valid first name");
        return false;
    }

    if(!l_name.match(name_regex))
    {
        alert("Please enter a valid last name");
        return false;
    }

    if( !banner_id.match( /^0\d{8}$/ ))
    {
        alert("Please enter a valid 9-digit banner ID");
        return false;
    }

    if( !( $grad_month == "May" || $grad_month == "December" || $grad_month == "August" ))
    {
        alert("Please enter your planned graduation month");
        return false;
    }

    if( !grad_year.match( /^2\d{3}$/ ))
    {
        alert("Please enter your planned graduation year");
        return false;
    }

    return true;
}
