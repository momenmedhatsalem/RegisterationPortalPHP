<style>
    body {
        margin: 0;
        padding-top: 80px;
        /* Added this to prevent content from hiding behind fixed header */
        font-family: Arial, sans-serif;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 45px;
        background: white;
        color: black;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        border-radius: 12px;
        margin: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateZ(0);
        will-change: transform;
        z-index: 1000;
    }

    .header-scrolled {
        margin: 0;
        border-radius: 0;
    }

    .logo {
        font-weight: bold;
    }

    .nav-links {
        display: flex;
        gap: 20px;
        align-items: center;
        margin: 0 auto;
        /* This centers the nav-links */
        padding-right: 40px;
    }

    .nav-links a {
        color: black;
        text-decoration: none;
        position: relative;
        transition: color 0.15ms ease;
        padding: 10px 15px;
        border-radius: 8px;
    }

    .nav-links a:hover {
        color: #007bff;
        background-color: #f1f1f1;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 200px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        margin-top: 10px;
        top: 100%;
        left: 0;
        border-radius: 5px;
        overflow: hidden;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        border-radius: 8px;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .logo-container {
        width: 40px;
        height: 45px;
        position: absolute;
        left: 7px;
        top: 50%;
        transform: translateY(-50%);
    }

    .logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
</style>

<header class="header">
    <div class="logo-container">
        <img src="{{ asset('images/assets/Cairo_University_crest.svg') }}" alt="University Logo" class="logo">
    </div>
    @php
        App::setLocale(session('locale') ?? 'en');
    @endphp
    <nav class="nav-links {{ App::getLocale() == 'ar' ? 'rtl' : '' }}">
        @if(App::getLocale() == 'ar')
            <a href="#">{{ __('navbar.about') }}</a>
            <a href="#">{{ __('navbar.contact') }}</a>
            <div class="dropdown">
                <a href="#">{{ __('navbar.services') }}</a>
                <div class="dropdown-content">
                    <a href="#">{{ __('navbar.service3') }}</a>
                    <a href="#">{{ __('navbar.service2') }}</a>
                    <a href="#">{{ __('navbar.service1') }}</a>
                </div>
            </div>
            <a href="#">{{ __('navbar.home') }}</a>
        @else
            <a href="#">{{ __('navbar.home') }}</a>
            <div class="dropdown">
                <a href="#">{{ __('navbar.services') }}</a>
                <div class="dropdown-content">
                    <a href="#">{{ __('navbar.service1') }}</a>
                    <a href="#">{{ __('navbar.service2') }}</a>
                    <a href="#">{{ __('navbar.service3') }}</a>
                </div>
            </div>
            <a href="#">{{ __('navbar.contact') }}</a>
            <a href="#">{{ __('navbar.about') }}</a>
        @endif
    </nav>


    <div style="display: flex; gap: 10px; align-items: center;">
    <!-- Show the link based on session lang -->
    @if(session('locale') == 'ar')
        <a href="{{ url('/setlocale/en') }}" title="Switch to English">
            EN
        </a>
    @else
        <a href="{{ url('/setlocale/ar') }}" title="التبديل إلى العربية">
            AR
        </a>
    @endif
    </div>


</header>



<script>
    let ticking = false;
    let isExpanded = false;

    window.addEventListener('scroll', function() {
        if (!ticking) {
            window.requestAnimationFrame(function() {
                const header = document.querySelector('.header');
                const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

                if (currentScroll > 50) {
                    if (!isExpanded) {
                        header.classList.add('header-scrolled');
                        isExpanded = true;
                    }
                } else {
                    if (isExpanded) {
                        header.classList.remove('header-scrolled');
                        isExpanded = false;
                    }
                }

                ticking = false;
            });
            ticking = true;
        }
    });
</script>
