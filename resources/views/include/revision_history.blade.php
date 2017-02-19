<div class="panel panel-default">
    <div class="panel-heading">
        Revision history
    </div>
    <div class="panel-body">
        <div class="panel-body">
            @foreach($revisionHistory as $history)
            @if($history->key == 'created_at' && !$history->old_value)
            <li ><strong>{{ $history->userResponsible()->fullName() }}</strong> created this resource at {{ $history->newValue() }}</li>
            @else
            <li><strong>{{ $history->userResponsible()->fullName() }}</strong> changed {{ $history->fieldName() }} from <strong>{{ $history->oldValue() }}</strong> to <strong>{{ $history->newValue() }}</strong> at {{ $history->created_at}}</li>
            @endif
            @endforeach
        </div>
    </div>
</div>
