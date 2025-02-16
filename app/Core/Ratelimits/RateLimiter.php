<?php

namespace App\Core\Ratelimits;

use App\Models\Session;

class RateLimiter
{
    private $limit;
    private $timeWindow;
    private $storageFile;

    /**
     * Instantiate ratelimiter 
     * @param int number of requests
     * @param int number of seconds
     */
    public function __construct($limit = 5, $timeWindow = 60)
    {
        $this->limit = $limit;
        $this->timeWindow = $timeWindow;
        $this->storageFile = __DIR__ . '/rate_limit.json';
    }

    /**
     * get ip address of client
     */
    private function getIP(): string
    {
        $authUser  =(new Session())->auth();
        if(!empty($authUser)) {
            return $authUser['id'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * get saved contents of file
     */
    private function loadStorage(): array
    {
        if (!file_exists($this->storageFile)) {
            return [];
        }
        return json_decode(file_get_contents($this->storageFile), true) ?? [];
    }

    /**
     * saves data into file
     * @param array data
     */
    private function saveStorage($data): void
    {
        file_put_contents($this->storageFile, json_encode($data));
    }

    /**
     * determines if client is allowed to make any more requests
     */
    public function isAllowed(): bool
    {
        $ip = $this->getIP();
        $storage = $this->loadStorage();

        if (!isset($storage[$ip])) {
            $storage[$ip] = ['count' => 1, 'timestamp' => time()];
            $this->saveStorage($storage);
            return true;
        }

        $timeElapsed = time() - $storage[$ip]['timestamp'];

        if ($timeElapsed > $this->timeWindow) {
            $storage[$ip] = ['count' => 1, 'timestamp' => time()];
            $this->saveStorage($storage);
            return true;
        }

        if ($storage[$ip]['count'] < $this->limit) {
            $storage[$ip]['count'] += 1;
            $this->saveStorage($storage);
            return true;
        }

        return false;
    }
}
?>
