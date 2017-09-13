@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $file->name }} ({{ $file->path }})
                        <span class="pull-right">
                            <a href="{{ $file->route('/sections/edit') }}"><i class="fa fa-pencil"></i></a>
                        </span>
                    </div>

                    <div class="panel-body">
                        {!! nl2br($file->content()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
