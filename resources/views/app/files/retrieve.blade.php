@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ __('Import file from disk') }}</div>

                    <div class="panel-body">
                        <form method="POST" action="/files/retrieve">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>{{ __('Path') }}</label>
                                <input class="form-control" type="text" name="path"/>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="{{ __('Retrieve') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
