<head>
  <title>Footer</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
 
</head>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>{{ __('footer.company') }}</h4>
                <ul>
                    <li><a href="#">{{ __('footer.about_us') }}</a></li>
                    <li><a href="#">{{ __('footer.our_services') }}</a></li>
                    <li><a href="#">{{ __('footer.privacy_policy') }}</a></li>
                </ul>
            </div>
            <div class="col">
                <h4>{{ __('footer.get_help') }}</h4>
                <ul>
                    <li><a href="#">{{ __('footer.faq') }}</a></li>
                    <li><a href="#">{{ __('footer.contact_us') }}</a></li>
                    <li><a href="#">{{ __('footer.troubleshooting') }}</a></li>
                    <li><a href="#">{{ __('footer.terms_of_service') }}</a></li>
                </ul>
            </div>
            <div class="col">
                <h4>{{ __('footer.follow_us') }}</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="bottom-bar">
            <p>&copy; 2025 | All rights reserved</p>
        </div>      

<!-- Add Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

<style>
    .footer {
        background-color: white;
        color: #fff;
        padding: 40px 0;
        font-family: Arial, sans-serif;
    }

    .footer .container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .footer .col {
        flex: 1 1 200px;
        margin: 10px;
    }

    .footer h4 {
        margin-bottom: 20px;
        font-size: 18px;
    }

    .footer ul {
        list-style: none;
        padding: 0;
    }

    .footer ul li {
        margin-bottom: 10px;
    }

    .footer ul li a {
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer ul li a:hover {
        color: #007bff;
    }

    .social-links a {
        color: #ccc;
        margin-right: 15px;
        font-size: 20px;
        display: inline-block;
        transition: color 0.3s ease;
    }

    .social-links a:hover {
        color: #007bff;
    }

    .bottom-bar {
        background-color: #111;
        color: #777;
        text-align: center;
        padding: 15px 0;
        font-size: 14px;
    }
</style>

