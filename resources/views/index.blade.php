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
i


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