<x-app-layout>
    <form action="{{route('page.store')}}" method="POST">
        @csrf

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="mt-2">
                    <x-label for="url">Ссылка на объявление</x-label>
                    <x-input class="block mt-1 w-full" id="url" type="text" name="url" :value="old('url')" required/>
                </div>


                <div class="mt-2">
                    <x-label>Тип ссылки</x-label>
                    <select name="url_type"
                            class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="single">Это одиночная позиция</option>
                        <option value="groupMinPrice">Следить за наименьшей ценой</option>
                        <option value="groupNewPosition">Следить за добавлением новых позиций</option>
                    </select>
                </div>

                <div class="flex items-center justify-end mt-2">
                    <x-button>Добавить</x-button>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
