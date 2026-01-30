<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Blog - Home</title>
    <link rel="stylesheet" href="{{asset('homestyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar"><a href="/" class="logo">
   <img style="width: 40%" src="{{ asset('images/logo.png') }}" alt="EZY Skills Logo">



    <div class="logo-text">
        <span class="logo-main">EZY</span>
        <span class="logo-sub">SKILLS</span>
        <span class="logo-tagline">EMPOWER YOUR SKILLS</span>
    </div>
</a>

               
                <div class="nav-links">
                    <a href="{{route('home')}}" class="active">Home</a>
                   
                    <a href="">Course Selector</a>
                    <a href="">Course</a>
                    <a href="">FAQ</a>
                    <a href="">Contact</a>
                    <a href="">About</a>
                     
                     @if (Route::has('login'))
                     @auth
                      <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                       
                    @else
                    <a class="login-button1 " href="{{ route('login') }}">login</a>
                     @endauth
                    @endif
                    @if (Route::has('register'))
                    @auth
                    @else
                    <a class="register-button login-button1" href="{{ route('register') }}">register</a>
                    @endauth
                    @endif
                </div>
                 
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
  <section class="hero">
    <div class="hero-container">

        <!-- LEFT : FORM CARD -->
        <div class="hero-left">
            <div class="auth-card">
                <h2>
                    <span class="text-navy">Create</span>
                    <span class="text-orange">Account</span>
                </h2>

                <form class="auth-form">
                    <input type="email" placeholder="Email address" required>
                    <input type="password" placeholder="password" required>
                    <input type="password" placeholder="Password" required>

                    <button type="submit" class="primary-btn">
                        Create Account
                    </button>
                </form>

                <div class="divider">or</div>

                <div class="social-login">
                    <button class="social google">
                        <img src="{{ asset('images/google.png') }}" alt="">
                        Google
                    </button>
                    <button class="social facebook">Facebook</button>
                    <button class="social apple">Apple</button>
                </div>
            </div>
        </div>

        <!-- RIGHT : IMAGE -->
        <div class="hero-right">
            <img src="{{ asset('images/hero.png') }}" alt="Create Account">
        </div>

    </div>
</section>


 
    <!-- Footer -->
  <footer class="footer">
  <div class="footer-container">

    <!-- COLUMN 1 : LOGO + DESCRIPTION + NEWSLETTER -->
    <div class="footer-col">
      <div class="footer-logo">
        <img src="{{ asset('images/logo.png') }}" alt="EZY SKILLS Logo">
        <span>EZY SKILLS</span>
      </div>
      <p class="footer-desc">
        Subscribe Our Newsletter
      </p>
      <div class="newsletter">
        <input type="email" placeholder="Your email address">
        <button type="submit">&#8594;</button>
      </div>
    </div>

    <!-- COLUMN 2 : QUICK LINKS -->
    <div class="footer-col">
      <h3 style="color:#fff">Quick <span style="color:var(--orange)">Links</span></h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Our Story</a></li>
        <li><a href="#">Best Courses</a></li>
        <li><a href="#">Your FAQ's</a></li>
        <li><a href="#">Cancellation & Refunds</a></li>
        <li><a href="#">Contact US</a></li>
      </ul>
    </div>

    <!-- COLUMN 3 : CONTACT US -->
    <div class="footer-col">
      <h4>Contact Us</h4>
      <ul class="contact-info">
        <li><i class="fas fa-map-marker-alt"></i> 123 Main Street, City amman alyadodeh jawa -copinhagen california</li>
        <li><i class="fas fa-envelope"></i> info@ezyskills.com</li>
        <li><i class="fas fa-phone-alt"></i> +1 234 567 890</li> 
        <li><i class="fas fa-phone-alt"></i> +10000000000</li>
      </ul>
    </div>

    <!-- COLUMN 4 : SOCIAL MEDIA -->
   
  <!-- BOTTOM ROW -->
  <div class="footer-bottom">
  <div class="footer-bottom-left">
    <a href="#">Terms & Conditions</a>
    <a href="#">Privacy Policy</a>
  </div>

  <div class="footer-bottom-right">
    <div class="social-icons">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
  </div>
</div>
</div>

</footer>

</body>
</html>