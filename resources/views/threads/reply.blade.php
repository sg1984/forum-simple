<div class="panel panel-default">
    <div class="panel-heading">
        <strong>
            @if( $reply->isThisMine() )
                You
                {!! Form::model($reply, ['method' => 'delete', 'route' => ['reply.delete', $reply], 'class' =>'form-inline form-delete']) !!}
                <a href="#" class="pull-right small delete">
                    Delete
                </a>
                {!! Form::close() !!}
                <a href="{{ route('reply.edit', [$reply]) }}" class="pull-right small">
                    Edit
                </a>
            @else
                {{ $reply->creator->name }}
            @endif
        </strong>
        said {{ $reply->created_at->diffForHumans() }}...
    </div>
    <div class="panel-body">
        {!! nl2br($reply->body) !!}
    </div>
</div>
