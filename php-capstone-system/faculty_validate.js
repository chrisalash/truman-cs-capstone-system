//Ensure info entered for new faculty memeber is valid
function $(id)
{
    return document.getElementById( id );
}

function validate()
{
    var f_name = $("first_name").value;
    var l_name = $("last_name").value;
  
    //FIXME: when we move to ECMAScript 6, change this to allow unicode chars
  var name_regex = /^[a-zA-Z\-\'\s]+$/;
  
  clear_error_messages();
  
  if(!f_name.match(name_regex))
  {
    $( "first_err_message").innerHTML = "Please enter a valid first name";
    return false;
  }
  else if(!l_name.match(name_regex))
  {
    $( "last_err_message").innerHTML = "Please enter a valid last name";
    return false;
  }
  else
  {
    return true;
  }
}

function clear_error_messages()
{
  $("first_err_message").innerHTML = "";
  $("last_err_message").innerHTML = "";
}
