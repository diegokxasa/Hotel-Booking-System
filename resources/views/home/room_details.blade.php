<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    @include('home.css')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            background-color: #f1f3f6;
            font-family: Arial, sans-serif;
        }

        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .room-left,
        .room-right {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .room-left {
            flex: 1 1 60%;
        }

        .room-right {
            flex: 1 1 35%;
        }

        .room-img img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .room-details h2 {
            margin-bottom: 15px;
            font-size: 24px;
            color: #333;
        }

        .room-details p {
            margin-bottom: 8px;
            font-size: 15px;
            color: #555;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 5px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-back {
            display: inline-block;
            padding: 8px 18px;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        .booking-form h3 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .booking-form .form-group {
            margin-bottom: 12px;
        }

        .booking-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .booking-form input {
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .booking-form button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .booking-form button:hover {
            background-color: #218838;
        }

        #card-element {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        #card-errors {
            color: red;
            margin-top: 5px;
        }

        .alert-success,
        .alert-error {
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 15px;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-error {
            background-color: #dc3545;
            color: white;
        }

        .booking-form {
            background: #fff;
            /* خلفية بيضاء للفورم */
            padding: 25px;
            /* مساحة داخلية مريحة */
            border-radius: 12px;
            /* حواف مستديرة */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* ظل خفيف */
        }

        .booking-form .form-group {
            margin-bottom: 15px;
            /* مسافة بين كل حقل */
        }

        .booking-form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        .booking-form input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
            /* يضمن إن padding ضمن العرض */
        }

        .booking-form button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .booking-form button:hover {
            background-color: #218838;
        }

        @media (max-width: 991px) {
            .room-container {
                flex-direction: column;
            }

            .room-left,
            .room-right {
                flex: 1 1 100%;
            }
        }

    </style>
</head>

<body class="main-layout">
    @include('home.header')

    <div class="container">
        <div class="room-container">
            <!-- العمود الأيسر: صورة الغرفة + البيانات -->
            <div class="room-left">
                <div class="room-img">
                    <img src="{{ asset($room->image) }}" alt="{{ $room->room_title }}">
                </div>
                <div class="room-details">
                    <h2>{{ $room->room_title }}</h2>
                    <p><strong>Room Type:</strong> {{ $room->room_type }}</p>
                    <p><strong>Description:</strong> {{ $room->description }}</p>
                    <p><strong>Price:</strong> ${{ $room->price }}</p>
                    <p><strong>WiFi:</strong>
                        @if (strtolower($room->wifi) == 'yes')
                            <span class="badge badge-success">Available</span>
                        @else
                            <span class="badge badge-danger">Not Available</span>
                        @endif
                    </p>
                    <a href="{{ url()->previous() }}" class="btn-back">Back</a>
                </div>
            </div>

            <!-- العمود الأيمن: Booking Form -->
            <div class="room-right">
                <div class="card booking-form">
                    <h3>Book This Room</h3>

                    @if (session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert-error">{{ session('error') }}</div>
                    @endif

                    <form id="booking-form" action="{{ url('add_booking', $room->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="payment_intent_id" id="payment_intent_id">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" required
                                value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required
                                value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" required value="{{ old('phone') }}">
                        </div>

                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" id="startDate" required
                                value="{{ old('start_date') }}">
                        </div>

                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" name="end_date" id="endDate" required
                                value="{{ old('end_date') }}">
                        </div>

                        <div class="form-group">
                            <label>Credit or debit card</label>
                            <div id="card-element"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <button type="submit" id="book-button">Book Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('home.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function() {
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10) month = '0' + month;
        if (day < 10) day = '0' + day;
        var minDate = year + '-' + month + '-' + day;
        $("#startDate").attr('min', minDate);
        $("#endDate").attr('min', minDate);
    });

    // Stripe JS
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('booking-form');
    const bookBtn = document.getElementById('book-button');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        bookBtn.disabled = true;

        // 1- إنشاء PaymentIntent من السيرفر
        const { client_secret, id } = await fetch('{{ route('booking.create_payment_intent', $room->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        }).then(r => r.json());

        // 2- تأكيد الدفع
        const result = await stripe.confirmCardPayment(client_secret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: form.name.value,
                    email: form.email.value
                }
            }
        });

        if (result.error) {
            document.getElementById('card-errors').textContent = result.error.message;
            bookBtn.disabled = false;
        } else if (result.paymentIntent.status === 'succeeded') {
            // 3- خزّن الـ PaymentIntent ID في الفورم
document.getElementById('payment_intent_id').value = result.paymentIntent.id;
            form.submit();
        }
    });
</script>

</body>

</html>
