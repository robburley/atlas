@extends('layout.master')

@section('title')
    Questions &middot; Atlas
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h2 class="m-b-0 m-t-5">
                <i class="fa fa-fw fa-question"></i>
                Questions
            </h2>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Question</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($questions as $question)
                                    <tr>
                                        <td class="v-mid">
                                            {{ $question->user->name }}
                                        </td>

                                        <td class="v-mid">
                                            {{ $question->question }}
                                        </td>


                                        <td class="v-mid">
                                            {{ $question->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">There are currently no questions.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $questions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection
