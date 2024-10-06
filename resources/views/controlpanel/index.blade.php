<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Панель управления') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl text-white mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between space-x-4">

                <div class="w-1/2 bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <h1 class="text-xl font-bold mb-4">Пользователи</h1>

                    <h2 class="font-semibold">Подтвержденные</h2>
                    <ul class="mb-4">
                        @foreach($verifiedUsers as $user)
                            <li class="pl-5 pt-1">{{ $user }}</li>
                        @endforeach
                    </ul>

                    <h2 class="font-semibold">Неподтвержденные</h2>
                    <ul class="mb-4">
                        @foreach($nonVerifiedUsers as $user)
                            <li class="pl-5 pt-1">{{ $user }}</li>
                        @endforeach
                    </ul>

                    <h2 class="font-semibold">Коды</h2>
                    <table class="dark:bg-gray-800 ">
                        <thead>
                            <tr>
                                <th class="p-1 text-left">Юзер</th>
                                <th class="p-1 text-left">Код</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verificationCodes as $code)
                                <tr class="hover:bg-gray-600">
                                    <td class="p-2">{{ $code->user->name }}</td>
                                    <td class="p-2">{{ $code->code }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="w-full bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <h1 class="text-xl font-bold mb-4">Новости</h1>
                    {{ $news->links() }}
                    <table>
                        <thead>
                            <tr>
                                <th class="p-2 text-left">Дата</th>
                                <th class="p-2 text-left">Заголовок</th>
                                <th class="p-2 text-left">Саммари</th>
                                <th class="p-2 text-left">URL</th>
                                <th class="p-2 text-left">Секция</th>
                                <th class="p-2 text-left">Подсекция</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $article)
                                <tr class="hover:bg-gray-600">
                                    <td class="p-2">{{ $article->published_at }}</td>
                                    <td class="p-2">{{ $article->title }}</td>
                                    <td class="p-2">{{ $article->abstract }}</td>
                                    <td class="p-2">
                                        <a href="{{ $article->url }}" target="_blank"
                                            class="text-blue-600 underline">{{ $article->url }}</a>
                                    </td>
                                    <td class="p-2">{{ $article->section }}</td>
                                    <td class="p-2">{{ $article->subsection }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>