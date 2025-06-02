<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Landing Page Header</title>
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

        /* .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: black;
            transition: width 0.15ms ease;
        } */

        .nav-links a:hover {
            color: #007bff;
            background-color: #f1f1f1;
        }

        /* .nav-links a:hover::after {
            width: 100%;
        } */

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
            border-radius: 8px
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .nav-links a:hover {
            color: #007bff;
        }

        .dropdown-content a::after {
            display: none;
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
</head>

<body>
    <header class="header">
        <div class="logo-container">
            <img src="public/assets/img/Cairo_University_crest.svg" alt="University Logo" class="logo">
        </div>
        <nav class="nav-links">
            <a href="#">Home</a>
            <div class="dropdown">
                <a href="#">Our Services</a>
                <div class="dropdown-content">
                    <a href="#">Service 1</a>
                    <a href="#">Service 2</a>
                    <a href="#">Service 3</a>
                </div>
            </div>
            <a href="#">Contact us</a>
            <a href="#">About us</a>
        </nav>
    </header>
    <script>
        let ticking = false;
        let isExpanded = false;
        let lastScrollPosition = 0;
        let debounceTimer;

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    const header = document.querySelector('.header');
                    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

                    // Clear any pending timer
                    clearTimeout(debounceTimer);


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

                    lastScrollPosition = currentScroll;
                    ticking = false;
                });
                ticking = true;
            }
        });
    </script>
</body>

</html>