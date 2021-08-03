<?php


class dashboard
{
    public $return = [
        "dashboard" => [

            "duration" => [
                "title" => [
                    '1d' => '1 Day',
                    '1w' => '1 Week',
                    '1m' => '1 Month',
                    '1y' => '1 Year',
                ],
                "value" => [
                    'one_day' => '1d',
                    'one_week' => '1w',
                    'one_month' => '1m',
                    'one_year' => '1y',
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