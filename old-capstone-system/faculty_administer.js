//Ensures that a professor is selected if the "Edit" button is selected. If so, redirects
//user to a page to administer faculty info
function validate()
{
    if(document.getElementById('professor').value == 'default')
    {
      document.getElementById('err_message').innerHTML = "Please select a professor";
      return false;
    }
}
