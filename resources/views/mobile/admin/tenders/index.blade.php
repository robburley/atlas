@extends('layout.master')

@section('title')
    Tenders &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-user"></i>
                Tenders
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Expiry Date / Time</th>
                                    <th>Recipients</th>
                                    <th>Complete</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                    @foreach($tenders as $tender)
                                        <tr>
                                            <td>
                                                {{ $tender->expires_at->format('d/m/Y H:i') }} ({{ $tender->expires_at->diffForHumans() }})
                                            </td>
                                            <td>
                                                {{ $tender->invitation->count() }}
                                            </td>
                                            <td>
                                                {{ $tender->completeInvitation->count() }}
                                            </td>
                                            <td>
                                                {{ $tender->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="/mobile/fulfilment/tenders/{{ $tender->id }}" class="btn btn-info pull-right btn-xs">
                                                    <i class="fa fa-search"></i>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $tenders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
    </script>
@endsection
