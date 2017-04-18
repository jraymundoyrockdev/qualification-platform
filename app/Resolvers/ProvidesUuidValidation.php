<?php

namespace App\Resolvers;

trait ProvidesUuidValidation
{
    /**
     * @param string $uuid
     *
     * @return bool
     */
    public function isValidUuid($uuid)
    {
        if (!is_string($uuid) || $this->matchByPreMatch($uuid)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    private function matchByPreMatch($uuid)
    {
        return (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1);
    }
}
