"use strict";

function $( id )
{
    return document.getElementById( id );
}

window.onload = function()
{
    document.title = "Create Proposal";
    showHideOrganizationField();
    $("type").onchange = showHideOrganizationField;
    $("submit").onclick = validate;
    $('non_usa_div').style.display = 'none';
    $("usa_cb").onclick = setUSA;
    $("non_usa_cb").onclick = setNonUSA;
}

function setUSA()
{
  $('usa_cb').checked = true;
  $('non_usa_div').style.display = 'none';
  $('non_usa_cb').checked = false;
  $('usa_div').style.display = 'block';
}

function setNonUSA()
{
  $('usa_cb').checked = false;
  $('non_usa_div').style.display = 'block';
  $('non_usa_cb').checked = true;
  $('usa_div').style.display = 'none';
}

function validate()
{
   if(document.querySelector('#type option:checked').value == 0)
   {
      alert("Select a Type");
      $("type").focus();
      return false;
   }

    if( document.querySelector('#type option:checked').value == 6 && $("other").value.length == 0 )
    {
        alert("Supply a description for Other");
        $("other").focus();
        return false;
    }

    if( (document.querySelector('#type option:checked').value == 1 ||
         document.querySelector('#type option:checked').value == 2) && $("company").value.length == 0 )
    {
        alert("Supply a company or organization name");
        $("company").focus();
        return false;
    }

    if( $('usa_cb').checked && $('city').value === '' )
    {
      alert( 'Supply the city and state, or country' );
      return false;
    }
    else if( $('non_usa_cb').checked && $('country').value === '' )
    {
      alert( 'Supply the city and state, or country' );
      return false;
    }

    return true;
}

function showHideOrganizationField()
{
    // get the type of this proposal
    var e = $("type");
    var proptype = e.options[e.selectedIndex].value;
    $("other_div").style.display = "none";
    $("org_div").style.display = "none";

    if( proptype != 6 )
    {
        $("other").value = "";
    }

    if( proptype == "1" || proptype == "2" ) // internship or research
    {
        $("org_div").style.display = "block";
    }
    else if( proptype == "6" ) // other
    {
        $("other_div").style.display = "block";
        $("other_div").focus();
    }
}
