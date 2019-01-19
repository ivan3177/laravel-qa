@if ($model instanceof App\Question)
@php
$name = 'question';
$firstUriSegment = 'questions';
@endphp
@elseif ($model instanceof App\Answer)
@php
$name = 'answer';
$firstUriSegment = 'answers';
@endphp
@endif

@php
$formId = $name . $model->id;
$formAction = "/{$firstUriSegment}/{$model->id}/vote";
@endphp

<div class="d-flex flex-column vote-controls">
    <a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : ''}}" onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit();">
        <i class="far fa-thumbs-up fa-2x"></i>
    </a>
    <form style="display: none;" id="up-vote-{{ $formId }}" action="{{ $formAction }}" method="post">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="votes-count">{{ $model->votes_count }}</span>

    <a class="vote-down {{ Auth::guest() ? 'off' : ''}}" title=" This {{ $name }} is not useful" onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit();">
        <i class="far fa-thumbs-down fa-2x"></i>
    </a>
    <form style="display: none;" id="down-vote-{{ $formId }}" action="{{ $formAction }}" method="post">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if ($model instanceof App\Question)
    @include('shared._favorite', ['model' => $model])
    @elseif ($model instanceof App\Answer)
    @include('shared._accept', ['model' => $model])
    @endif
</div>