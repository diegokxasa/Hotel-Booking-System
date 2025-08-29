@extends('layouts.app')

@section('content')
<h2>Checkout - {{ $room->room_title }}</h2>
<p>Price: ${{ $room->price }}</p>

<form id="payment-form" method="POST" action="{{ route('checkout.process', $room->id) }}">
    @csrf
    <input type="hidden" name="start_date" value="{{ old('start_date', session('start_date')) }}">
    <input type="hidden" name="end_date" value="{{ old('end_date', session('end_date')) }}">
    <label>Card Details</label>
    <div id="card-element"></div>
    <button type="submit">Pay ${{ $room->price }}</button>
</form>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const {paymentMethod, error} = await stripe.createPaymentMethod('card', card);
        if(error){
            alert(error.message);
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'payment_method_id');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    });
</script>
@endsection
