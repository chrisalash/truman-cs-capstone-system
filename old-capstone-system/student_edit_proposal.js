"use strict";

function $( id )
{
    return document.getElementById( id );
}

window.onload = function()
{
    document.title = "Edit Proposal";
    hideNoteDiv();
    var typetype = $("type").nodeName;
    if( typetype == "SELECT" )
    {
        $("type").onchange = showHideOrganizationField;
        showHideOrganizationField();
    }
    $("add_note_button").onclick = displayNoteDiv;
    $("add_note_cancel").onclick = hideNoteDiv;
    $("submit").onclick = validate;
    $("usa_cb").onclick = setUSA;
    $("non_usa_cb").onclick = setNonUSA;
    var print_button = $("print");
    if( print_button )
    {
        print_button.onclick = print;
    }
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

function print()
{
    var result = confirm("Is all information saved?");
    if( result )
    {
        window.location.replace("student_print_proposal.php");
        return true;
    }
    return false;
}

function validate()
{
    var typetype = $("type").nodeName;
    if( typetype == "SELECT" )
    {
        if( document.querySelector('#type option:checked').value == 6 &&
            $("other").value.length == 0 )
        {
            alert("Supply a description for Other");
            $("other").focus();
            return false;
        }

        if( (document.querySelector('#type option:checked').value == 1 ||
             document.querySelector('#type option:checked').value == 2) &&
            $("company").value.length == 0 )
        {
            alert("Supply a company or organization name");
            $("company").focus();
            return false;
        }
    }

    if( $('usa_cb').checked && $('city').value === '' )
    {
      alert( 'Supply a city and state, or country' );
      return false;
    }
    else if( $('non_usa_cb').checked && $('country').value === '' )
    {
      alert( 'Supply a city and state, or country' );
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

    if( proptype != 6 && $("other"))
    {
        $("other").value = "";
    }

    if( proptype == "1" || proptype == "2" ) // internship or research
    {
        $("org_div").style.display = "block";
        $("company").focus();
    }
    else if( proptype == "6" ) // other
    {
        $("other_div").style.display = "block";
        $("other").focus();
    }
}
