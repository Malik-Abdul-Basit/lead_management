<?php
include_once("web.php");
include_once("mail/index.php");

if (!function_exists('getInitialsFromString')) {
    function getInitialsFromString($name, $length = 3)
    {
        $initials = '';
        if (!empty($name)) {
            $exploded_name = explode(" ", $name);
            if (!empty($exploded_name) && is_array($exploded_name) && count($exploded_name) > 0) {
                foreach ($exploded_name as $w) {
                    $initials .= substr($w, 0, 1);
                }
            } else {
                $initials = substr($name, 0, 1);
            }
        }
        return substr($initials, 0, $length);
    }
}

if (!function_exists('getImageNameOrInitials')) {
    function getImageNameOrInitials($data, $image_flag)
    {
        $image_details = null;
        switch ($image_flag) {
            case config('db_const.logos_directory.user.value'):
                $image_details = checkImageExists($data->user_image, $data->name, $image_flag);
                break;
            case config('db_const.logos_directory.company.value'):
                $company = $data->user_account;
                $image_details = checkImageExists($company->company_logo, $company->name, $image_flag);
                break;
            case config('db_const.logos_directory.booking_source.value'):
            case config('db_const.logos_directory.property.value'):
                $image_details = checkImageExists($data->logo, $data->name, $image_flag);
                break;
        }
        return $image_details;
    }
}

if (!function_exists('generatePassword')) {
    function generatePassword($length = 15, $numeric = FALSE, $special = FALSE)
    {
        $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        if ($numeric) {
            $alphabet .= '0123456789';
        }
        if ($special) {
            $alphabet .= '%?>+$=-*&_@^#!~<';
        }
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}

if (!function_exists('validName')) {
    function validName($value)
    {
        return preg_match("/^[a-zA-Z0-9-.@_&)(' ]+$/", $value);
    }
}

if (!function_exists('validEmail')) {
    function validEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists('validURL')) {
    function validURL($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('validMobileNumber')) {
    function validMobileNumber($value)
    {
        return preg_match('/^[0-9]{3}-[0-9]{3} [0-9]{4}$/', $value);
    }
}

if (!function_exists('validPhoneNumber')) {
    function validPhoneNumber($value)
    {
        return preg_match('/^[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}$/', $value);
    }
}

if (!function_exists('validAddress')) {
    function validAddress($value)
    {
        return preg_match("/^[a-zA-Z0-9+-._,@&#\/)(’' ]+$/", $value);
    }
}

if (!function_exists('validDate')) {
    function validDate($value)
    {
        return preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $value);
    }
}

if (!function_exists('validTime12')) {
    function validTime12($value)
    {
        return preg_match("/^((0[1-9])|(1[0-2])):([0-5][0-9]) (([P][M])|([A][M]))$/", $value);
    }
}

if (!function_exists('validTime24')) {
    function validTime24($value)
    {
        return preg_match("/^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $value);
    }
}

if (!function_exists('validCNIC')) {
    function validCNIC($value)
    {
        return preg_match('/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/', $value);
    }
}

if (!function_exists('validFamilyCode')) {
    function validFamilyCode($value)
    {
        return preg_match("/^[a-zA-Z0-9]+$/", $value);
    }
}

if (!function_exists('lowerCaseExist')) {
    function lowerCaseExist($value)
    {
        if (preg_match('/[a-z]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('uppercaseExist')) {
    function uppercaseExist($value)
    {
        if (preg_match('/[A-Z]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('numberExist')) {
    function numberExist($value)
    {
        if (preg_match('/[0-9]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('specialCharactersExist')) {
    function specialCharactersExist($value)
    {
        if (preg_match('/[!@#$%^&*]/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getClasses')) {
    function getClasses($link, $page_no, $total_no_of_pages)
    {
        if (in_array($link, ['first', 'prev'])) {
            $p = $link == 'first' ? 1 : $page_no - 1;

            if ($page_no <= 1) {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . ' datatable-pager-link-disabled"';
            } else {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . '" onclick="setPageNo(' . $p . ')"';
            }
        } else if (in_array($link, ['next', 'last'])) {
            $p = $link == 'last' ? $total_no_of_pages : $page_no + 1;

            if ($page_no >= $total_no_of_pages) {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . ' datatable-pager-link-disabled"';
            } else {
                return ' class="datatable-pager-link datatable-pager-link-' . $link . '" onclick="setPageNo(' . $p . ')"';
            }
        }
    }
}

if (!function_exists('getPaginationNumbering')) {
    function getPaginationNumbering($page_no, $total_records_per_page, $total_records, $PageSizeStack)
    {
        $adjacents = "2";
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
        $second_last = $total_no_of_pages - 1;

        $data = '<div class="datatable-pager datatable-paging-loaded">
            <ul class="datatable-pager-nav mb-5 mb-sm-0" id="BG_PagerNumberingHolder">
                <li>
                    <a title="First" href="javascript:;"' . getClasses("first", $page_no, $total_no_of_pages) . '><i class="flaticon2-fast-back"></i></a>
                </li>
                <li>
                    <a title="Previous" href="javascript:;"' . getClasses("prev", $page_no, $total_no_of_pages) . '><i class="flaticon2-back"></i></a>
                </li>
                <li><input type="hidden" readonly class="datatable-pager-input form-control" id="BG_PageNumber" title="Page number" value="' . $page_no . '"></li>';
        if ($total_no_of_pages <= 5) {
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) {
                    $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                } else {
                    $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                }
            }
        } elseif ($total_no_of_pages > 5) {
            if ($page_no <= 3) {
                for ($counter = 1; $counter <= 3; $counter++) {
                    if ($page_no == $counter) {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                    } else {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                    }
                }
                $data .= "<li><a>...</a></li>";
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $second_last . ')">' . $second_last . '</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $total_no_of_pages . ')">' . $total_no_of_pages . '</a></li>';
            } elseif ($page_no >= 4 && $page_no < $total_no_of_pages - 2) {
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(1)">1</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(2)">2</a></li>';
                $data .= "<li><a>...</a></li>";
                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                    if ($counter != 2) {
                        if ($page_no == $counter) {
                            $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                        } else {
                            $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                        }
                    }
                }
                $data .= "<li><a>...</a></li>";
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $second_last . ')">' . $second_last . '</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $total_no_of_pages . ')">' . $total_no_of_pages . '</a></li>';
            } else {
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(1)">1</a></li>';
                $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(2)">2</a></li>';
                $data .= "<li><a>...</a></li>";
                for ($counter = $total_no_of_pages - 2; $counter <= $total_no_of_pages; $counter++) {
                    if ($page_no == $counter) {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number datatable-pager-link-active">' . $counter . '</a></li>';
                    } else {
                        $data .= '<li><a href="javascript:;" class="datatable-pager-link datatable-pager-link-number" onclick="setPageNo(' . $counter . ')">' . $counter . '</a></li>';
                    }
                }
            }
        }
        $data .= '<li>
                    <a title="Next" href="javascript:;"' . getClasses("next", $page_no, $total_no_of_pages) . '><i class="flaticon2-next"></i></a>
                </li>
                <li>
                    <a title="Last" href="javascript:;"' . getClasses("last", $page_no, $total_no_of_pages) . '><i class="flaticon2-fast-next"></i></a>
                </li>
            </ul>
            <div class="datatable-pager-info">
                <div class="dropdown datatable-pager-size" style="width: 60px;">
                <select title="Select page size" onchange="getData()" class="custom-select custom-select-sm form-control form-control-sm" aria-controls="kt_datatable" id="BG_PageSize">';
        foreach ($PageSizeStack as $n) {
            $s = $total_records_per_page == $n ? ' selected="selected"' : '';
            $data .= '<option value="' . $n . '"' . $s . '>' . $n . '</option>';
        }
        $data .= '</select>
                </div>
                <span class="datatable-pager-detail">Showing ' . round(round($page_no * $total_records_per_page) - round($total_records_per_page) + 1) . ' - ';
        $data .= (round($page_no * $total_records_per_page) > $total_records) ? $total_records : round($page_no * $total_records_per_page);
        /*.round($page_no*$total_records_per_page).*/
        $data .= ' of ' . $total_records . '</span>
            </div>
        </div>';
        return $data;
    }
}

if (!function_exists('getStates')) {
    function getStates($country_id, $id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`,`state_name` FROM `states` WHERE `country_id`='{$country_id}' ORDER BY `state_name` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = ' selected="selected" ';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->state_name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('getCities')) {
    function getCities($state_id, $id)
    {
        global $db;

        $data = '<option selected="selected" value="">Select</option>';
        $select = "SELECT `id`,`city_name` FROM `cities` WHERE `state_id`='{$state_id}' ORDER BY `city_name` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($id == $result->id) {
                    $selected = ' selected="selected" ';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->city_name . '</option>';
            }
        }
        return $data;
    }
}

if (!function_exists('getEmailFooter')) {
    function getEmailFooter()
    {
        global $mail, $base_url;

        //email footer start here
        $path = dirname(__DIR__) . '/assets/custom_assets/images/';
        $f = '<h4 style="color:#222;display:block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:12px;font-weight:600;letter-spacing:0.15px;line-height:18px;margin:25px 0 15px 0;width:100%;">Regards,</h4>';
        $mail->AddEmbeddedImage($path . 'HRISLogo.png', "HRISLogo", "", "base64", "image/jpg/png");
        $f .= '<h3 style="display:block;margin:0;overflow:hidden;width:100%;"><a href="' . $base_url . '"><img src="cid:HRISLogo" alt="Logo"></a></h3>';
        $f .= '<h2 style="color:#777;display:block;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:11px;font-weight:300;letter-spacing:0.15px;line-height:18px;margin:10px 0 5px 0;width:100%;">
        This transmission is only for the use of the intended recipient and may contain information that is privileged,
        confidential, secret or otherwise exempt from disclosure under applicable law.
        If you are not the intended recipient you may not copy, distribute, disseminate or otherwise use this transmission or the information it contains in any way.
        If this communication has been transmitted to you in error, please immediately notify the sender and delete this e-mail message from your computer. Thank you</h2>';
        $mail->AddEmbeddedImage($path . 'HRISSignature.png', "HRISSignature", "", "base64", "image/jpg/png");
        $f .= '<h1 style="display:block;margin:0;width:100%;"><img src="cid:HRISSignature" alt="Signature">&nbsp;<span style="color:#99CC00;display: inline-block;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size: 11px;font-weight:400;letter-spacing:0.15px;line-height:18px;margin:0;vertical-align:middle;">Please consider your environmental responsibility before printing this email.</span></h1>';
        //email footer end here

        /*
        $mail->addAttachment("file.txt", "File.txt");
        $mail->addAttachment('test.txt');
        $mail->addAttachment("images/profile.png"); //Filename is optional\
        */

        return $f;
    }
}

if (!function_exists('sendEmail')) {
    function sendEmail($parameters)
    {
        global $mail;

        $parameters = (object)$parameters;
        $replyTo = isset($parameters->replyTo) ? $parameters->replyTo : '';
        $mailTo = $parameters->mailTo;
        $mail->addAddress($mailTo['email']);
        $CC = isset($parameters->cc) ? $parameters->cc : '';
        $Bcc = isset($parameters->bcc) ? $parameters->bcc : '';

        $mail->Subject = ucwords(str_replace("_", " ", $parameters->subject));

        if (array_key_exists("name", $mailTo)) {
            $mailToName = $mailTo['name'];
            $mail->addAddress($mailTo['email'], $mailToName);
        }

        if (!empty($replyTo) && is_array($replyTo) && count($replyTo) > 0) {
            if (array_key_exists("name", $replyTo)) {
                $mail->addReplyTo($replyTo['email'], $replyTo['name']);
            } else {
                $mail->addReplyTo($replyTo['email']);
            }
        }

        if (!empty($CC) && is_array($CC) && count($CC) > 0) {
            if (array_key_exists("name", $CC)) {
                $mail->addCC($CC['email'], $CC['name']);
            } else {
                $mail->addCC($CC['email']);
            }
        }

        if (!empty($Bcc) && is_array($Bcc) && count($Bcc) > 0) {
            if (array_key_exists("name", $Bcc)) {
                $mail->addBCC($Bcc['email'], $Bcc['name']);
            } else {
                $mail->addBCC($Bcc['email']);
            }
        }

        $message = $parameters->data['email_body'];
        $message .= getEmailFooter();

        $mail->msgHTML($message);

        try {
            $mail->send();
            return json_encode(["code" => 200, 'successMessage' => $parameters->data['message']]);
        } catch (Exception $e) {
            return json_encode(["code" => 405, 'accessDeniedMessage' => "Error while sending Email. " . $mail->ErrorInfo]);
        }
    }
}

if (!function_exists('reflectTemplate')) {
    function reflectTemplate($html, $array)
    {
        foreach ($array as $template_key => $value) {
            $html = str_replace($template_key, $value, $html);
        }
        return $html;
    }
}

if (!function_exists('getUserImage')) {
    function getUserImage($id)
    {
        global $db, $base_url;
        $image_directory = 'storage/user_images/';
        $img = '';

        //return dirname(__FILE__); //C:\xampp\htdocs\projects\mso_core\includes
        //return dirname(__DIR__); //C:\xampp\htdocs\projects\mso_core
        //return basename(__DIR__); //includes

        //return $upOne = realpath(dirname(__FILE__) . '/..'); //C:\xampp\htdocs\projects\mso_core
        //return $upOne = realpath(__DIR__ . '/..'); //C:\xampp\htdocs\projects\mso_core
        //return $upOne = dirname(__DIR__, 1); //C:\xampp\htdocs\projects\mso_core
        //$upOne = dirname(__DIR__, 1). '/storage/emp_images/1682_G51DDMvsNzY4OG8rtPEQWucWCL5u3TkDAcy.png';

        if (!empty($id) && $id > 0) {
            $sql = mysqli_query($db, "SELECT `name` FROM `user_images` WHERE `user_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1 ");
            if ($sql && mysqli_num_rows($sql) > 0) {
                $object = mysqli_fetch_object($sql);
                $path = dirname(__DIR__) . '/' . $image_directory . $object->name;
                if (realpath($path)) {
                    $image_path = $base_url . $image_directory . $object->name;
                    $img = $object->name;
                    $default = false;
                } else {
                    $sql = mysqli_query($db, "SELECT `gender` FROM `users` WHERE `id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1 ");
                    if ($sql && mysqli_num_rows($sql) > 0) {
                        $object = mysqli_fetch_object($sql);
                        $image_path = $base_url . $image_directory . 'default/' . $object->gender . '.png';
                        $default = true;
                    } else {
                        $image_path = $base_url . $image_directory . 'default/m.png';
                        $default = true;
                    }
                }
            } else {
                $sql = mysqli_query($db, "SELECT `gender` FROM `users` WHERE `id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1 ");
                if ($sql && mysqli_num_rows($sql) > 0) {
                    $object = mysqli_fetch_object($sql);
                    $image_path = $base_url . $image_directory . 'default/' . $object->gender . '.png';
                    $default = true;
                } else {
                    $image_path = $base_url . $image_directory . 'default/m.png';
                    $default = true;
                }
            }
        } else {
            $image_path = $base_url . $image_directory . 'default/m.png';
            $default = true;
        }
        return ['image_path' => $image_path, 'img' => $img, 'default' => $default];
    }
}

if (!function_exists('getUserInfoFromId')) {
    function getUserInfoFromId($id)
    {
        global $db;

        $select = "SELECT u.company_id, c.name AS company_name, c.status AS company_status, 
        u.branch_id, b.name AS branch_name, b.company_email, b.hr_email, b.other_email,
        CONCAT('+',b.dial_code,' ',b.mobile) AS branch_mobile, b.phone AS branch_phone, b.fax AS branch_fax,
        b.web AS company_web, b.address AS branch_address, b.status AS branch_status, b.type AS branch_type,
        u.id AS user_id, u.email AS user_email, u.status AS user_status, u.type AS user_type, u.email_verified_at,
        u.employee_code, CONCAT(u.first_name,' ',u.last_name) AS full_name, u.first_name, u.last_name, u.pseudo_name, u.email, u.email AS official_email,
        country.country_name, state.state_name, time_zone.time_zone, city.city_name,
        email_verification.id AS email_verification_detail_id, email_verification.page_signature, email_verification.link_signature
        FROM
            users AS u
        INNER JOIN 
            companies AS c
            ON c.id = u.company_id
        INNER JOIN 
            branches AS b
            ON b.id = u.branch_id
        INNER JOIN 
            countries AS country
            ON country.id = u.country_id
        INNER JOIN 
            states AS state
            ON state.id = u.state_id
        INNER JOIN 
            time_zones AS time_zone
            ON time_zone.country_id = u.country_id
        INNER JOIN 
            cities AS city
            ON city.id = u.city_id
        LEFT JOIN 
            email_verification_details AS email_verification
            ON u.id = email_verification.user_id
        WHERE u.id='{$id}' ORDER BY u.id, email_verification.id DESC LIMIT 1";
        $sql = mysqli_query($db, $select);
        if (mysqli_num_rows($sql) > 0) {
            if ($fetch = mysqli_fetch_object($sql)) {
                unset($fetch->id);
                return $fetch;
            }
        }
    }
}

if (!function_exists('checkEmployeeActiveOrNot')) {
    function checkEmployeeActiveOrNot($id)
    {
        global $db;

        $working = config('employees.status.value.working');
        $status = mysqli_query($db, "SELECT id FROM employees WHERE id='{$id}' AND status='{$working}' AND deleted_at IS NULL LIMIT 1");
        return mysqli_num_rows($status) > 0 ? true : false;
    }
}

if (!function_exists('sortMultiDimensionalArrayAscendingByKey')) {
    function sortMultiDimensionalArrayAscendingByKey($array, $k)
    {
        usort($array, function ($a, $b) use ($k) {
            return $a[$k] - $b[$k];
        });
        return $array;
    }
}

if (!function_exists('sortMultiDimensionalArrayDescendingByKey')) {
    function sortMultiDimensionalArrayDescendingByKey($array, $k)
    {
        usort($array, function ($a, $b) use ($k) {
            return $b[$k] - $a[$k];
        });
        return $array;
    }
}

if (!function_exists('getAllAlphabeticChars')) {
    function getAllAlphabeticChars()
    {
        return range('A', 'Z');
    }
}

if (!function_exists('getAlphabetLetterByPosition')) {
    function getAlphabetLetterByPosition($value)
    {
        $value--;
        if ($value <= 26) {
            $alphas = getAllAlphabeticChars();
            return $alphas[$value];
        }
    }
}

if (!function_exists('numberToWord')) {
    function numberToWord($number = '')
    {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            '0' => '',
            '1' => 'one',
            '2' => 'two',
            '3' => 'three',
            '4' => 'four',
            '5' => 'five',
            '6' => 'six',
            '7' => 'seven',
            '8' => 'eight',
            '9' => 'nine',
            '10' => 'ten',
            '11' => 'eleven',
            '12' => 'twelve',
            '13' => 'thirteen',
            '14' => 'fourteen',
            '15' => 'fifteen',
            '16' => 'sixteen',
            '17' => 'seventeen',
            '18' => 'eighteen',
            '19' => 'nineteen',
            '20' => 'twenty',
            '30' => 'thirty',
            '40' => 'forty',
            '50' => 'fifty',
            '60' => 'sixty',
            '70' => 'seventy',
            '80' => 'eighty',
            '90' => 'ninety'
        );
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10]
                    . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
            } else {
                $str[] = null;
            }
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
        return $result;
    }
}

if (!function_exists('insertNotification')) {
    function insertNotification($type, $notify_from_id, $notify_to_employee_id, $model_id, $data, $link, $status, $company_id, $branch_id, $added_by)
    {
        global $db;
        $model = config("notifications.type.model." . $type);

        $insert = "INSERT INTO `notifications`(`id`, `type`, `notify_from_id`, `notify_to_id`, `model_id`, `model`, `data`, `link`, `status`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$type}', '{$notify_from_id}', '{$notify_to_employee_id}', '{$model_id}', '{$model}', '{$data}', '{$link}', '{$status}', '{$company_id}', '{$branch_id}', '{$added_by}')";
        mysqli_query($db, $insert);
        return mysqli_insert_id($db);
    }
}

if (!function_exists('deleteNotification')) {
    function deleteNotification($type, $model_id, $company_id, $branch_id, $notify_from_id = '', $notify_to_id = '')
    {
        global $db;
        $model = config("notifications.type.model." . $type);

        $c = " AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
        if (isset($notify_from_id) && !empty($notify_from_id)) {
            $c .= " AND `notify_from_id`='{$notify_from_id}'";
        }
        if (isset($notify_to_id) && !empty($notify_to_id)) {
            $c .= " AND `notify_to_id`='{$notify_to_id}'";
        }

        $delete = "DELETE FROM `notifications` WHERE `type`='{$type}' AND `model_id`='{$model_id}'" . $c;
        mysqli_query($db, $delete);
        return mysqli_affected_rows($db);
    }
}

if (!function_exists('getNotification')) {
    function getNotification($id)
    {
        global $db, $admin_url;
        $return = '';
        $unseen_notifications = 0;
        $status_read = config('notifications.status.value.read');

        $chk = mysqli_query($db, "SELECT `id` FROM `notifications` WHERE `notify_to_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id`");
        $total_notifications = mysqli_num_rows($chk);
        if ($total_notifications > 0) {
            $return .= '<div class="row py-2">
                <div class="col-md-12">
                    <span class="float-right">
                        <a href="">
                            See All (' . $total_notifications . ') <i class="ki ki-long-arrow-next"></i>
                        </a>
                    </span>
                </div>
            </div>';

            $check = mysqli_query($db, "SELECT `id` FROM `notifications` WHERE `notify_to_id`='{$id}' AND `status`!='{$status_read}' AND `deleted_at` IS NULL ORDER BY `id`");
            $unseen_notifications = mysqli_num_rows($check);

            $sql = mysqli_query($db, "SELECT * FROM `notifications` WHERE `notify_to_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` DESC LIMIT 0, 15");
            while ($data = mysqli_fetch_object($sql)) {
                //$type = $data->type;
                //$notify_from_id = $data->notify_from_id;
                //$notify_to_id = $data->notify_to_id;
                //$model_id = $data->model_id;

                if ($data->status == $status_read) {
                    if (empty($data->link)) {
                        $radio = '<div class="col-12 mt-3">
                            <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                            <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                        </div>';
                    } else {
                        $radio = '<div class="col-12 mt-3">
                            <a href="' . $data->link . '">
                                <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                            </a>
                            <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                        </div>';
                    }
                } else {

                    if (empty($data->link)) {
                        $radio = '
                    <div class="col-10 mt-1">
                            <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                        <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                    </div>
                    <div class="col-2 text-vertical-align-center">
                        <div class="radio-inline float-right">
                            <label title="Mark as read" class="radio radio-outline radio-outline-2x radio-primary">
                                <input title="Mark as read" type="radio" onclick="readNotification(' . $data->id . ')" checked="checked" value="' . $data->id . '">
                                <span></span>
                            </label>
                        </div>
                    </div>';
                    } else {
                        $radio = '
                    <div class="col-10 mt-3">
                        <a href="' . $data->link . '">
                            <div class="font-weight-bold font-size-md">' . $data->data . '</div>
                        </a>
                        <div class="text-muted font-size-sm">' . $data->created_at . '</div>
                    </div>
                    <div class="col-2 text-vertical-align-center">
                        <div class="radio-inline float-right">
                            <label title="Mark as read" class="radio radio-outline radio-outline-2x radio-primary">
                                <input title="Mark as read" type="radio" onclick="readNotification(' . $data->id . ')" checked="checked" value="' . $data->id . '">
                                <span></span>
                            </label>
                        </div>
                    </div>';
                    }
                }

                $return .= '
                    <div class="row py-3" data-id="' . $data->id . '">
                        <div class="col-md-3">
                            <div class="symbol symbol-60">
                                <div class="symbol-label"><div class="symbol-label" style="background-image:url(' . getUserImage($data->notify_from_id)['image_path'] . ')"></div></div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">' . $radio . '</div>
                        </div>
                    </div>';
            }
        } else {
            $return .= '
                <div class="row py-2">
                    <div class="col-md-12">
                       <h6 class="text-danger text-center">There is no notification.</h6>
                    </div>
                </div>';
        }
        return ['total_notifications' => $total_notifications, 'unseen_notifications' => $unseen_notifications, 'list_of_notifications' => $return,];
    }
}

if (!function_exists('encode')) {
    function encode($string)
    {
        if (!empty($string))
            return base64_encode($string);
    }
}

if (!function_exists('decode')) {
    function decode($string)
    {
        if (!empty($string))
            return base64_decode($string);
    }
}

if (!function_exists('getSuperAdmin')) {
    function getSuperAdmin($company_id, $branch_id)
    {
        global $db;
        $type = config('users.type.value.super_admin');
        $query = mysqli_query($db, "SELECT u.email, CONCAT(eb.first_name,' ',eb.last_name) AS full_name FROM users AS u INNER JOIN employees AS e ON u.employee_id=e.id INNER JOIN employee_basic_infos AS eb ON u.employee_id=eb.employee_id WHERE u.type='{$type}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' ORDER BY u.id ASC");
        return mysqli_num_rows($query) > 0 ? $query : false;
    }
}

if (!function_exists('getAdmin')) {
    function getAdmin($company_id, $branch_id)
    {
        global $db;
        $type = config('users.type.value.admin');
        $query = mysqli_query($db, "SELECT u.email, CONCAT(eb.first_name,' ',eb.last_name) AS full_name FROM users AS u INNER JOIN employees AS e ON u.employee_id=e.id INNER JOIN employee_basic_infos AS eb ON u.employee_id=eb.employee_id WHERE u.type='{$type}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' ORDER BY u.id ASC");
        return mysqli_num_rows($query) > 0 ? $query : false;
    }
}

if (!function_exists('getUserRights')) {
    function getUserRights($user_id, $branch_id)
    {
        global $db;
        $company_id = $_SESSION['company_id'];

        $data = [];

        $select = "SELECT * FROM `user_rights` WHERE `user_id` = '{$user_id}' AND `company_id` = '{$company_id}' AND `branch_id` = '{$branch_id}' ORDER BY `id` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $right = $result->main_menu_id . '_' . $result->sub_menu_id . '_' . $result->child_menu_id . '_' . $result->action;
                $data[] = $right;
            }
        }

        return $data;
    }
}

if (!function_exists('getAllLinks')) {
    function getAllLinks()
    {
        global $db;

        $m_active = config('main_menus.status.value.active');//1
        $s_active = config('sub_menus.status.value.active');//1
        $c_active = config('child_menus.status.value.active');//1

        $data = [];

        $select = "SELECT c.id, c.user_right_title, c.action, c.sub_menu_id, s.main_menu_id
        FROM
            child_menus AS c
        INNER JOIN
            sub_menus AS s
            ON c.sub_menu_id=s.id
        INNER JOIN
            main_menus AS m
            ON s.main_menu_id=m.id
        WHERE c.user_right_title IS NOT NULL AND  c.user_right_title !=''
        AND m.status = '{$m_active}' AND s.status = '{$s_active}'
        AND c.status = '{$c_active}' AND c.action != ''
        ORDER BY m.sort_by, s.sort_by, c.sort_by";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_assoc($query)) {
                $n = $result['user_right_title'];
                unset($result['user_right_title']);
                $data[$n][] = $result;
            }
        }

        return $data;
    }
}

if (!function_exists('getUserRightsHTML')) {
    function getUserRightsHTML($user_id, $branch_id)
    {
        global $db;
        $user_rights = getUserRights($user_id, $branch_id);
        $row_number = 0;

        $data = '
        <table class="datatable-table d-block">
            <thead class="datatable-head">
                <tr style="left:0" class="datatable-row">
                    <th class="datatable-cell datatable-cell-left">
                        <div class="float-left" style="width:40%" data-field="name">Name</div>
                        <div class="float-left" style="width:60%" data-field="action">Action</div>
                    </th>
                </tr>
            </thead>
            <tbody class="datatable-body">';

        $user_right_title_array = config('lang.user_right_title.title');

        foreach (getAllLinks() as $key => $v) {
            $row_number++;
            $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';

            if (array_key_exists($key, $user_right_title_array)) {
                $user_right_title = $user_right_title_array[$key];
            } else {
                $user_right_title = ucwords(str_replace('_', ' ', $key));
            }

            $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row datatable-row-' . $evenOrOdd . '">
                <td class="datatable-cell datatable-cell-left py-5">
                    <div class="float-left pt-2 font-weight-bolder" style="width:40%" data-field="name">' . $user_right_title . '</div>
                    <div class="float-left" style="width:60%" data-field="action">';
            foreach ($v as $column) {
                $m_id = $column['main_menu_id'];
                $s_id = $column['sub_menu_id'];
                $c_id = $column['id'];
                $switch_array = ['add' => 'primary', 'edit' => 'success', 'delete' => 'danger', 'view' => 'warning',];
                if (!empty($column['action'])) {
                    $action = json_decode($column['action'], true);
                    foreach ($action as $action_key => $action_value) {
                        $right = $m_id . '_' . $s_id . '_' . $c_id . '_' . $action_key;
                        $checked = in_array($right, $user_rights) ? ' checked="checked" ' : '';
                        $switch_class = array_key_exists($action_key, $switch_array) ? $switch_array[$action_key] : 'primary';

                        $data .= '<div class="form-group float-left overflow-hidden m-0 mr-5">
                        <label class="col-form-label float-left font-weight-bolder mr-1" style="padding: 5px 3px 0 0">
                            ' . $action_value . '
                        </label>
                        <div class="float-left">
                            <span class="switch switch-sm switch-outline switch-icon switch-' . $switch_class . '">
                                <label>
                                    <input type="checkbox" data-main_menu_id="' . $m_id . '" data-sub_menu_id="' . $s_id . '" data-child_menu_id="' . $c_id . '" value="' . $action_key . '" class="rightRepresentativeBox" name="rightRepresentativeBox[]" ' . $checked . '>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>';
                    }
                }
            }

            $data .= '</div></td></tr>';
        }
        $data .= '</tbody></table>';

        return $data;
    }
}

if (!function_exists('hasRight')) {
    function hasRight($user_right_title, $right)
    {
        global $db;
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $employee_id = $_SESSION['employee_id'];
        $user_id = $_SESSION['user_id'];
        $employee_info = getUserInfoFromId($employee_id);

        if ($employee_info->user_type != config('users.type.value.super_admin')) {
            $select = "SELECT ur.id
            FROM
                user_rights AS ur
            INNER JOIN 
                child_menus AS cm
                ON ur.child_menu_id=cm.id
            WHERE 
            ur.user_id='{$user_id}' AND ur.company_id='{$company_id}' AND ur.branch_id='{$branch_id}' 
            AND ur.action='{$right}' AND cm.user_right_title='{$user_right_title}' AND cm.user_right_title!=''
            ORDER BY ur.id ASC LIMIT 1";
            $query = mysqli_query($db, $select);
            if (mysqli_num_rows($query) > 0)
                return true;
            else
                return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('sendEmailVerificationEmail')) {
    function sendEmailVerificationEmail($employee_id)
    {
        global $base_url;

        $employeeInfo = getUserInfoFromId($employee_id);
        $url = $base_url . 'email_confirmation?signature=' . $employeeInfo->signed_url . '&code=' . $employeeInfo->verification_code . '&ei=' . $employee_id;

        $subject = 'email_confirmation';
        $mail_body = getMailBody($subject, ['{mailToName}' => $employeeInfo->full_name, '{link}' => $url]);
        $parameters = [
            'subject' => $subject,
            'data' => [
                'email_body' => $mail_body['html'],
                'message' => $mail_body['message'],
            ],
            'mailTo' => [
                'email' => $employeeInfo->user_email,
                'name' => $employeeInfo->full_name,
            ]
        ];
        return sendEmail($parameters);
    }
}

if (!function_exists('getSalesPersonImage')) {
    function getSalesPersonImage($id)
    {
        global $db, $base_url;
        $image_directory = 'storage/sales_person_images/';
        $img = '';

        if (!empty($id) && is_numeric($id) && $id > 0) {
            $sql = mysqli_query($db, "SELECT `name` FROM `sales_person_images` WHERE `sales_person_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1 ");
            if ($sql && mysqli_num_rows($sql) > 0) {
                $object = mysqli_fetch_object($sql);
                $path = dirname(__DIR__) . '/' . $image_directory . $object->name;
                if (realpath($path)) {
                    $image_path = $base_url . $image_directory . $object->name;
                    $img = $object->name;
                    $default = false;
                } else {
                    $sql = mysqli_query($db, "SELECT `gender` FROM `sales_persons` WHERE `id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1 ");
                    if ($sql && mysqli_num_rows($sql) > 0) {
                        $object = mysqli_fetch_object($sql);
                        $image_path = $base_url . $image_directory . 'default/' . $object->gender . '.png';
                        $default = true;
                    } else {
                        $image_path = $base_url . $image_directory . 'default/m.png';
                        $default = true;
                    }
                }
            } else {
                $sql = mysqli_query($db, "SELECT `gender` FROM `sales_persons` WHERE `id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1 ");
                if ($sql && mysqli_num_rows($sql) > 0) {
                    $object = mysqli_fetch_object($sql);
                    $image_path = $base_url . $image_directory . 'default/' . $object->gender . '.png';
                    $default = true;
                } else {
                    $image_path = $base_url . $image_directory . 'default/m.png';
                    $default = true;
                }
            }
        } else {
            $image_path = $base_url . $image_directory . 'default/m.png';
            $default = true;
        }
        return ['image_path' => $image_path, 'img' => $img, 'default' => $default];
    }
}

if (!function_exists('changeSalesPersonImage')) {
    function changeSalesPersonImage($id, $imageBase64, $user_right_title)
    {
        global $db, $base_url;
        $image_directory = 'storage/sales_person_images/';
        $upload_image = false;
        $user_id = $_SESSION['user_id'];

        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64) = explode(',', $imageBase64);

        $image = base64_decode($imageBase64);
        $imageName = $id . '_' . generatePassword('35', TRUE) . '.png';

        $sql = mysqli_query($db, "SELECT `id`,`name` FROM `sales_person_images` WHERE `sales_person_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1");
        if (mysqli_num_rows($sql) > 0) {
            if (hasRight($user_right_title, 'edit')) {
                $res = mysqli_fetch_object($sql);
                if (!empty($res->name) && realpath(dirname(__DIR__) . '/' . $image_directory . $res->name)) {
                    unlink('../../' . $image_directory . $res->name);
                }
                if (mysqli_query($db, "DELETE FROM `sales_person_images` WHERE `sales_person_id`='{$id}'")) {
                    $upload_image = true;
                }
            }
        } else {
            if (hasRight($user_right_title, 'add')) {
                $upload_image = true;
            }
        }

        if ($upload_image && $upload_image === true) {
            $query = "INSERT INTO `sales_person_images`(`id`, `sales_person_id`, `name`, `added_by`) VALUES (NULL,'{$id}','{$imageName}','{$user_id}')";
            if (mysqli_query($db, $query)) {
                file_put_contents('../../' . $image_directory . $imageName, $image);
            }
        }


        //
    }
}

if (!function_exists('getAccounts')) {
    function getAccounts($id, $type, $account_id)
    {
        global $db;

        $data = '<option selected="selected" value="-1">Select</option>';
        $select = "SELECT `id`, `name` FROM `accounts` WHERE `type`='{$type}' AND `source_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `name` ASC";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            while ($result = mysqli_fetch_object($query)) {
                $selected = '';
                if ($account_id == $result->id) {
                    $selected = ' selected="selected" ';
                }
                $data .= '<option value="' . $result->id . '"' . $selected . '>' . $result->name . '</option>';
            }
        }
        return $data;
    }
}

?>