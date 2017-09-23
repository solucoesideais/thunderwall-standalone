@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @if(! Disk::writable($file))
                    <div class="alert alert-danger">
                        <i class="fa fa-warning"></i> {{ __('Permission denied to file :file', ['file' => $file->path]) }}
                    </div>
                @endif

                <form method="POST" action="/modules/firewall/{{ $file->id }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h5 class="flex">
                                    {{ $file->name }} <span class="small">{{ $file->path }}</span>
                                </h5>
                            </div>
                        </div>

                        <div class="panel-body">
                            @foreach($file->sections as $section)
                                <div class="form-group">
                                    <textarea class="form-control" name="firewall" cols="5"
                                              rows="14">{{ $section->content }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        @if(Disk::writable($file))
                            <div class="panel-footer">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="{{ __('Apply') }}">
                                </div>
                            </div>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
