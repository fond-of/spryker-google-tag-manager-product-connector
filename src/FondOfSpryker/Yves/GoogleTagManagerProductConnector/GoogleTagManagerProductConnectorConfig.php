<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector;

use FondOfSpryker\Shared\GoogleTagManagerProductConnector\GoogleTagManagerProductConnectorConstants;
use Spryker\Yves\Kernel\AbstractBundleConfig;

class GoogleTagManagerProductConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->get(GoogleTagManagerProductConnectorConstants::PROTOCOL, 'http');
    }

    /**
     * @return int
     */
    public function getDefaultTaxRate(): int
    {
        return $this->get(GoogleTagManagerProductConnectorConstants::DEFAULT_TAX_RATE, 0);
    }
}
