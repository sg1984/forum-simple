@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if( $thread->isThisThreadMine() )
                            <strong>You</strong> posted:
                        @else
                            <strong>{{ $thread->creator->name }}</strong> posted:
                        @endif
                        <span class="pull-right small"> At <strong>{{ $thread->getCreatedDateComplete() }}</strong></span>
                        <br>
                        <small class="pull-right">
                            Category: <strong>{{ $thread->category }}</strong>
                        </small>

                        <h4>
                            {{ $thread->title }}
                            @if( $thread->isThisThreadMine() )
                                {!! Form::model($thread, ['method' => 'delete', 'route' => ['thread.delete', $thread], 'class' =>'form-inline form-delete']) !!}
                                <a href="#" class="pull-right small delete">
                                    Delete
                                </a>
                                {!! Form::close() !!}
                                <a href="{{ route('thread.edit', [$thread]) }}" class="pull-right small">
                                    Edit
                                </a>
                            @endif
                        </h4>
                    </div>
                    <div class="panel-body">
                        {!! nl2br($thread->body) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-md-offset-3">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row">
                <div class="col-md-7 col-md-offset-3">
                    {!! Form::open([ 'route' => ['thread.reply', $thread] ]) !!}
                    {!! Form::textarea(
                        'body',
                        old('body'),
                        ['id' => "body", 'class' => 'form-control', 'placeholder' => 'Have something to say?', 'rows' => 5])
                    !!}
                    {!! Form::submit('Post', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign in </a> to participate in this discussion.</p>
        @endif
    </div>
@endsection
