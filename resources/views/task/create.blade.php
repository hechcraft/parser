<x-app-layout>
    <form action="{{route('task.store')}}" method="POST" class="ui form">
        @csrf
        <div class="field">
            <div class="ui labeled input">
                <div class="ui label">
                    http://
                </div>
                <input type="text" placeholder="" id="url" type="text" name="url" value="{{old('url')}}" required>
            </div>
            <div class="ui pointing label @error('url') red @enderror">
                @error('url') Не правильный @enderror Url
            </div>
        </div>

        <div class="ui two column stackable center aligned page grid">
            <div class="column @error('url_type') red @enderror">
                <select name="url_type" class="ui dropdown field">
                    <option value="">Выбрать тип ссылки</option>
                    <option value="single">Это одиночная позиция</option>
                    <option value="groupMinPrice">Следить за наименьшей ценой</option>
                    <option value="groupNewPosition">Следить за добавлением новых позиций</option>
                </select>
                @error('url_type')
                <p>Выберите тип страницы</p>
                @enderror
            </div>
            <div class="column">
                <button class="ui primary button field">
                    Сохранить
                </button>
            </div>
        </div>
    </form>
</x-app-layout>
