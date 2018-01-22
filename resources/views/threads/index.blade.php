@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Threads
                        @if(auth()->check())
                            <a href="{{ route('thread.new') }}" class="pull-right">
                                + Add Thread
                            </a>
                        @endif
                    </div>

                    <div class="panel-body">
                        @if(isset($category))
                            <p>Showing threads in category <strong>"{{ $category }}"</strong></p>
                            <hr>
                        @endif

                        @if(isset($searchTerm))
                            <p>Results from search by the term <strong>"{{ $searchTerm }}"</strong></p>
                            <hr>
                        @endif

                        @foreach($threads as $thread)
                            <article>
                                <small>
                                    Category: <strong>{{ $thread->category }}</strong>
                                </small>
                                <h4>
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                    <span class="badge badge-pill badge-light pull-right">{{ $thread->replies()->count() }}</span>
                                </h4>
                                <p class="small pull-right">
                                    By <strong>{{ $thread->creator->name }}</strong> at <strong>{{ $thread->getCreatedDateComplete() }}</strong>
                                </p>
                                <hr>
                            </article>
                        @endforeach

                    </div>
                    <div class="panel-footer">
                        <h5>
                            We have a total of <strong>{{ count($threads) }}</strong> threads. Join one of them or create a new one.
                        </h5>
                        {{ $threads->render() }}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <small>Categories</small>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <li class="m-b">
                                <a href="{{ route('home') }}">All</a>
                            </li>
                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $category)
                                    <li class="m-b">
                                        <a href="{{ route('thread.category', [$category]) }}">
                                            {{ $category }}
                                            <small class="pull-right">({{ \App\Thread::getCountByCategory($category) }})</small>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
