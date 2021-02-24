<?php

namespace App\Libraries;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryLib
{
    public $upload;

    public function __construct()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => 'dmmcpkwj9',
                'api_key' => '593936871131434',
                'api_secret' => '583zcNQHlv0kKUBANmgTMz4QAT0'
            ],
            'url' => [
                'secure' => true
            ]
        ]);
        $this->upload = new UploadApi();
    }
}
