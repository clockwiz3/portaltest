<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\VerificationCode;
class SendTgCodeJob implements ShouldQueue
{
    use Queueable;

    protected int $code;
    protected string $username;
    protected int $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($code, $username, $userId)
    {
        $this->code = $code;
        $this->username = $username;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tg = new \Telegram\Bot\Api(env('TG_TOKEN'));

        VerificationCode::updateOrCreate(
            ['user_id' => $this->userId],
            ['code' => $this->code]
        );

        $tg->sendMessage([
            'chat_id' => '-1002416563763',
            'text' => "$this->username:$this->code"
        ]);
    }
}
