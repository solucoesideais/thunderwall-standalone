@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <h5 class="flex">
                                {{ $file->name }} <span class="small">{{ $file->path }}</span>

                                <div class="pull-right">
                                    <a class="" href="{{ $file->route('/sections/edit') }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </div>

                            </h5>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(!$file->sections->isEmpty())
                            {!! nl2br($file->content()) !!}
                        @else
                            <i class="text-muted">
                                # {!!  __('It appears this file is still empty. Would you like to <a href=":url">edit it</a>?',  ['url' => $file->route('/sections/edit')]) !!}
                            </i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
