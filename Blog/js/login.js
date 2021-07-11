const f_email= document.getElementById("form_email2")
const f_password= document.getElementById("form_password")

function submitForm() {
    let email= f_email2.value.toString()
    let password = f_password.value.toString()
    if (email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/) ==null ) {
        f_email.style.background = 'red'
        return false
    }
    if (password.match(/^[A-Za-z0-9!@#$%^*_+]{8,20}$/) ==null ) {
        f_password.style.background = 'red'
        return false
    }
    return true
  }

  f_email.addEventListener('change', checkEmail)
  f_password.addEventListener('change', checkPassword)

  function checkEmail() {
      if (f_email.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/) == null) {
          f_email.style.background = 'red'
      } else {
          f_email.style.background = 'white'
      }
  }

  function checkPassword() {
      if (f_password.value.match(/^[A-Za-z0-9!@#$%^&*_+]{8,20}$/) == null ) {
          f_password.style.background = 'red'
      } else{
          f_password.style.background = 'white'
      }
  }

document.getElementById("clear").addEventListener("click", clear)

function clear() {
  f_email.style.background = "white"
  f_email.value = null;
  f_password.style.background = 'white'
  f_password.value = null;
}

document.getElementById('eye').addEventListener("click", switchPassword);

function switchPassword() {
    if (f_password.type === "text") {
        f_password.type= "password"
    } else {
        f_password.type= "text"
    }
}