@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <form method="POST" action="{{ $file->route('/sections') }}">
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
                                    <textarea class="form-control" name="sections[{{ $loop->index }}][content]" cols="5"
                                              rows="8">{{ $section->content }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <textarea class="form-control" name="sections[{{ $file->sections->count() }}][content]" cols="5"
                                          rows="8"></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="{{ __('Save') }}">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
