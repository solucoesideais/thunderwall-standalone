@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ __('Application Update') }}</div>

                    @if(session('output'))
                        <div class="alert alert-info">
                            {!!  nl2br(session('output')) !!}
                        </div>
                    @endif

                    <div class="panel-body">
                        @if($release['tag_name'] == config('app.version'))
                            <h4 class="text-success">{{ __('Your application is up to date!') }}</h4>
                        @else
                            <form action="/version/update" method="POST">
                                {{ csrf_field() }}

                                <h4>{{ __('Version :v', ['v' => $release['tag_name']]) }}</h4>
                                <p>
                                    {!! nl2br($release['body']) !!}
                                </p>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-warning" value="{{ __('Update now') }}">
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
