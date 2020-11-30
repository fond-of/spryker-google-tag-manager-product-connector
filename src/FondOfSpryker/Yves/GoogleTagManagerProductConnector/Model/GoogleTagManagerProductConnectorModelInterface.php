<?php

namespace FondOfSpryker\Yves\GoogleTagManagerProductConnector\Model;

interface GoogleTagManagerProductConnectorModelInterface
{
    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getBrand(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getEan(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getImageUrl(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getName(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getQuantity(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getUrl(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getId(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getSku(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getPrice(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getPriceExcludingTax(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getTax(string $page, array $params): array;

    /**
     * @param string $page
     * @param array $params
     *
     * @return array
     */
    public function getTaxRate(string $page, array $params): array;
}
