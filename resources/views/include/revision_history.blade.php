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
                    <strong>{{ $history->userResponsible()->fullName() }}</strong> created this resource <small>at {{ $history->newValue() }}</small>
                </li>
                @else
                <li>
                    <strong>{{ $history->userResponsible()->fullName() }}</strong> changed {{ $history->fieldName() }} from <strong>{{ $history->oldValue() }}</strong> to <strong>{{ $history->newValue() }}</strong> <small>at {{ $history->created_at}}</small>
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
