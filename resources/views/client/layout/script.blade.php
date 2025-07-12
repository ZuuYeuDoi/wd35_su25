<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('client/js/jquery.js') }}"></script>
<script src="{{ asset('client/js/popper.min.js') }}"></script>
<script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('client/js/slick.min.js') }}"></script>
<script src="{{ asset('client/js/slick-animation.min.js') }}"></script>
<script src="{{ asset('client/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('client/js/wow.js') }}"></script>
<script src="{{ asset('client/js/appear.js') }}"></script>
<script src="{{ asset('client/js/mixitup.js') }}"></script>
<script src="{{ asset('client/js/flatpickr.js') }}"></script>
<script src="{{ asset('client/js/swiper.min.js') }}"></script>
<script src="{{ asset('client/js/gsap.min.js') }}"></script>
<script src="{{ asset('client/js/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('client/js/SplitText.min.js') }}"></script>
<script src="{{ asset('client/js/splitType.js') }}"></script>
<script src="{{ asset('client/js/script.js') }}"></script>
<script src="{{ asset('client/js/script-gsap.js') }}"></script>

@stack('js')

<style>
    .custom-alert {
        border-radius: 12px !important;
        border: none !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
        margin-bottom: 10px !important;
        padding: 15px 20px !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        backdrop-filter: blur(10px) !important;
        border-left: 4px solid !important;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
        color: #155724 !important;
        border-left-color: #28a745 !important;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
        color: #721c24 !important;
        border-left-color: #dc3545 !important;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
        color: #856404 !important;
        border-left-color: #ffc107 !important;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%) !important;
        color: #0c5460 !important;
        border-left-color: #17a2b8 !important;
    }

    .btn-close {
        opacity: 0.7 !important;
        transition: opacity 0.2s ease !important;
    }

    .btn-close:hover {
        opacity: 1 !important;
    }

    .flash-messages-container {
        animation: slideInRight 0.5s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<script>
    // Auto hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.custom-alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert) {
                    alert.style.transition = 'all 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }
            }, 5000);
        });
    });

    // Add smooth animation for alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.custom-alert');
        alerts.forEach(function(alert, index) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(100%)';
            alert.style.transition = 'all 0.4s ease-out';

            setTimeout(function() {
                alert.style.opacity = '1';
                alert.style.transform = 'translateX(0)';
            }, index * 150);
        });
    });

    // Add click to dismiss functionality
    document.addEventListener('DOMContentLoaded', function() {
        const closeButtons = document.querySelectorAll('.btn-close');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const alert = this.closest('.custom-alert');
                if (alert) {
                    alert.style.transition = 'all 0.3s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                }
            });
        });
    });
</script>
