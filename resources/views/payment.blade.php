@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Details (Demo Purpose Only)</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('makePayment') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                <small class="text-muted">(Please enter a valid email to get a confirmation over email)</small>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone No.</label>
                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone">
                                <small class="text-muted">(Please enter a valid phone no. to get a confirmation SMS)</small>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>
                            <div class="col-md-6">
                                <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" autocomplete="amount" autofocus>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-md-center">
                                <button type="submit" class="btn btn-primary">
                                    Make Payment
                                </button>
                            </div>
                        </div>

                        @if (Session::has('errorMessage'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{Session::get('errorMessage')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if (Session::has('successMessage'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{Session::get('successMessage')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @php($responseData = Session::get('responseData'))
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="2">Payment Informations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="col">Payment ID</th>
                                    <td scope="col">{{$responseData['payment_id']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Status</th>
                                    <td scope="col">{{$responseData['status']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Amount</th>
                                    <td scope="col">{{$responseData['amount']}} {{$responseData['currency']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Buyer Nmae</th>
                                    <td scope="col">{{$responseData['buyer_name']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Phone</th>
                                    <td scope="col">{{$responseData['buyer_phone']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Email</th>
                                    <td scope="col">{{$responseData['buyer_email']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Payment Method</th>
                                    <td scope="col">{{$responseData['instrument_type']}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Time</th>
                                    <td>{{$responseData['created_at']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
