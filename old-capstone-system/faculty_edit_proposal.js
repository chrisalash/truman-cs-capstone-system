"use strict";

function $( id )
{
    return document.getElementById( id );
}

window.onload = function()
{
    document.title = "Edit Proposal";
    hideNoteDiv();
    showHideOrganizationField();
    $("type").onchange = showHideOrganizationField;
    $("add_note_button").onclick = displayNoteDiv;
    $("add_note_cancel").onclick = hideNoteDiv;
    $("submit").onclick = validate;
    $("status").onchange = checkProfessors;
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

function checkProfessors()
{
    var status = document.querySelector('#status option:checked').value;
    if( status == 3 )
    {
        $("professor1").disabled = false;
        $("professor2").disabled = false;
        $("professor3").disabled = false;
    }
    else
    {
        $("professor1").disabled = true;
        $("professor2").disabled = true;
        $("professor3").disabled = true;
    }
}

function validate()
{
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
      alert( 'You must supply the name of a city' );
      return false;
    }
    else if( $('non_usa_cb').checked && $('country').value === '' )
    {
      alert( 'You must supply the name of a country' );
      return false;
    }

    var status = document.querySelector('#status option:checked').value;
    var prof1 = document.querySelector('#professor1 option:checked').value;
    var prof2 = document.querySelector('#professor2 option:checked').value;
    var prof3 = document.querySelector('#professor3 option:checked').value;

    if( status == "3" && (prof1 == "0" || prof2 == "0" || prof3 == "0") )
    {
        alert("Choose three professors");
        $("professor1").focus();
        return false;
    }

    return true;
}

function displayNoteDiv()
{
    $("add_note_button").style.display = "none";
    $("add_note_div").style.display = "block";
    $("note_text").focus();
}

function hideNoteDiv()
{
    $("add_note_button").style.display = "inline";
    $("add_note_div").style.display = "none";
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
