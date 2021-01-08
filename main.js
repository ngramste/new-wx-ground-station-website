function openImg(evt, image) {
  var i, x, tablinks;
  x = document.getElementsByClassName("map");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-orange", "");
  }
  document.getElementById(image).style.display = "block";
  evt.currentTarget.className += " w3-orange";
}