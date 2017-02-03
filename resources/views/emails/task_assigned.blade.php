<html>
    <head></head>
    <body>
        <h3>{{$comment->user()->name}} has commented on one of your task(s)!</h3>
        <h4>{{$task->name}}</h4>
        <p>{{$comment->content}}</p>
        <p>by : {{$comment->timestamp }}</p>
    </body>
</html>
