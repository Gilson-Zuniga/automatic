$(document).ready(function() {
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $($.attr(this, 'href')).offset().top - 70
                }, 800);
            });
            
            // Form validation and submission
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                
                // Basic validation
                let isValid = true;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if ($('#name').val().trim() === '') {
                    $('#name').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#name').removeClass('is-invalid');
                }
                
                if (!emailRegex.test($('#email').val().trim())) {
                    $('#email').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#email').removeClass('is-invalid');
                }
                
                if ($('#phone').val().trim() === '') {
                    $('#phone').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#phone').removeClass('is-invalid');
                }
                
                if ($('#message').val().trim() === '') {
                    $('#message').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#message').removeClass('is-invalid');
                }
                
                if (isValid) {
                    // Show loading spinner
                    $('#loadingSpinner').show();
                    
                    // Prepare form data
                    const formData = {
                        name: $('#name').val().trim(),
                        email: $('#email').val().trim(),
                        phone: $('#phone').val().trim(),
                        message: $('#message').val().trim(),
                        recipient: 'quinterolevii87@gmail.com' // Add recipient email address
                    };
                    
                    // Call the 'Lead Submission' Magic Loop API with email sending functionality
                    $.ajax({
                        url: '/api/magic-loops/lead-submission',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#loadingSpinner').hide();
                            $('#successMessage').show();
                            $('#errorMessage').hide();
                            $('#contactForm')[0].reset();
                            
                            // Hide message after some time
                            setTimeout(function() {
                                $('.form-response').fadeOut();
                            }, 5000);
                        },
                        error: function(xhr, status, error) {
                            $('#loadingSpinner').hide();
                            $('#errorMessage').show();
                            $('#successMessage').hide();
                            
                            // Hide message after some time
                            setTimeout(function() {
                                $('.form-response').fadeOut();
                            }, 5000);
                        }
                    });
                }
            });
            
            // Handle navbar appearance on scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').css('padding', '0.5rem 2rem');
                } else {
                    $('.navbar').css('padding', '1rem 2rem');
                }
            });
        });