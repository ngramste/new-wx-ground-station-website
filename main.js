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

function listImages(evt, id) {
  var i, x, tablinks;
  x = document.getElementsByClassName("imageList");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(id).style.display = "block";
}

function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function updateCalendar(event, year, month, files) {
  openImg(event, 'Archive');
  const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

  if (0 == month && 0 == year) {
    var d = new Date();
    month = d.getMonth();
    year = d.getFullYear();
  }

  if (month >= 12) {
    month = 0;
    year++;
  }
  if (month < 0) {
    month = 11;
    year--;
  }

  var firstDay = new Date(year, month, 1).getDay();
  var numDays = new Date(year, month + 1, 0).getDate();

  var html =
      "<div class=\"month w3-orange\">"+
      "<ul>"+
      "  <li class=\"prev w3-button\" onclick='updateCalendar(event,"+year+","+(month - 1)+","+JSON.stringify(files)+")'>&#10094;</li>"+
      "  <li class=\"next w3-button\" onclick='updateCalendar(event,"+year+","+(month + 1)+","+JSON.stringify(files)+")'>&#10095;</li>"+
      "  <li>" + monthNames[month] + "<br>"+
      "    <span style=\"w3-xxlarge\">" + year + "</span>"+
      "  </li>"+
      "</ul>"+
      "</div>"+
      ""+
      "<ul class=\"weekdays w3-theme-d1\">"+
      "<li>Su</li>"+
      "<li>Mo</li>"+
      "<li>Tu</li>"+
      "<li>We</li>"+
      "<li>Th</li>"+
      "<li>Fr</li>"+
      "<li>Sa</li>"+
      "</ul>"+
      ""+
      "<ul class=\"days w3-theme-l1\">";

  var days = new Array(numDays);
  for (var i = 0; i < numDays; i++) {
    days[i] = new Array();
  }

  for (var i = 0; i < files.length; i++) {
    imgYear = Number(files[i].substring(7, 11));
    imgMonth = Number(files[i].substring(11, 13)) - 1;
    imgDay = Number(files[i].substring(13, 15));

    if (imgYear == year && imgMonth == month) {
      days[imgDay - 1].push(files[i]);
    }
  }

  for (var i = 0; i < firstDay; i++) {
    html += "<li></li>";
  }

  for (var i = 1; i <= numDays; i++) {
    if (0 < days[i-1].length) {
      html += "<li class=\"w3-orange w3-button\" onclick=\"listImages(event, " + imgYear + "" + pad(imgMonth + 1, 2) + "" + pad(i, 2) + ")\">" + i + "</li>";
    } else {
      html += "<li class=\"w3-button\">" + i + "</li>";
    }
  }
  html +=
      "</ul>"+
      "</div>";

  document.getElementById("calendar").innerHTML = html;
}
