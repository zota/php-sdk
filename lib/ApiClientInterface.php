<?php

namespace Zota;

/**
 * ApiClientInterface.
 */
interface ApiClientInterface
{
    /**
     * Zota API request.
     *
     * @param \Zota\Data $data
     *
     * @return self
     */
    public function request($data);
}
