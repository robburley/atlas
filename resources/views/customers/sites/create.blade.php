@extends('customers.layout')

@section('title')
    Add Site &middot; {{ $customer->company_name }} &middot; Atlas
@endsection

@section('page-title')
    {{ $customer->company_name }}
@endsection

@section('page-description')
    Add a new site
@endsection

@section('subcontent')
    {!! Form::open(['action' => ['Customer\CustomerSiteController@store', $customer->id], 'role' => 'form', 'class' => 'form-horizontal']) !!}
        @include('customers.sites.form')

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group text-right">
                        <div class="col-sm-12">
                            <a href="/customers/{{ $customer->id }}/sites" class="btn btn-primary btn-icon btn-icon-standalone">
                                <i class="fa fa-fw fa-arrow-left"></i>
                                <span>Back</span>
                            </a>

                            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                                <i class="fa fa-fw fa-save"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("select .select2-search").select2();

            $("select .select2").select2({
                minimumResultsForSearch: Infinity
            });
        });
    </script>


@endsection
