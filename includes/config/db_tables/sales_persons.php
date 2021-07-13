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
            ],
            "status" => [
                "title" => [
                    0 => 'Pending',
                    1 => 'Activated',
                    2 => 'Deactivated',
                    3 => 'Suspended',
                    4 => 'Suspended by admin',
                    5 => 'Blocked',
                    6 => 'Blocked by admin',
                ],
                "value" => [
                    'pending' => '0',
                    'activated' => '1',
                    'deactivated' => '2',
                    'suspended' => '3',
                    'suspended by admin' => '4',
                    'blocked' => '5',
                    'blocked by admin' => '6',
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