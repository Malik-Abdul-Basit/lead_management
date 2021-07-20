<?php


class lang
{
    public $return = [
        "lang" => [
            "button" => [
                "title" => [
                    'add' => 'Add More',
                    'save' => 'Save',
                    'select_image' => 'Select Image',
                    'update' => 'Update',
                    'get_report' => 'Get Report',
                    'new_record' => '<i class="la la-plus"></i>New Record',
                ],
            ],

            "user_right_title" => [
                "title" => [
                    'seo_source' => 'Source <small> (Search Engine Optimization) </small>',
                    'seo_campaign' => 'Campaign <small> (Search Engine Optimization) </small>',
                    'seo_lead' => 'Lead <small> (Search Engine Optimization) </small>',

                    'smm_source' => 'Source <small> (Social Media Marketing) </small>',
                    'smm_account' => 'Account <small> (Social Media Marketing) </small>',
                    'smm_campaign_type' => 'Campaign Type <small> (Social Media Marketing) </small>',
                    'smm_campaign' => 'Campaign <small> (Social Media Marketing) </small>',
                    'smm_lead' => 'Lead <small> (Social Media Marketing) </small>',

                    'em_source' => 'Source <small> (Email Marketing) </small>',
                    'em_account' => 'Account <small> (Email Marketing) </small>',
                    'em_campaign_type' => 'Campaign Type <small> (Email Marketing) </small>',
                    'em_campaign' => 'Campaign <small> (Email Marketing) </small>',
                    'em_lead' => 'Lead <small> (Email Marketing) </small>',

                    'tele_marketing_progress' => 'Daily Progress <small> (Tele Marketing) </small>',
                    'tele_marketing_lead' => 'Lead <small> (Tele Marketing) </small>',
                ],
            ],

            "page_type" => [
                "title" => [
                    'seo_source' => 'seo',
                    'seo_source_list' => 'seo',
                    'seo_campaign' => 'seo',
                    'seo_campaign_list' => 'seo',
                    'seo_lead' => 'seo',
                    'seo_lead_list' => 'seo',

                    'smm_source' => 'smm',
                    'smm_source_list' => 'smm',
                    'smm_account' => 'smm',
                    'smm_account_list' => 'smm',
                    'smm_campaign_type' => 'smm',
                    'smm_campaign_type_list' => 'smm',
                    'smm_campaign' => 'smm',
                    'smm_campaign_list' => 'smm',
                    'smm_lead' => 'smm',
                    'smm_lead_list' => 'smm',

                    'em_source' => 'em',
                    'em_source_list' => 'em',
                    'em_account' => 'em',
                    'em_account_list' => 'em',
                    'em_campaign_type' => 'em',
                    'em_campaign_type_list' => 'em',
                    'em_campaign' => 'em',
                    'em_campaign_list' => 'em',
                    'em_lead' => 'em',
                    'em_lead_list' => 'em',
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