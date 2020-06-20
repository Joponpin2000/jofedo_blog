
    // Scroll to top  		
	if ($('.dmtop').length) {
		var scrollTrigger = 100, // px
			backToTop = function () {
				var scrollTop = $(window).scrollTop();
				if (scrollTop > scrollTrigger) {
					$('.dmtop').addClass('show');
				} else {
					$('.dmtop').removeClass('show');
				}
			};
		backToTop();
		$(window).on('scroll', function () {
			backToTop();
		});
		$('.dmtop').on('click', function (e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 700);
		});
	}
	
    // LOADER
    $(window).load(function() {
        $("#preloader").on(500).fadeOut();
        $(".preloader").on(600).fadeOut("slow");
    });

	// DASHBOARD COLLAPSE BUTTON
	$(document).ready(function () {
		$('#sidebarCollapse').on('click', function () {
			$('#sidebar').toggleClass('active');
			$('.collapse.in').toggleClass('in');
			$('a[aria-expanded=true]').attr('aria-expanded', 'false');
		});
	});

/******************************************
    FORM VALIDATION
/****************************************** */
function validate(form) {
    if (form.name.value == "") {
        alert("Please provide your name!");
        form.name.focus();
        return false;
    }

    if (form.email.value == "") {
        alert("Please provide your email!");
        form.email.focus();
        return false;
    }

    validateEmail(form);

    if (form.phone.value == "") {
        alert("Please provide your phone number!");
        form.phone.focus();
        return false;
    }


    if (form.message.value == "") {
        alert("Please enter your comment!");
        form.message.focus();
        return false;
    }
}

function validateEmail(form) {
    var emailID = form.email.value;
    atpos = emailID.indexOf("@");
    dotpos = emailID.lastIndexOf(".");

    if (atpos < 1 || (dotpos - atpos < 2)) {
        alert("Please enter correct email ID!");
        form.email.focus();
        return false;
    }
    return (true);
}