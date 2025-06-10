<!DOCTYPE html>
<html lang="en">
<head>
  <title>Footer</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Footer Styles */
    .footer {
      background-color: white;
      padding: 60px 0 0 0;
      font-family: 'Poppins', sans-serif;
      width: 100%;
    }

    .footer .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .footer .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 30px;
    }

    .footer .col {
      flex: 1;
      min-width: 200px;
      padding: 0 15px;
    }

    .footer h4 {
      color: #333;
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 25px;
      position: relative;
    }

    .footer h4::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      width: 50px;
      height: 2px;
      background: linear-gradient(to right, #a7a6d6, #2575fc);
    }

    .footer ul {
      list-style: none;
      padding: 0;
    }

    .footer ul li {
      margin-bottom: 12px;
    }

    .footer ul li a {
      color: #555;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .footer ul li a:hover {
      color: #2575fc;
      transform: translateX(5px);
    }

    .social-links {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    .social-links a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(to right, #a7a6d6, #2575fc);
      color: white;
      transition: all 0.3s ease;
    }

    .social-links a:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(37, 117, 252, 0.3);
    }

    .bottom-bar {
      background: linear-gradient(to right, #a7a6d6, #2575fc);
      color: white;
      text-align: center;
      padding: 20px 0;
      margin-top: 60px;
      font-size: 14px;
    }

    .bottom-bar p {
      margin: 0;
    }

    @media (max-width: 768px) {
      .footer .col {
        flex: 100%;
        margin-bottom: 30px;
      }

      .footer .row {
        flex-direction: column;
        gap: 0;
      }
    }
  </style>
</head>
<body>
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
    <div class="bottom-bar">
      <p>&copy; 2025 | All rights reserved</p>
    </div>
  </footer>
</body>
</html>
