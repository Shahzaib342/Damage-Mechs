function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

$(document).ready(function () {
    $(".login-form button.custom-stl").click(function (e) {
        e.preventDefault();
        var username = $('.login-form .username').val();
        var password = $('.login-form .password').val();
        if ((username == 'user' && password == 'user') || (username == 'admin' && password == 'admin')) {
            window.location.href = 'FFS-landing.html', true;
        } else {
            alert('Invalid Login Details. Please contact techsupport@rapidsolve.ca');
        }
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('header .top-row').addClass("sticky");
        } else {
            $('header .top-row').removeClass("sticky");
        }
    });

    $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4,.header-menu').mouseover(function () {
        $("#nav-icon4").addClass('open');
    });
    $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4,.header-menu').mouseout(function () {
        $("#nav-icon4").removeClass('open');
    });
});