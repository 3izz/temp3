@include('navbar')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('prising.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="background-curve"></div>
    <div class="dots-decoration left-dots"></div>
    <div class="dots-decoration right-dots"></div>

    <div class="container">
        <h1 class="main-title">Our <span class="highlight">Pricing</span></h1>

        <div class="pricing-wrapper">
            @forelse($plans as $plan)
                <div class="card {{ $plan->is_popular ? 'featured' : '' }}">
                    <div class="badge">{{ $plan->name }}</div>

                    <div class="card-header">
                        <div class="price">$ {{ number_format($plan->price, 2) }} <span class="tax">+ Tax</span></div>
                        <div class="subtext">(Exclusive of GST & Taxes)</div>
                    </div>

                    <div class="card-body">
                        <ul class="features">
                            <li>
                                <i class="fa-solid fa-{{ $plan->target_type === 'group' ? 'school' : 'user' }}"></i>
                                <span>
                                    @if($plan->target_type === 'group')
                                        For Colleges, Universities <br>& Group Of Students
                                    @else
                                        1-1 Individuals
                                    @endif
                                </span>
                            </li>
                            <li>
                                <i class="fa-regular fa-calendar-{{ $plan->schedule_type === 'fixed' ? 'days' : ($plan->schedule_type === 'choose' ? 'check' : 'plus') }}"></i>
                                <span>
                                    {{ ucfirst($plan->schedule_type) }} Timings
                                </span>
                            </li>
                            
                            @if($plan->courses->count() > 0)
                                <li>
                                    <i class="fa-solid fa-book"></i>
                                    <span>
                                        Includes {{ $plan->courses->count() }} Course(s)
                                        <ul class="course-list">
                                            @foreach($plan->courses as $course)
                                                <li>• {{ $course->title }}</li>
                                            @endforeach
                                        </ul>
                                    </span>
                                </li>
                            @endif
                        </ul>

                        @if(auth()->check())
                            <a href="{{ route('pricing.select-courses', $plan->id) }}" class="btn">Choose Plan</a>
                        @else
                            <a href="{{ route('login') }}" class="btn">Login to Choose Plan</a>
                        @endif

                        <div class="logo">
                            <i class="fa-solid fa-bolt"></i> العز للدفع عند الاستلام
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-plans">
                    <p>No pricing plans available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    @include('footer')
</body>
</html>