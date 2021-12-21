@props(['buttonType'])
<button class="ui primary button" type="{{$buttonType}}">
    {{$slot}}
</button>
