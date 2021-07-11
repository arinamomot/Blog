let theme = 'light-theme'
const f_menu= document.getElementById("menu")
const f_elements= document.getElementsByClassName('mobile')

// Normal display of the menu on mobile devices.
function trigger() {
    for(let el of f_elements) {
      if (el.style.display == 'none' || el.style.display == '') {
        el.style.display = 'block'
      } else {
        el.style.display = 'none'
      }
    }
}

f_menu.addEventListener("click" , trigger )

const swap= document.getElementById('theme')

function change_theme() {
  let change = document.getElementsByClassName(theme);
  for (let i=0; i < change.length; i++) {
    if (theme == "light-theme"){
      change[i].classList.add('dark-theme');
      document.cookie = "theme=dark-theme; 3600; path=/"
    } else {
      change[i].classList.add('light-theme');
      document.cookie = "theme=light-theme; 3600; path=/"
    }
  }
  while (change.length > 0) {
    change[0].classList.remove(theme);
  }

  theme = (theme == "light-theme") ? "dark-theme" : "light-theme";

}
theme = (getCookie("theme")== 'dark-theme') ? "light-theme" : "dark-theme";
change_theme()
swap.addEventListener("click" , change_theme);

function getCookie(cname) {
  let name = cname + "=";
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
