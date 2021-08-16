<?php


class daily_progress_details
{
    public $return = [
        "daily_progress_details" => [
            "type" => [
                "title" => [
                    1 => 'Day By Day',
                    2 => 'Final',
                ],
                "value" => [
                    'day_by_day' => '1',
                    'final' => '2',
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