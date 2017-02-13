<div class="panel panel-default">
    <div class="panel-heading">
        Revision history
    </div>
    <div class="panel-body">
        <div class="panel-body">
            @foreach($revisionHistory as $history)
            @if($history->key == 'created_at' && !$history->old_value)
            @if($history->userResponsible() != null)
            <li><b>{{ $history->userResponsible()->fullName() }}</b> created this resource at {{ $history->newValue() }}</li>
            @else
            <li><b>DELETED</b> created this resource at {{ $history->newValue() }}</li>
            @endif
            @else
            @if($history->userResponsible() != null)
            <li><b>{{ $history->userResponsible()->fullName() }}</b> changed {{ $history->fieldName() }} from {{ $history->oldValue() }} to {{ $history->newValue() }} at {{ $history->created_at}}</li>
            @else
            <li><b>DELETED</b> changed {{ $history->fieldName() }} from {{ $history->oldValue() }} to {{ $history->newValue() }} at {{ $history->created_at}}</li>
            @endif
            @endif
            @endforeach
        </div>
    </div>
</div>
