<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RSS Parser</title>
</head>
<body>
<div>
    @if (empty($error))
        <p>The term "Google" is referenced {{ $count }} times in the <a href="{{ $feed }}">{{ $feed }}</a> RSS feed.</p>
        <p>Below you find the {{ count($results) }} results:</p>
    @endif
    @if (empty($error))
        @foreach ($results as $i => $result)
            <div style="padding-bottom:20px">
                <h2>{{ $i + 1 }}: {!! $result['title'] !!}</h2>
                <p><a href="{{ $result['link'] }}">{{ $result['link'] }}</a></p>
                {!! $result['description'] !!}
            </div>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray;">
        @endforeach
    @else
        <h2>{{ $error }}</h2>
    @endif
</div>
</body>
</html>
