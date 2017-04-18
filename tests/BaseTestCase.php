<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class BaseTestCase extends TestCase
{
    const UNEXPECTED_KEYS = 'The array should only contain the specified keys found %s unexpected keys';

    /**
     * @return mixed|string
     */
    protected function getContent()
    {
        $content = $this->response->getContent();

        $json = json_decode($content);

        if (json_last_error() === JSON_ERROR_NONE) {
            $content = $json;
        }

        return $content;
    }

    /**
     * @return void
     */
    protected function debugContent()
    {
        print_r($this->response->getContent());

        die('end of debug');
    }

    /**
     * @param array $keys
     * @param $expected
     * @param $actual
     */
    protected function assertAttributesExpectedValues($keys = [], $expected, $actual)
    {
        if (is_object($expected)) {
            $expected = json_decode(json_encode($expected), true);
        }
        if (is_object($actual)) {
            $actual = json_decode(json_encode($actual), true);
        }
        foreach ($keys as $key) {
            $this->assertEquals($expected[$key], $actual[$key]);
        }
    }

    /**
     * @param string $table
     * @param array|object $expected
     */
    protected function assertMultipleSeeInDatabase($table, $expected)
    {
        if (is_object($expected)) {
            $expected = json_decode(json_encode($expected), true);
        }
        foreach ($expected as $expect) {
            $this->seeInDatabase($table, $expect);
        }
    }

    /**
     * @param string $table
     * @param array|object $expected
     */
    protected function assertMultipleNotSeeInDatabase($table, $expected)
    {
        if (is_object($expected)) {
            $expected = json_decode(json_encode($expected), true);
        }
        foreach ($expected as $expect) {
            $this->notSeeInDatabase($table, $expect);
        }
    }

    /**
     * @param array $keys
     * @param array $array
     */
    protected function assertArrayHasKeys($keys, $array)
    {
        array_walk($keys, function ($keys) use ($array) {
            $this->assertArrayHasKey($keys, $array);
        });
    }

    /**
     * @param array $keys
     * @param array $array
     */
    protected function assertArrayHasOnlyKeys($keys, $array)
    {
        $keyLookup = array_flip($keys);
        $extraKeys = array_merge(
            array_diff_key($array, $keyLookup),
            array_diff_key($keyLookup, $array)
        );
        $this->assertEmpty(
            $extraKeys,
            sprintf(self::UNEXPECTED_KEYS, count($extraKeys))
        );
    }

    /**
     * @param string $database
     * @param array $migrationParameters
     */
    protected function setConnection($database, $migrationParameters = [])
    {
        DB::setDefaultConnection($database);

        $this->artisan('migrate', $migrationParameters);
    }

    /**
     * @return string
     */
    protected function getArtisanOutput()
    {
        return $test = trim(Artisan::output());
    }

    /**
     * @param $json
     *
     * @return array
     */
    protected function getJsonSchemaResult($json)
    {
        return json_decode($json, true);
    }

    /**
     * @param array|object $toConvert
     *
     * @return array
     */
    protected function toArray($toConvert)
    {
        if (is_object($toConvert)) {
            return get_object_vars($toConvert);
        }

        return $toConvert;
    }

    /**
     * Used only to print status on which file does the testing happens.
     *
     * @param string $message
     */
    protected function runningTestFor($message)
    {
        print PHP_EOL;

        echo "\033[32m RUNNING TEST FOR ---> \033[36m $message \033[0m \n";

        print PHP_EOL;
    }

    /**
     * @param string $message
     */
    protected function printAlertMessageOnCLI($message)
    {
        print PHP_EOL;

        echo "\033[31m $message \033[0m \n";

        print PHP_EOL;
    }
}
