// Frost Guard Website JavaScript

$(document).ready(function () {

    $('.navbar .nav-link, .navbar .dropdown-item').on('click', function () {
        const href = $(this).attr('href') || '';
        if (href.startsWith('#')) {
            $('.navbar-collapse').collapse('hide');
        }
    });


    // Smooth scrolling for navigation links
    $('a[href^="#"]').on('click', function (event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });

    // Add active class to navigation items on scroll
    $(window).scroll(function () {
        var scrollDistance = $(window).scrollTop();

        $('section[id]').each(function (i) {
            if ($(this).position().top - 100 <= scrollDistance) {
                $('.navbar-nav a.active').removeClass('active');
                $('.navbar-nav a').eq(i).addClass('active');
            }
        });
    });

    // Navbar background on scroll
    $(window).scroll(function () {
        if ($(window).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }
    });

    // Animate elements on scroll
    function animateOnScroll() {
        $('.loading').each(function () {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('loaded');
            }
        });
    }

    // Add loading class to elements that should animate
    $('.card, .process-number, .accordion-item').addClass('loading');

    $(window).scroll(animateOnScroll);
    animateOnScroll(); // Run on page load

    // Contact form submission
    $('#contactForm').on('submit', function (e) {
        e.preventDefault();

        // Get form data
        var formData = {
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            service: $('#service').val(),
            message: $('#message').val()
        };


        // Simulate form submission
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();

        submitBtn.html('<i class="bi bi-hourglass-split me-2"></i>Sending...').prop('disabled', true);

        setTimeout(function () {
            submitBtn.html('<i class="bi bi-check-circle me-2"></i>Message Sent!').removeClass('btn-primary').addClass('btn-success');
            showAlert('Thank you for your message! We\'ll contact you within 24 hours.', 'success');
            $('#contactForm')[0].reset();

            setTimeout(function () {
                submitBtn.html(originalText).removeClass('btn-success').addClass('btn-primary').prop('disabled', false);
            }, 3000);
        }, 2000);
    });

    // Modal form submission
    $('#scheduleForm').on('submit', function (e) {
        e.preventDefault();

        // Get form data
        var formData = {
            name: $('#modalName').val(),
            email: $('#modalEmail').val(),
            phone: $('#modalPhone').val(),
            service: $('#modalService').val(),
            message: $('#modalMessage').val()
        };


        

        // Simulate form submission
        var submitBtn = $(this).find('button[type="submit"]');
        var originalText = submitBtn.html();

        submitBtn.html('<i class="bi bi-hourglass-split me-2"></i>Scheduling...').prop('disabled', true);

        setTimeout(function () {
            submitBtn.html('<i class="bi bi-check-circle me-2"></i>Scheduled!').removeClass('btn-primary').addClass('btn-success');
            showAlert('Service scheduled successfully! We\'ll call you within 24 hours to confirm details.', 'success');
            $('#scheduleForm')[0].reset();

            setTimeout(function () {
                $('#contactModal').modal('hide');
                submitBtn.html(originalText).removeClass('btn-success').addClass('btn-primary').prop('disabled', false);
            }, 2000);
        }, 2000);
    });

    // Service card hover effects
    $('.service-card').hover(
        function () {
            $(this).find('.service-icon i').addClass('text-white');
            $(this).addClass('bg-primary text-white');
        },
        function () {
            $(this).find('.service-icon i').removeClass('text-white').addClass('text-primary');
            $(this).removeClass('bg-primary text-white');
        }
    );

    // Pricing card click to open modal with service pre-selected
    $('.pricing-card').on('click', function () {
        var serviceType = $(this).find('.card-title').text().toLowerCase();
        var serviceValue = '';

        if (serviceType.includes('one-time')) {
            serviceValue = 'one-time';
        } else if (serviceType.includes('seasonal')) {
            serviceValue = 'seasonal';
        } else if (serviceType.includes('emergency')) {
            serviceValue = 'emergency';
        } else if (serviceType.includes('de-icing')) {
            serviceValue = 'deicing';
        }

        $('#modalService').val(serviceValue);
        $('#contactModal').modal('show');
    });

    // Add click animation to buttons
    $('.btn').on('click', function () {
        $(this).addClass('btn-clicked');
        setTimeout(() => {
            $(this).removeClass('btn-clicked');
        }, 200);
    });

    // Phone number formatting
    $('#phone, #modalPhone').on('input', function () {
        var phone = $(this).val().replace(/\D/g, '');
        var formattedPhone = phone.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        if (phone.length <= 10) {
            $(this).val(formattedPhone);
        }
    });

    // Auto-resize textareas
    $('textarea').on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Add weather effect to hero section
    function createSnowflake() {
        var snowflake = $('<div class="snowflake">❄</div>');
        snowflake.css({
            position: 'absolute',
            top: '-10px',
            left: Math.random() * 100 + '%',
            fontSize: Math.random() * 10 + 10 + 'px',
            color: 'rgba(255, 255, 255, 0.8)',
            animation: 'snowfall ' + (Math.random() * 5 + 5) + 's linear infinite',
            pointerEvents: 'none',
            zIndex: 1
        });

        $('.hero-section').append(snowflake);

        setTimeout(function () {
            snowflake.remove();
        }, 10000);
    }

    // Create snowflakes periodically
    if ($(window).width() > 768) {
        setInterval(createSnowflake, 500);
    }

    // Testimonial carousel auto-advance (if implementing carousel)
    var testimonialIndex = 0;
    var testimonials = $('.testimonial-card');

    function rotateTestimonials() {
        testimonials.removeClass('active');
        testimonials.eq(testimonialIndex).addClass('active');
        testimonialIndex = (testimonialIndex + 1) % testimonials.length;
    }

    // Initialize first testimonial as active
    if (testimonials.length > 0) {
        testimonials.eq(0).addClass('active');
        setInterval(rotateTestimonials, 5000);
    }

    // Emergency contact button functionality
    $('.emergency-btn').on('click', function () {
        if (confirm('This will call our emergency line. Continue?')) {
            window.location.href = 'tel:2145551234';
        }
    });

    // Service area badges interaction
    $('.badge').hover(
        function () {
            $(this).addClass('bg-secondary').removeClass('bg-primary');
        },
        function () {
            $(this).addClass('bg-primary').removeClass('bg-secondary');
        }
    );

    // FAQ accordion enhancement
    $('.accordion-button').on('click', function () {
        $(this).closest('.accordion-item').toggleClass('active');
    });

    // Lazy loading for images
    $('img').each(function () {
        if (this.loading !== 'lazy') {
            this.loading = 'lazy';
        }
    });

    // Add entrance animations to sections
    function addEntranceAnimations() {
        var elements = $('.container, .card, .btn, .badge');
        elements.each(function (index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
            $(this).addClass('fade-in-up');
        });
    }

    // Initialize entrance animations
    setTimeout(addEntranceAnimations, 500);

    // Back to top button
    //var backToTopBtn = $('<button class="btn btn-primary back-to-top" style="position: fixed; bottom: 20px; right: 20px; border-radius: 50%; width: 50px; height: 50px; z-index: 1000; display: none;"><i class="bi bi-arrow-up"></i></button>');
    //$('body').append(backToTopBtn);

    /*
    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            backToTopBtn.fadeIn();
        } else {
            backToTopBtn.fadeOut();
        }
    });
    */

    /*
    backToTopBtn.on('click', function() {
        $('html, body').animate({scrollTop: 0}, 800);
    });
    */

});

// Utility functions
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    var phoneRegex = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
    return phoneRegex.test(phone);
}

function showAlert(message, type) {
    var alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show position-fixed" style="top: 100px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
        '</div>');

    $('body').append(alert);

    setTimeout(function () {
        alert.alert('close');
    }, 5000);
}

// CSS animations for button clicks
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .btn-clicked {
            transform: scale(0.95);
            transition: transform 0.1s ease;
        }
        
        .snowflake {
            user-select: none;
            pointer-events: none;
        }
        
        .testimonial-card.active {
            transform: scale(1.02);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .accordion-item.active .accordion-button {
            background-color: var(--primary-color);
            color: white;
        }
        
        .back-to-top:hover {
            transform: translateY(-3px);
        }
        
        @media (max-width: 768px) {
            .back-to-top {
                bottom: 80px !important;
            }
        }
    `)
    .appendTo('head');

// Initialize tooltips if any
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

// Initialize popovers if any
$(function () {
    $('[data-bs-toggle="popover"]').popover();
});