<?php


class campaigns
{
    public $return = [
        "campaigns" => [
            "type" => [
                "title" => [
                    'smm'=>'Social Media Marketing',
                    'em'=>'Email Marketing',
                ],
                "value" => [
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