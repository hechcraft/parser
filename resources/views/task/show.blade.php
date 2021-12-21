<x-app-layout>
    @if($page->type === 'single')
        @include('task.type.single')
    @elseif($page->type === 'groupMinPrice')
        @include('task.type.groupMinPrice')
    @else
        @include('task.type.groupNewPosition')
    @endif
</x-app-layout>
