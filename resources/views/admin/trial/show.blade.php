@extends('admin::layouts.panel')

@section('title', __('trial::trial.view_trial'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>

                        <li class="breadcrumb-item active">{{ __('trial::trial.view_trial') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('trial::trial.view_trial') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">{{ __('trial::trial.title') }}</label>
                            <input type="text" class="form-control" id="title" name="title" readonly
                                   value="{{ $trial->title }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">{{ __('trial::trial.product') }}</label>
                            <input type="text" class="form-control" id="product_id" name="product_id" readonly
                                   value="{{ $trial->product->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">{{ __('trial::trial.slug') }}</label>
                            <input type="text" class="form-control" id="slug" name="slug" readonly
                                   value="{{ $trial->slug }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="country_id" class="form-label">{{ __('trial::trial.country') }}</label>
                            <input type="text" class="form-control" id="country_id" name="country_id" readonly
                                   value="{{ $trial->country->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">{{ __('trial::trial.category') }}</label>
                            <input type="text" class="form-control" id="category_id" name="category_id" readonly
                                   value="{{ $trial->category->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="seller_id" class="form-label">{{ __('trial::trial.seller') }}</label>
                            <input type="text" class="form-control" id="seller_id" name="seller_id" readonly
                                   value="{{ $trial->seller->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand_id" class="form-label">{{ __('trial::trial.brand') }}</label>
                            <input type="text" class="form-control" id="brand_id" name="brand_id" readonly
                                   value="{{ $trial->brand->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="platform_id" class="form-label">{{ __('trial::trial.platform') }}</label>
                            <input type="text" class="form-control" id="platform_id" name="platform_id" readonly
                                   value="{{ $trial->platform->name }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="product_price"
                                   class="form-label">{{ __('trial::trial.product_price') }}</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                <input type="number" class="form-control" id="product_price" name="product_price"
                                       readonly
                                       value="{{ $trial->product->price }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="refund" class="form-label">{{ __('trial::trial.refund') }}</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                <input type="number" class="form-control" id="refund" name="refund" readonly
                                       value="{{ $trial->refund }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ship_fee" class="form-label">{{ __('trial::trial.ship_fee') }}</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text">{!! request()->country()->currency_symbol !!}</span>
                                <input type="number" class="form-control" id="ship_fee" name="ship_fee" readonly
                                       value="{{ $trial->ship_fee }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">{{ __('trial::trial.quantity') }}</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" readonly
                                   value="{{ $trial->quantity }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="activity_date" class="form-label">{{ __('trial::trial.start_at') }}
                                - {{ __('trial::trial.end_at') }}</label>
                            <input type="text" class="form-control date" id="activity_date" name="activity_date"
                                   value="{{ $trial->start_at->format('m/d/Y') . ' - ' . $trial->end_at->format('m/d/Y') }}"
                                   readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="approved_at"
                                   class="form-label">{{ __('trial::trial.approved_at') }}</label>
                            <input type="text" class="form-control" id="approved_at" name="approved_at" readonly
                                   value="{{ $trial->approved_at }}">
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>
@endsection
