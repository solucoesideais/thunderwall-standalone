@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Files</div>

                    <div class="panel-body">
                        <table class="table table-bordered table-condensed text-center">
                            <thead>
                            <tr>
                                <td>{{ __('Name') }}</td>
                                <td>{{ __('Path') }}</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ $file->path }}</td>
                                    <td>
                                        <a href="{{$file->path('/sections')}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
