@extends('layouts.student.app_public')

@section('content')

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Order History
                    </div>

                    <div class="card-body">

                        <div class="row my-4">
                            <div class="col">

                                @if(count($orders) === 0)
                                    <p class="mb-1 text-center">You haven't made any order before, <a
                                            href="{{ route('student.menus') }}">visit menus page</a></p>
                                @else
                                    <div class="accordion" id="orderAccordion">
                                        @for($i = 0; $i < count($orders); $i++)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $i }}">
                                                    <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}"
                                                            aria-expanded="false" aria-controls="collapse{{ $i }}">

                                                        <div class="d-flex justify-content-between mx-4"
                                                             style="width: 100%;">
                                                            <div>Pick Up
                                                                Time: {{ $orders[$i]->pick_up_start->format('Y-m-d H:i A') }}
                                                                to {{ $orders[$i]->pick_up_end->format('Y-m-d H:i A') }}</div>
                                                            <div>{{ config('payment.currency_symbol') }}{{ $orders[$i]->total_price }}</div>
                                                            <div class="{{ $orders[$i]->status == \App\Models\Order::PAYMENT_FAILURE ? 'text-danger' : '' }}{{ $orders[$i]->status == \App\Models\Order::PAYMENT_SUCCESS ? 'text-success' : '' }}">
                                                                {{ $orders[$i]->getStatusString() }}
                                                            </div>
                                                        </div>

                                                    </button>
                                                </h2>
                                                <div id="collapse{{ $i }}" class="accordion-collapse collapse"
                                                     aria-labelledby="heading{{ $i }}" data-bs-parent="#orderAccordion">
                                                    <div class="accordion-body">

                                                        @if($orders[$i]->status === \App\Models\Order::PAYMENT_PENDING || $orders[$i]->status === \App\Models\Order::PAYMENT_FAILURE)
                                                            <div class="text-danger text-center mb-4">
                                                                <i class="fa-solid fa-circle-exclamation fa-lg"></i> The
                                                                payment is not complete, please go to <a
                                                                    href="{{ route('student.checkout', ['order_id' => $orders[$i]]) }}">Checkout
                                                                    Page</a>.
                                                            </div>
                                                        @endif

                                                        <div class="card mb-4">
                                                            <div class="card-header">
                                                                Order Details
                                                            </div>

                                                            <div class="card-body">

                                                                <table class="dataTable-cart table table-stripped"
                                                                       style="width: 100%;">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Product</th>
                                                                        <th>Option</th>
                                                                        <th>Notes</th>
                                                                        <th>
                                                                            Price({{ config('payment.currency_symbol') }})
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($orders[$i]->orderDetails as $detail)
                                                                        <tr>
                                                                            <td>{{ $detail->product->name }}</td>
                                                                            <td>
                                                                                @foreach($detail->product_options as $option)
                                                                                    @foreach($option as $key => $value)
                                                                                        {{ App\Models\ProductOption::find($key)->name }}: {{ App\Models\OptionDetail::find($value)->name }}
                                                                                        <br>
                                                                                    @endforeach
                                                                                @endforeach
                                                                            </td>
                                                                            <td>{{ $detail->notes ? $detail->notes : 'None' }}</td>
                                                                            <td>{{ $detail->price }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>

                                                        @foreach($orders[$i]->payments()->orderBy('created_at', 'desc')->get() as $payment)
                                                            <div class="card @if(!$loop->last) mb-4 @endif">
                                                                <div class="card-header">
                                                                    Payment # {{ $payment->created_at->format('Y-m-d h:i A') }}
                                                                </div>

                                                                <div class="card-body">

                                                                    <div class="row">

                                                                        <div class="col-6">
                                                                            <ul class="list-group">
                                                                                <li class="list-group-item d-flex justify-content-between">
                                                                                    <p class="mb-1">Payment Type</p>
                                                                                    <p class="mb-1">{{ $payment->payment_type_id == \App\Models\PaymentType::PAYMENT_2C2P ? '2C2P' : 'Stripe' }}</p>
                                                                                </li>
                                                                                <li class="list-group-item d-flex justify-content-between">
                                                                                    <p class="fw-bold mb-1">Amount</p>
                                                                                    <p class="fw-bold mb-1">{{ config('payment.currency_symbol') }}{{ $payment->amount }}</p>
                                                                                </li>
                                                                                <li class="list-group-item d-flex justify-content-between">
                                                                                    <p class="mb-1">Status</p>
                                                                                    <p class="mb-1">
                                                                                        {{ $payment->getStatusString() }}
                                                                                    </p>
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <ul class="list-group">
                                                                                @if($payment->payment_type_id == \App\Models\PaymentType::PAYMENT_2C2P)
                                                                                    <li class="list-group-item d-flex justify-content-between">

                                                                                        <p class="mb-1">Invoice No</p>
                                                                                        <p class="mb-1">
                                                                                            {{ $payment->paymentDetail2c2p->invoice_no }}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                                        <p class="mb-1">Transaction Time</p>
                                                                                        <p class="mb-1">
                                                                                            {{ $payment->paymentDetail2c2p->transaction_time->format('Y-m-d H:i A') }}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                                        <p class="mb-1">Agent Code</p>
                                                                                        <p class="mb-1">
                                                                                            {{ $payment->paymentDetail2c2p->agent_code ?: 'None' }}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                                        <p class="mb-1">Channel Code</p>
                                                                                        <p class="mb-1">
                                                                                            {{ $payment->paymentDetail2c2p->channel_code ?: 'None' }}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                                        <p class="mb-1">Reference No</p>
                                                                                        <p class="mb-1">
                                                                                            {{ $payment->paymentDetail2c2p->reference_no ?: 'None' }}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                                        <p class="mb-1">Transaction Reference</p>
                                                                                        <p class="mb-1">
                                                                                            {{ $payment->paymentDetail2c2p->tran_ref ?: 'None' }}
                                                                                        </p>
                                                                                    </li>
                                                                                @else

                                                                                    @if($payment->status === \App\Models\Payment::STATUS_SUCCESS)
                                                                                        @php $paymentMethod = auth()->guard('student')->user()->findPaymentMethod($payment->paymentDetailStripe->payment_method_id) @endphp

                                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                                            <p class="mb-1">Payment
                                                                                                Processing Method</p>
                                                                                            <p class="mb-1">{{ $paymentMethod->type }} - {{ $paymentMethod->card->brand }}</p>
                                                                                        </li>
                                                                                        <li class="list-group-item d-flex justify-content-between">
                                                                                            <p class="mb-1">Transaction Time</p>
                                                                                            <p class="mb-1">{{ \Carbon\Carbon::createFromTimestamp($paymentMethod->created)->format('Y-m-d H:i A') }}</p>
                                                                                        </li>
                                                                                    @endif

                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                            @endif

                                    </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
