<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhacenterService
{

    protected string $to;
    protected array $lines;
    protected string $baseUrl = 'https://app.whacenter.com/api/send';
    protected string $deviceId = 'a235f4ac1bc1a5b0ded8110cd4a1e082';


    /**
     * constructor.
     * @param array $lines
     */
    public function __construct($lines = [])
    {
        $this->lines = $lines;
        $this->baseUrl = '';
        $this->deviceId = '';
    }

    public function getDeviceStatus()
    {
        return Http::get($this->baseUrl . '/statusDevice?device_id=' . $this->deviceId);
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function send(): mixed
    {
        if ($this->to == '' || count($this->lines) <= 0) {
            throw new \Exception('Message not correct.');
        }
        $params = 'device_id=' . $this->deviceId . '&number=' . $this->to . '&message=' . urlencode(implode("\n", $this->lines));
        $response = Http::get($this->baseUrl . '/send?' . $params);
        return $response->body();
    }
}
