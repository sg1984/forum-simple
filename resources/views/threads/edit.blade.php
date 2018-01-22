@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::open([ 'route' => 'thread.store' ]) !!}
                {!! Form::hidden('id', $thread->id) !!}
                <div class="form-group">
                    {!! Form::text(
                        'category',
                        $thread->category,
                        ['id' => "category", 'class' => 'form-control', 'placeholder' => 'Category', 'required'])
                    !!}
                </div>
                <div class="form-group">
                    {!! Form::text(
                        'title',
                        $thread->title,
                        ['id' => "title", 'class' => 'form-control', 'placeholder' => 'Title', 'required'])
                    !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea(
                        'body',
                        $thread->body,
                        ['id' => "body", 'class' => 'form-control', 'placeholder' => 'Have something to say?', 'rows' => 5, 'required'])
                    !!}
                </div>
                {!! Form::submit('Save Thread', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
