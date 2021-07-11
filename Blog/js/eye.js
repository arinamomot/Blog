const f_first_name= document.getElementById("form_firstname")
const f_last_name= document.getElementById("form_lastname")
const f_password= document.getElementById("form_password")
const f_password2= document.getElementById("form_password2")
const f_country= document.getElementById("form_country")


document.getElementById("clear").addEventListener("click", clear)

/*
*clear all fields
 */
function clear() {
    f_password.style.background = 'white'
    f_password.value = null;
    f_password2.style.background = 'white'
    f_password2.value = null;
    f_first_name.style.background = 'white'
    f_first_name.value = null;
    f_last_name.style.background = 'white'
    f_last_name.value = null;
    f_country.style.background = 'white'
    f_country.value = null;
}

document.getElementById('eye').addEventListener("click", switchPassword)

/*
* Show or hide the password
 */
function switchPassword() {
    if (f_password2.type=== "text") {
        f_password2.type= "password"
    } else {
        f_password2.type= "text"
    }
    if (f_password.type=== "text") {
        f_password.type= "password"
    } else {
        f_password.type= "text"
    }
}