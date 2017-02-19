@if(Session::has('alert-danger') || Session::has('alert-warning') || Session::has('alert-success') || Session::has('alert-info') || count($errors) > 0)
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $message)
    @if(Session::has('alert-' . $message))
    <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endif
