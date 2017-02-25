<div class="panel panel-default">
    <div class="panel-heading">
        Revision history
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <ul>
                @if(count($revisionHistory))
                @foreach($revisionHistory as $history)
                @if($history->key == 'created_at' && !$history->old_value)
                <li>
                    @if ($history->userResponsible())
                    <strong>{{ $history->userResponsible()->fullName() }}</strong> created this resource at {{ $history->newValue() }}
                    @else
                    <strong>DB Seed</strong> created this resource at {{ $history->newValue() }}
                    @endif
                </li>
                @else
                <li>
                    <strong>{{ $history->userResponsible()->fullName() }}</strong> changed {{ $history->fieldName() }} from <strong>{{ $history->oldValue() }}</strong> to <strong>{{ $history->newValue() }}</strong> at {{ $history->created_at}}
                </li>
                @endif
                @endforeach
                @else
                <li>
                    Nothing to See Here!
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
