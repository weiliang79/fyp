@extends('layouts.student.app_public')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Stripe Payment
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-4 border-end">
                                <h5>Order Details</h5>

                                <p class="mb-1">Student
                                    Name: {{ $order->student->first_name }} {{ $order->student->last_name }}</p>
                                <p class="mb-1">Total
                                    Price: {{ config('payment.currency_symbol') }}{{ $order->total_price }}</p>
                                <p class="mb-1">Pick-Up Date: {{ $order->pick_up_start->format('Y/m/d h:ia') }}
                                    to {{ $order->pick_up_end->format('Y/m/d h:ia') }}</p>

                                <table class="dataTable-cart table table-striped" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price({{ config('payment.currency_symbol') }})</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->product->name }}</td>
                                            <td>{{ $detail->price }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-8">

                                <img
                                    src="{{ asset('storage/defaults/Stripe_Logo/Stripe wordmark - blurple (small).png') }}"
                                    alt="Stripe Logo" style="width: 30%;">

                                <form action="" method="POST">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="" class="col-md-3 col-form-label text-md-end">Card Holder
                                            Name</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-text justify-content-center" style="width: 8%;">
                                                    <i class="fa-solid fa-id-card fa-fw"></i>
                                                </div>

                                                <input type="text" class="form-control" name="cardholder_name"
                                                       placeholder="Card Holder Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div id="payment-element">

                                        </div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-8 offset-md-3">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(async () => {

            stripe = await loadStripe('{{ config('cashier.key') }}');
            let elements = stripe.elements({
                clientSecret: "{{ $clientSecret }}",
            });

            console.log(elements);
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');

        });

    </script>

@endsection
