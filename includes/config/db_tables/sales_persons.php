<?php


class sales_persons
{
    public $return = [
        "sales_persons" => [
            "gender" => [
                "title" => [
                    'm'=>'Male',
                    'f'=>'Female',
                    'o'=>'Other',
                ],
                "value" => [
                    'male'=>'m',
                    'female'=>'f',
                    'other'=>'o',
                ],
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