@extends('layout.master')

@section('content')
    <div class="page-title">
        <div class="title-env">
            <h1 class="title">@yield('page-title')</h1>
            <p class="description">@yield('page-description')</p>
        </div>
        <div class="breadcrumb-env text-right">

            <a href="javascript:;" onclick="jQuery('#calendar-event').modal('show', {backdrop: 'fade'});"
               class="breadcrumb btn btn-icon btn-white">
                <i class="fa fa-calendar"></i>
                <span class="hidden-xs">Calendar Event</span>
            </a>

            <div class="btn-group">
                <button type="button"
                        class="breadcrumb btn btn-icon dropdown-toggle {{ $customer->getServicesPaths() ? 'btn-black' : 'btn-white' }}"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <span class="hidden-xs">Services</span>
                    <i class="fa fa-fw fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    @if(auth()->user()->hasAnyPermission([
                        'create_energy',
                        'edit_energy',
                        'read_energy',
                    ]))
                        <li>
                            <a href="/customers/{{ $customer->id }}/energy"
                               class="breadcrumb btn btn-icon">
                                <i class="fa fa-fw fa-flash"></i>
                                <span class="">Energy</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasAnyPermission([
                        'create_mobile',
                        'edit_mobile',
                        'read_mobile',
                    ]))
                        <li>
                            <a href="/customers/{{ $customer->id }}/mobile"
                               class="breadcrumb btn btn-icon">
                                <i class="fa fa-fw fa-mobile"></i>
                                <span class="">Mobile</span>
                            </a>
                        </li>
                    @endif

                        @if(auth()->user()->hasAnyPermission([
                            'create_fixed_line',
                            'edit_fixed_line',
                            'read_fixed_line',
                        ]))
                            <li>
                                <a href="/customers/{{ $customer->id }}/fixed-line"
                                   class="breadcrumb btn btn-icon">
                                    <i class="fa fa-fw fa-phone"></i>
                                    <span class="">Fixed Line</span>
                                </a>
                            </li>
                        @endif



                    @if(auth()->user()->hasAnyPermission([
                        'create_journey_team_survey',
                    ]))
                        <li>
                            <a href="/customers/{{ $customer->id }}/journey-team-survey"
                               class="breadcrumb btn btn-icon">
                                <i class="fa fa-fw fa-pencil-square-o "></i>
                                <span class="">Journey Team Survey</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            {{--<a href="/customers/{{ $customer->id }}/contacts"--}}
               {{--class="breadcrumb btn btn-icon {{ request()->is('customers/' . $customer->id . '/contacts*') ? 'btn-black' : 'btn-white' }}">--}}
                {{--<i class="fa fa-fw fa-book"></i>--}}
                {{--<span class="hidden-xs">Contacts</span>--}}
            {{--</a>--}}

            {{--<a href="/customers/{{ $customer->id }}/sites"--}}
               {{--class="breadcrumb btn btn-icon {{ request()->is('customers/' . $customer->id . '/sites*') ? 'btn-black' : 'btn-white' }}">--}}
                {{--<i class="fa fa-fw fa-home"></i>--}}
                {{--<span class="hidden-xs">Sites</span>--}}
            {{--</a>--}}

            <a href="/customers/{{ $customer->id }}"
               class="breadcrumb btn btn-icon {{ request()->is('customers/' . $customer->id) ? 'btn-black' : 'btn-white' }}">
                <i class="fa fa-fw fa-eye"></i>
                <span class="hidden-xs">Details</span>
            </a>

            <a href="/customers/{{ $customer->id }}/edit"
               class="breadcrumb btn btn-icon {{ request()->is('customers/' . $customer->id . '/edit*') ? 'btn-black' : 'btn-white' }}">
                <i class="fa fa-edit"></i>
            </a>
        </div>
    </div>

    <br>

    @yield('subcontent')
@endsection

@section('scripts')
    @parent

    <div class="modal fade" id="calendar-event">
        <div class="modal-dialog border-top-success">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Calendar Event</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="saveEvent">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type">
                                        <option value="danger" selected>Important</option>
                                        <option value="purple">Bill Request</option>
                                        <option value="info">Bill Received</option>
                                        <option value="warning">Basic</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Date and Time</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" name="date_time" class="form-control" id="eventDate">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Title</label>

                                    <input class="form-control" type="text" name="title">
                                </div>

                                <div class="form-group">
                                    <label>Content</label>

                                    <textarea class="form-control" cols="30" rows="10"
                                              name="body"></textarea>
                                </div>

                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                <button type="submit" class="btn btn-success pull-right">Save</button>

                            </form>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 ">
                            <div id="errors" class="alert alert-danger">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $('#errors').hide();

            $('#eventDate').datetimepicker({
                timeFormat: 'HH:mm:ss',
                showSecond: false,
                stepMinute: 5,
                hourMin: 5,
                hourMax: 22,
            });

            $('#saveEvent').submit(function (e) {
                e.preventDefault();

                $('#errors').empty();

                let data = $('#saveEvent').serialize()

                let user_id = "{{ auth()->user()->id }}";

                axios.post('/calendar/' + user_id + '/events', data)
                    .then(function (response) {
                        $('#calendar-event').modal('toggle');

                        $('#errors').empty().hide();
                    })
                    .catch(function (errors) {
                        let errorBlock = $('#errors');

                        errorBlock.show();

                        $.each(errors.response.data, function (index, value) {
                            errorBlock.append('<p>' + value + '</p>')
                        });
                    });
            });
        });
    </script>
@endsection
