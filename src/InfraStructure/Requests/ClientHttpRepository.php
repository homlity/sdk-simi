<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;


use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Interface ClientHttpRepository
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 */
interface ClientHttpRepository
{
    /**
     * @param string $url
     * @param string $url
     * @return mixed
     */
    public function sendPost(string $url):ResponseRepository;

    /**
     * @param string $url
     * @param string $url
     * @return mixed
     */
    public function sendGet(string $url):ResponseRepository;
}