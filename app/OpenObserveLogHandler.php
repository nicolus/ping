<?php
namespace App;

use GuzzleHttp\Client;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;
use Monolog\Handler\AbstractProcessingHandler;

class OpenObserveLogHandler extends AbstractProcessingHandler
{

    public function __construct(protected Client $client, int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        $this->client->post('http://localhost:8000/monolog', [
            'json' => [
                'channel' => $record->channel,
                'level' => $record->level,
                'message' => $record->message
            ],
        ]);
    }

    private function initialize()
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS monolog '
            .'(channel VARCHAR(255), level INTEGER, message LONGTEXT, time INTEGER UNSIGNED)'
        );
        $this->statement = $this->pdo->prepare(
            'INSERT INTO monolog (channel, level, message, time) VALUES (:channel, :level, :message, :time)'
        );

        $this->initialized = true;
    }
}