const f_first_name= document.getElementById("form_firstname")
const f_last_name= document.getElementById("form_lastname")
const f_email= document.getElementById("form_email")
const f_password= document.getElementById("form_password")
const f_password2= document.getElementById("form_password2")
const f_country= document.getElementById("form_country")
const f_birthday= document.getElementById("form_birthday")

function submitForm() {
    let name = f_first_name.value.toString()
    let lname=f_last_name.value.toString()
    let email= f_email.value.toString()
    let password = f_password.value.toString()
    let password2 = f_password2.value.toString()
    let country = f_country.value.toString()

    if (name.match(/^[A-Za-z]{2,40}$/) == null) {
        f_first_name.style.background = 'red'
        return false
    }
    if (lname.match(/^[A-Za-z]{2,40}$/) ==null ) {
        f_last_name.style.background = 'red'
        return false
    }
    if (email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/) ==null ) {
        f_email.style.background = 'red'
        return false
    }
    if (password.match(/^[A-Za-z0-9!@#$%^&*_+]{8,20}$/) ==null ) {
        f_password.style.background = 'red'
        return false
    }
    if (password2.match(/^[A-Za-z0-9!@#$%^&*_+]{8,20}$/) ==null ) {
        f_password2.style.background = 'red'
        return false
    }
    if (country.match(/^[A-Za-z]{1,100}$/) ==null ) {
        f_country.style.background = 'red'
        return false
    }

    if (f_password.value !== f_password2.value) {
        f_password2.style.background = 'red'
        return false
    }
    return true
}

f_first_name.addEventListener('change', checkName)
f_last_name.addEventListener('change', checkLastName)
f_email.addEventListener('change', checkEmail)
f_password.addEventListener('change', checkPassword)
f_password2.addEventListener('change', checkPassword2)
f_country.addEventListener('change', checkCountry)

function checkName() {
    if (f_first_name.value.match(/^[A-Za-z]{2,40}$/) == null) {
        f_first_name.style.background = 'red'
    } else {
        f_first_name.style.background = 'white'
    }
}

function checkEmail() {
    if (f_email.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/) == null) {
        f_email.style.background = 'red'
    } else {
        f_email.style.background = 'white'
    }
}

function checkLastName() {
    if (f_last_name.value.match(/^[A-Za-z]{2,40}$/) == null) {
        f_last_name.style.background = 'red'
    } else {
        f_last_name.style.background = 'white'
    }
}

function checkCountry() {
    if (f_country.value.match(/^[A-Za-z]{2,40}$/) == null ) {
        f_country.style.background = 'red'
    } else{
        f_country.style.background = 'white'
    }
}

function checkPassword() {
    if (f_password.value.match(/^[A-Za-z0-9!@#$%^&*_+]{8,20}$/) == null ) {
        f_password.style.background = 'red'
    } else{
        f_password.style.background = 'white'
    }
}

function checkPassword2() {
    if ((f_password2.value.match(/^[A-Za-z0-9!@#$%^&*_+]{8,20}$/) == null) && (f_password !== f_password2)) {
        f_password2.style.background = 'red'
    } else{
        f_password2.style.background = 'white'
    }
}

document.getElementById("clear").addEventListener("click", clear)

function clear() {
    f_password.style.background = 'white'
    f_password.value = null;
    f_password2.style.background = 'white'
    f_password2.value = null;
    f_email.style.background = 'white'
    f_email.value = null;
    f_first_name.style.background = 'white'
    f_first_name.value = null;
    f_last_name.style.background = 'white'
    f_last_name.value = null;
    f_country.style.background = 'white'
    f_country.value = null;
    f_birthday.style.background = 'white'
    f_birthday.value = null;
}

document.getElementById('eye').addEventListener("click", switchPassword)

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

