<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="mb-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('control-panel.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Панель управления
                </a>

                <button id="fetch-news"
                    class="ml-4 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Обновить новости
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h2 class="font-semibold text-lg">Поиск новостей</h2>
            <div class="flex">
                <input type="text" id="search" placeholder="поиск..."
                    class="mt-2 p-2 border text-black rounded w-full" />
                <button id="search-button"
                    class="ml-2 px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Поиск
                </button>
            </div>

            <h2 class="font-semibold mt-6">Последние новости</h2>
            <ul id="news-list">
                @foreach($news as $article)
                    <li>
                        <a href="{{ $article->url }}" target="_blank" class="text-blue-500 underline">
                            {{ $article->title }}
                        </a>
                        ({{ $article->published_at }})
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function createNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerText = message;

            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.right = '20px';
            notification.style.backgroundColor = 'rgba(0, 123, 255, 0.8)';
            notification.style.color = 'white';
            notification.style.padding = '10px';
            notification.style.borderRadius = '5px';
            notification.style.zIndex = '1000';

            document.body.appendChild(notification);

            setTimeout(() => {
                document.body.removeChild(notification);
            }, 5000);
        }

        document.getElementById('fetch-news').addEventListener('click', function () {
            fetch('{{ route('news.fetch') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchLatestNews();
                })
                .catch(error => {
                    console.error(error);
                });
        });

        function fetchLatestNews() {
            fetch('{{ route('news.latest') }}')
                .then(response => response.json())
                .then(data => {
                    const newsList = document.getElementById('news-list');
                    newsList.innerHTML = '';

                    data.forEach(article => {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `<a href="${article.url}" target="_blank" class="text-blue-500 underline">${article.title}</a> (${article.published_at})`;
                        newsList.appendChild(listItem);
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }

        document.getElementById('search-button').addEventListener('click', function () {
            const query = document.getElementById('search').value;
            searchNews(query);
        });

        function searchNews(query) {
            fetch('{{ route('news.search') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ query: query })
            })
                .then(response => response.json())
                .then(data => {
                    const newsList = document.getElementById('news-list');
                    newsList.innerHTML = '';

                    data.forEach(article => {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `<a href="${article.url}" target="_blank" class="text-blue-500 underline">${article.title}</a> (${article.published_at})`;
                        newsList.appendChild(listItem);
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</x-app-layout>