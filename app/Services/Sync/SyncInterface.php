<?php

namespace App\Services\Sync;

interface SyncInterface {

    public function insertNew();

    public function sync($code);

    public function syncAll();
}
