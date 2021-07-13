<?php


class accounts
{
    public $return = [
        "accounts" => [
            "type" => [
                "title" => [
                    'seo'=>'Search Engine Optimization',
                    'smm'=>'Social Media Marketing',
                    'em'=>'Email Marketing',
                ],
                "value" => [
                    'search_engine_optimization'=>'seo',
                    'social_media_marketing'=>'smm',
                    'email_marketing'=>'em',
                ],
            ],
        ],
    ];

    /**
     * @return array
     */
    /**
     * @return array
     */
    public function getArray()
    {
        return $this->return;
    }

}

?>