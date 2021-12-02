<x-app-layout>
    <div class="ui three stackable cards">
        @foreach($minPrice as $item)
            <div class="card">
                <img src="{{$item->offer->image_url}}" class="visible content">
                <div class="content">
                    <a class="header">{{$item->offer->name}}</a>
                    <div class="meta">
                        <span>Цена: {{$item->price_str}}</span> <br>
                        @if($item->offer->page->type === "single")
                            <span>Тип: Одиночная</span>
                        @elseif($item->offer->page->type === "groupMinPrice")
                            <span>Тип: Поиск минимальной цены</span>
                        @else
                            <span>Тип: Проверка на новые позиции</span>
                        @endif
                    </div>
                </div>
                <div class="extra content">
                    <div class="ui form">
                        <div class="fields">
                            <div class="field"></div>
                            <form action="{{route('task.show', ['page' => $item->offer->page->id])}}" method="get">
                                <div class="field">
                                    <button class="ui blue button">Подробности</button>
                                </div>
                            </form>
                            <div class="field"></div>
                            <form action="{{route('task.delete', ['page' => $item->offer->page->id])}}" method="post">
                                @method('delete')
                                @csrf
                                <div class="field">
                                    <button class="ui red button">Удалить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="extra content">
                    {{$item->offer->last_checked_at}}
                </div>
            </div>
        @endforeach
    </div>
    <div class="ui center aligned grid">
        <div class="column">
            {!! $minPrice->links('vendor.pagination.semantic-ui') !!}
        </div>
    </div>
</x-app-layout>
