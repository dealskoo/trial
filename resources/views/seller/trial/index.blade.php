@extends('seller::layouts.panel')

@section('title',__('trial::trial.trials_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('trial::trial.trials_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('trial::trial.trials_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('seller.trials.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> {{ __('trial::trial.add_trial') }}
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="trials_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('trial::trial.id') }}</th>
                                <th>{{ __('trial::trial.title') }}</th>
                                <th>{{ __('trial::trial.refund') }}</th>
                                <th>{{ __('trial::trial.quantity') }}</th>
                                <th>{{ __('trial::trial.ship_fee') }}</th>
                                <th>{{ __('trial::trial.clicks') }}</th>
                                <th>{{ __('trial::trial.product') }}</th>
                                <th>{{ __('trial::trial.category') }}</th>
                                <th>{{ __('trial::trial.country') }}</th>
                                <th>{{ __('trial::trial.brand') }}</th>
                                <th>{{ __('trial::trial.platform') }}</th>
                                <th>{{ __('trial::trial.approved_at') }}</th>
                                <th>{{ __('trial::trial.start_at') }}</th>
                                <th>{{ __('trial::trial.end_at') }}</th>
                                <th>{{ __('trial::trial.created_at') }}</th>
                                <th>{{ __('trial::trial.updated_at') }}</th>
                                <th>{{ __('trial::trial.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#trials_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('seller.trials.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#trials_table tr td:nth-child(17)').addClass('table-action');
                    delete_listener();
                }
            });
            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
