<div class="ui grid">
    <div class="five wide column center aligned">
        <h2 class="ui header">{{$offerMinPrice->offer->name}}</h2>
        <a href="{{$offerMinPrice->offer->offer_url}}" class="ui medium image">
            <img src="{{$offerMinPrice->offer->image_url}}">
        </a>
        <p></p>
        <p>Последняя цена: {{$offerMinPrice->price_str}}</p>
        <p>Последняя проверка: {{$offerMinPrice->offer->last_checked_at}}</p>
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
<div class="ui horizontal  divider">
    <h1>История</h1>
</div>
<div class="ui grid one column centered">
    <table class="ui very basic collapsing celled table">
        <thead>
        <tr><th>@sortablelink('name', 'Название') <i class="sort icon"></i></th>
            <th>@sortablelink('lastPrice.price', 'Цена') <i class="sort icon"></i></th>
            <th>Ссылка</th>
        </tr></thead>
        <tbody>
        @foreach($offers as $item)
            <tr>
                <td>
                    <h4 class="ui image header">
                        <img src="{{$item->image_url}}" class="ui mini rounded image">
                        <div class="content">
                            {{$item->name}}
                        </div>
                    </h4></td>
                <td>
                    {{$item->lastPrice->price_str ?? 0}}
                </td>
                <td>
                    <a href="{{$item->offer_url}}">Ссылка</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $offers->appends(Request::except('page'))->render('vendor.pagination.semantic-ui') !!}
</div>
