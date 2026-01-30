 @include('navbar')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .checkout-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .checkout-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .checkout-content {
                grid-template-columns: 1fr;
            }
        }
        
        .order-summary, .payment-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        
        .package-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .course-item {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .course-item:hover {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .course-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .course-instructor {
            color: #666;
            font-size: 0.9rem;
        }
        
        .price-summary {
            background: #e8f5e8;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border: 2px solid #28a745;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .price-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
            border-top: 2px solid #28a745;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .payment-method {
            margin-bottom: 20px;
        }
        
        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-option:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .payment-option input[type="radio"] {
            margin-right: 15px;
        }
        
        .payment-option.selected {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .terms-section {
            margin: 20px 0;
        }
        
        .submit-section {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 25px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    
    
    <div class="checkout-container">
        <!-- Checkout Header -->
        <div class="checkout-header">
            <h1><i class="fas fa-shopping-cart"></i> Checkout</h1>
            <p>Review your selection and complete your enrollment</p>
        </div>
        
        <!-- Error/Success Messages -->
        @if($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Checkout Content -->
        <div class="checkout-content">
            <!-- Order Summary -->
            <div class="order-summary">
                <h2 class="section-title"><i class="fas fa-list-alt"></i> Order Summary</h2>
                
                <!-- Package Information -->
                <div class="package-info">
                    <h3 style="color: #667eea; margin-bottom: 10px;">
                        {{ $checkoutData['pricing_plan']['name'] }}
                    </h3>
                    <p style="margin: 0 0 10px 0;">{{ $checkoutData['pricing_plan']['description'] }}</p>
                    <p style="margin: 0; font-weight: bold;">
                        Includes up to {{ $checkoutData['pricing_plan']['max_courses'] }} course(s)
                    </p>
                </div>
                
                <!-- Selected Courses -->
                <h3 style="margin-bottom: 15px; color: #333;">
                    <i class="fas fa-graduation-cap"></i> Selected Courses ({{ count($checkoutData['selected_courses']) }})
                </h3>
                
                @foreach($checkoutData['courses_details'] as $course)
                    <div class="course-item">
                        <div class="course-title">{{ $course['title'] }}</div>
                        <div class="course-instructor">
                            <i class="fas fa-user-tie"></i> {{ $course['instructor'] }}
                        </div>
                        @if($course['description'])
                            <div style="margin-top: 8px; color: #666; font-size: 0.9rem;">
                                {{ Str::limit($course['description'], 100) }}
                            </div>
                        @endif
                    </div>
                @endforeach
                
                <!-- Price Summary -->
                <div class="price-summary">
                    <div class="price-row">
                        <span>Package Price:</span>
                        <span>${{ number_format($checkoutData['pricing_plan']['price'], 2) }}</span>
                    </div>
                    <div class="price-row">
                        <span>Number of Courses:</span>
                        <span>{{ count($checkoutData['selected_courses']) }}</span>
                    </div>
                    <div class="price-row">
                        <span>Taxes:</span>
                        <span>Calculated at payment</span>
                    </div>
                    <div class="price-row price-total">
                        <span>Total Amount:</span>
                        <span>${{ number_format($checkoutData['pricing_plan']['price'], 2) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Payment Form -->
            <div class="payment-form">
                <h2 class="section-title"><i class="fas fa-credit-card"></i> Payment Information</h2>
                
                <form method="POST" action="{{ route('checkout.process') }}">
                    @csrf
                    
                    <!-- Payment Method Selection -->
                    <div class="payment-method">
                        <h3 style="margin-bottom: 15px; color: #333;">Select Payment Method</h3>
                        
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="credit_card" required>
                            <div style="flex: 1;">
                                <i class="fas fa-credit-card"></i> Credit/Debit Card
                                <div style="font-size: 0.9rem; color: #666; margin-top: 5px;">
                                    Visa, Mastercard, American Express
                                </div>
                            </div>
                        </label>
                        
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="paypal" required>
                            <div style="flex: 1;">
                                <i class="fab fa-paypal"></i> PayPal
                                <div style="font-size: 0.9rem; color: #666; margin-top: 5px;">
                                    Fast and secure payment
                                </div>
                            </div>
                        </label>
                        
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="bank_transfer" required>
                            <div style="flex: 1;">
                                <i class="fas fa-university"></i> Bank Transfer
                                <div style="font-size: 0.9rem; color: #666; margin-top: 5px;">
                                    Direct bank deposit
                                </div>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="terms-section">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="terms_accepted" value="accepted" required style="margin-right: 10px;">
                            <span style="font-size: 0.9rem;">
                                I agree to the <a href="#" style="color: #667eea;">Terms and Conditions</a> 
                                and <a href="#" style="color: #667eea;">Privacy Policy</a>
                            </span>
                        </label>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="submit-section">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-lock"></i> Complete Payment
                        </button>
                        
                        <form method="POST" action="{{ route('checkout.cancel') }}" style="display: inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Payment method selection
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option input[type="radio"]');
            
            paymentOptions.forEach(option => {
                option.addEventListener('change', function() {
                    // Remove selected class from all options
                    document.querySelectorAll('.payment-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    
                    // Add selected class to chosen option
                    if (this.checked) {
                        this.closest('.payment-option').classList.add('selected');
                    }
                });
            });
            
            // Set first option as selected by default
            if (paymentOptions.length > 0 && !paymentOptions[0].checked) {
                paymentOptions[0].checked = true;
                paymentOptions[0].closest('.payment-option').classList.add('selected');
            }
        });
    </script>
    
    @include('footer')
</body>
</html>
