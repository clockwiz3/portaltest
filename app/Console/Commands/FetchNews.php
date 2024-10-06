<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\News;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news';
    protected $description = 'fetch news';

    public function handle()
    {
        $client = new Client();
        $key = env('NYT_TOKEN');
        $response = $client->get("https://api.nytimes.com/svc/topstories/v2/home.json?api-key={$key}");
        $data = json_decode($response->getBody(), true);

        foreach ($data['results'] as $article) {
            News::updateOrCreate(
                ['url' => $article['url']],
                [
                    'published_at' => $article['published_date'],
                    'title' => $article['title'],
                    'abstract' => $article['abstract'],
                    'full_text' => $article['url'],
                    'section' => $article['section'] ?? '',
                    'subsection' => $article['subsection'] ?? '',
                ]
            );
        }

        $this->info('done');
    }
}
