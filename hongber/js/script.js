function myFunction() {
  document.getElementById("history_dropdown").classList.toggle("show");
}

window.onclick = function (event) {
  if (!event.target.matches('.history_btn')) {
    let dropdowns = document.getElementsByClassName("dropdown_content");
    let i;
    for (i = 0; i < dropdowns.length; i++) {
      let openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}