function getParameterByName(name)
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if (results == null)
    return "";
  else
    return results[1];
}

function logOut()
{
  eraseCookie('user');
  window.location = 'http://mudfoot.doc.stu.mmu.ac.uk/students/wilkinst/cw1/';
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function getTimetableLink(){
  var data = JSON.parse(getCookie('user').replace(/\[|\]/g, ''));
  $("#welcome-message").html("Welcome " + data.first_name + " " + data.second_name + "!");
  if(data.is_staff == 0)
  {
    $('.timetable-link a').attr('href', 'http://mudfoot.doc.stu.mmu.ac.uk/students/wilkinst/cw1/StudentTimetable.html');
    $('.timetable-link a').show();
    $('.map-link a').show();
  }
  else if(data.is_staff == 1)
  {
    $('.my-timetable a').attr('href', 'http://mudfoot.doc.stu.mmu.ac.uk/students/wilkinst/cw1/StaffTimetable.html');
    $('.attendance-link a').show();
    $('.edit-lessons a').show();
    $('.exam-results a').show();
    $('.analysis a').show();

  }
}

function AttendanceSort(a,b) {
  if (a.student_name < b.student_name)
    return -1;
  if (a.student_name > b.student_name)
    return 1;
  return 0;
}

function LessonSort(a,b) {
  if (a.start_time < b.start_time)
    return -1;
  if (a.start_time > b.start_time)
    return 1;
  return 0;
}

function LessonNameSort(a,b) {
  if (a.lesson < b.lesson)
    return -1;
  if (a.lesson > b.lesson)
    return 1;
  return 0;
}

function MarkSort(a,b) {
  if (a.x < b.x)
    return -1;
  if (a.x > b.x)
    return 1;
  return 0;
}

function ColorLuminance(hex, lum) {

  // validate hex string
  hex = String(hex).replace(/[^0-9a-f]/gi, '');
  if (hex.length < 6) {
    hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
  }
  lum = lum || 0;

  // convert to decimal and change luminosity
  var rgb = "#", c, i;
  for (i = 0; i < 3; i++) {
    c = parseInt(hex.substr(i*2,2), 16);
    c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
    rgb += ("00"+c).substr(c.length);
  }

  return rgb;
}


