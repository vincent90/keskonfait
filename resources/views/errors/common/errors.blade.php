@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Wow....that was a very simple task....how did you manage to fuck it up....?</strong>
    <br><br>

    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
