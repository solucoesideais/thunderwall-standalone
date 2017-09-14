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
                                <td>{{ __('Sync') }}</td>
                                <td>{{ __('Open') }}</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ $file->path }}</td>
                                    <td>
                                        @if($file->synchronized)
                                            <i class="fa fa-check text-success"></i>
                                        @else
                                            <form method="POST" action="{{ $file->route('/commit') }}">
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-warning"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{$file->route('/sections')}}">
                                            <i class="fa fa-file"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger disabled" href="#">
                                            <i class="fa fa-eraser"></i>
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
