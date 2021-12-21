@props(['input', 'error' => ''])

<div class="ui fluid form">
    <div class="field">
        {!! $input !!}
        <div class="ui pointing label {{$error}}">
            {{$slot}}
        </div>
    </div>
</div>
