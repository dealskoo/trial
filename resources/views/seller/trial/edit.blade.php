@extends('seller::layouts.panel')

@section('title', __('trial::trial.edit_trial'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('trial::trial.edit_trial') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('trial::trial.edit_trial') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seller.trials.update', $trial) }}" method="post">
                        @csrf
                        @method('PUT')
                        @if (!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if (!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">{{ __('trial::trial.title') }}</label>
                                <input type="text" class="form-control" id="title" name="title" required
                                       value="{{ old('title', $trial->title) }}" autofocus tabindex="1"
                                       placeholder="{{ __('trial::trial.title_placeholder') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">{{ __('trial::trial.product') }}</label>
                                <select id="product_id" name="product_id" class="form-control select2"
                                        data-toggle="select2"
                                        tabindex="2" required>
                                    @foreach ($products as $product)
                                        @if ($product->id == $trial->product_id)
                                            <option value="{{ $product->id }}" selected>{{ $product->name }}</option>
                                        @else
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="refund" class="form-label">{{ __('trial::trial.refund') }}</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                    <input type="number" class="form-control" id="refund" name="refund" required
                                           value="{{ old('refund', $trial->refund) }}" tabindex="3">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantity" class="form-label">{{ __('trial::trial.quantity') }}</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required
                                       value="{{ old('quantity',$trial->quantity) }}" tabindex="4"
                                       placeholder="{{ __('trial::trial.quantity_placeholder') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ship_fee" class="form-label">{{ __('trial::trial.ship_fee') }}</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                    <input type="number" class="form-control" id="ship_fee" name="ship_fee" required
                                           value="{{ old('ship_fee', $trial->ship_fee) }}" tabindex="5">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="activity_date" class="form-label">{{ __('trial::trial.start_at') }}
                                    - {{ __('trial::trial.end_at') }}</label>
                                <input type="text" class="form-control date" id="activity_date" name="activity_date"
                                       data-toggle="date-picker"
                                       value="{{ old('activity_date', \Carbon\Carbon::parse($trial->start_at)->format('m/d/Y') . ' - ' . \Carbon\Carbon::parse($trial->end_at)->format('m/d/Y')) }}"
                                       required tabindex="6">
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="7"><i
                                    class="mdi mdi-content-save"></i> {{ __('seller::seller.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
