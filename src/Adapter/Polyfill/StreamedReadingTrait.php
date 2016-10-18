<?php

namespace League\Flysystem\Adapter\Polyfill;

use League\Flysystem\Config;

/**
 * A helper for adapters that only handle strings to provide read streams.
 */
trait StreamedReadingTrait
{
    /**
     * Reads a file as a stream.
     *
     * @param string $path
     * @param Config $config   Config object
     *
     * @return array|false
     *
     * @see League\Flysystem\ReadInterface::readStream()
     */
    public function readStream($path, Config $config)
    {
        if ( ! $data = $this->read($path)) {
            return false;
        }

        $stream = fopen('php://temp', 'w+b');
        fwrite($stream, $data['contents']);
        rewind($stream);
        $data['stream'] = $stream;
        unset($data['contents']);

        return $data;
    }

    /**
     * Reads a file.
     *
     * @param string $path
     * @param Config $config   Config object
     *
     * @return array|false
     *
     * @see League\Flysystem\ReadInterface::read()
     */
    abstract public function read($path, Config $config);
}
