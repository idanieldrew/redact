<?php

namespace Module\User\Http\Notifications\Messages;

use Exception;
use Illuminate\Support\Facades\Http;

class SmsMessage
{
    protected $liens = [];

    protected $from;

    protected $to;

    public function __construct(array $lines = [])
    {
        $this->liens = $lines;
    }

    public function line($line)
    {
        $this->$line[] = $line;
        return $this;
    }

    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Send
     * @throws Exception
     */
    public function send()
    {
        if (!$this->from || $this->to || !count($this->liens)) {
            throw new Exception("not correct");
        }

        Http::withHeaders([
            'apikey' => config('sms.ghasedak.apikey')
        ])->asForm()->post('https://api.ghasedak.me/v2/sms/send/simple', [
            'message' => $this->lines[0],
            'receptor' => $this->to,
            'linenumber' => config('sms.ghasedak.linenumber')
        ]);
    }
}
