function validateForm(){
    let fname = document.forms["user_details"]["first_name"].value;
    let lname = document.forms["user_details"]["last_name"].value;
    let city = document.forms["user_details"]["city_name"].value;

    return !(fname == "" || lname == "" || city == "")
}