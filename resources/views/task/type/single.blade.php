<div class="ui grid">
    <div class="five wide column center aligned">
        <h2 class="ui header">{{$page->offer[0]->name}}</h2>
        <a href="{{$page->offer[0]->offer_url}}" class="ui medium image">
            <img src="{{$page->offer[0]->image_url}}">
        </a>
        <p></p>
        <p>Последняя цена: {{$page->offer[0]->lastPrice->price_str}}</p>
        <p>Последняя проверка: {{$page->offer[0]->last_checked_at}}</p>
    </div>
    <div class="eleven wide column">
        @include('components.graph')
        <div class="ui segment right floated">
            <form action="{{route('task.delete', ['page' => $page->id])}}" method="post">
                @method('delete')
                @csrf
                <button class="ui red button">Удалить</button>
            </form>
        </div>
        <div class="ui segment right floated">
            <a href="{{url()->previous()}}">
                <button class="ui blue button">Назад</button>
            </a>
        </div>
    </div>
</div>
