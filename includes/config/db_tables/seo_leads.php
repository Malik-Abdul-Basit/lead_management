<?php


class seo_leads
{
    public $return = [
        "seo_leads" => [
            "status" => [
                "title" => [
                    1 => 'New',
                    2 => 'Open',
                    3 => 'Active',
                    4 => 'In progress',
                    5 => 'Open deal',
                    6 => 'Unqualified',
                    7 => 'Attempted to contact',
                    8 => 'Follow up',
                    9 => 'Connected',
                    10 => 'On Board',
                    11 => 'Bad timing',
                    12 => 'Close',
                    13 => 'Dead',
                ],
                "value" => [
                    'new' => '1',
                    'open' => '2',
                    'active' => '3',
                    'in_progress' => '4',
                    'open_deal' => '5',
                    'unqualified' => '6',
                    'attempted_to_contact' => '7',
                    'follow_up' => '8',
                    'connected' => '9',
                    'on_board' => '10',
                    'bad_timing' => '11',
                    'close' => '12',
                    'dead' => '13',
                ]
            ]
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