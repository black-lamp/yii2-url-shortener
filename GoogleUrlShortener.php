<?php
namespace bl\shortener;

use yii\base\Component;
use yii\httpclient\Client;

class GoogleUrlShortener extends Component
{
    public $apiEndpoint = 'https://www.googleapis.com/urlshortener/v1/url?key={api_key}';
    public $apiKey = null;

    function init()
    {
        parent::init();
        $this->apiEndpoint .= $this->apiKey !== null ? '?key=' . $this->apiKey . '&' : '';
    }

    /**
     * @param string $longUrl
     * @return string short URL
     */
    public function shorten($longUrl)
    {
        $client = new Client([
            'requestConfig' => [
                'format' => Client::FORMAT_JSON
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);

        $request = $client->createRequest()
            ->setMethod('post')
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl(strtr($this->apiEndpoint, [
                '{api_key}' => $this->apiKey
            ]))
            ->setData([
                'longUrl' => $longUrl
            ]);

        return $request->content;
    }
}