<?php
$CI = &get_instance();

/*** start file function ***/

function countlength($array){
    $count = 0;
    foreach($array as $key => $value){
        $count++;
    }
    return $count;
}

function save_mem_social_image($image){
    $image = @file_get_contents($image);
    $file_name = md5(rand(100, 1000)) . '_' . time() . '_' . rand(1111, 9999) . '.jpg';
    $dir = UPLOAD_VPATH . 'vp/' . $file_name;

    if (@file_put_contents($dir, $image))
        generate_vimage_thumbs($file_name);
    return $file_name;
}

function upload_vfile($field_name, $type = 'image', $size = 2100000){
    $type_arr = array('image' => 'gif|jpg|jpeg|png|svg', 'file' => 'gif|jpg|jpeg|png|pdf|doc|docx|xlsx|word|xls|csv|txt|text', 'att' => 'gif|jpg|jpeg|png|pdf|doc|docx|xlsx|word|xls|csv|txt|text|mp3|mp4', 'audio' => 'mp3', 'video' => 'mp4|webm');
    $upload_path = $type == 'image' ? UPLOAD_VPATH . "vp" : UPLOAD_VPATH . "attachments";
    $types = $type_arr[$type];
    $CI = get_instance();
    $stamp = md5(rand(100, 1000)) . '_' . time() . '_' . rand(1111, 9999);
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = $types;
    $config['max_size'] = $size;
    $config['file_name'] = $stamp;
    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);
    if (!$CI->upload->do_upload($field_name)) {
        $image['error'] = $CI->upload->display_errors();
        return $image;
    } else {
        $image = $CI->upload->data();
        if ($type == 'image') {
            generate_vimage_thumbs($image['file_name']);
        }
        return $image;
    }
}

function get_vsize_dirs(){
    return array('50' => 'p50x50/', '150' => 'p150x150/', '300' => 'p300x300/', '350' => 'p350x350/', '400' => 'p400x400/');
}

function generate_vimage_thumbs($image){
    $img_sizes = get_vsize_dirs();
    foreach ($img_sizes as $size => $directory) {
        $directory = UPLOAD_VPATH . $directory;
        generate_thumb(UPLOAD_VPATH . "vp/", $directory, $image, $size);
    }
}

function remove_vfile($img, $type = 'image'){
    if (!empty($img)) {
        if ($type == 'image') {
            $img_sizes = get_vsize_dirs();
            $img_sizes['vp'] = 'vp/';
        } else {
            $img_sizes['attachments'] = 'attachments/';
        }
        foreach ($img_sizes as $size => $directory) {
            $filepath = UPLOAD_VPATH . $directory . $img;
            if (is_file($filepath))
                unlink($filepath);
        }
        return true;
    }
    return false;
}

function remove_gellary_vfile($ref_id, $ref_type){
    $CI = get_instance();
    $mem_images = $CI->master->getRows('gallery', array('ref_id' => $ref_id, 'ref_type' => $ref_type));
    if (countlength($mem_images) > 0) {
        foreach ($mem_images as $key => $img) {
            $img_sizes = get_vsize_dirs();
            $img_sizes['vp'] = 'vp/';
            foreach ($img_sizes as $size => $directory) {
                $filepath = UPLOAD_VPATH . $directory . $img->image;
                if (is_file($filepath))
                    unlink($filepath);
            }
            $CI->master->delete('gallery', 'id', $img->id);
        }
        return true;
    }
    return false;
}

function upload_image($path, $field_name, $pre_fix = 'image'){
    $CI = get_instance();
    $stamp = time() . '_' . rand(1111, 9999);
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'gif|jpg|jpeg|png|svg';
    $config['max_size'] = 2100000;
    $config['file_name'] = $pre_fix . "_" . $stamp;

    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);

    if (!$CI->upload->do_upload($field_name)) {
        $image['error'] = $CI->upload->display_errors();
        return $image;
    } else {
        $image = $CI->upload->data();
        return $image;
    }
}



function upload_file($path, $field_name, $type = 'image', $custom_name = '', $size = 2100000){
    // pr($path);
    $type_arr = array('image' => 'gif|jpg|jpeg|png|svg', 'file' => 'gif|jpg|jpeg|png|pdf|doc|docx|xlsx|word|xls|csv|txt|text|zip|7zip|rar', 'attach' => 'gif|jpg|jpeg|png|pdf|doc|docx|xlsx|word|xls|csv|txt|text', 'audio' => 'mp3', 'video' => 'mp4|webm');
    $type = $type_arr[$type];
    $stamp = empty($custom_name) ? (md5(rand(100, 1000)) . '_' . time() . '_' . rand(1111, 9999)) : $custom_name;
    $CI = get_instance();
    $config['upload_path'] = $path;
    $config['allowed_types'] = '*';
    $config['max_size'] = $size;
    $config['file_name'] = $stamp;

    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);

    // pr($CI->upload);
    if (!$CI->upload->do_upload($field_name)) {
        $image['error'] = $CI->upload->display_errors();
        return $image;
    } else {
        $image = $CI->upload->data();
        return $image;
    }
}

function create_file_copy($src, $destination){
    $res = copy($src, $destination);
    return $res;
}

function upload_audio($path, $field_name){
    global $CI;
    $CI = &get_instance();
    $stamp = time();
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'mp3';
    $config['max_size'] = 2100000;
    $config['file_name'] = "audio_" . $stamp;
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if (!$CI->upload->do_upload($field_name)) {
        $image['error'] = $CI->upload->display_errors();
        return $image;
    } else {
        $image = $CI->upload->data();
        return $image;
    }
}

function upload_video($path, $field_name){
    global $CI;
    $CI = &get_instance();
    $stamp = time();
    $config['upload_path'] = $path;
    $config['allowed_types'] = '*';
    $config['max_size'] = 2100000;
    $config['file_name'] = "video_" . $stamp. '.mp4';

    $CI->load->library('upload');
    $CI->upload->initialize($config);

    if (!$CI->upload->do_upload($field_name)) {
        $image['error'] = $CI->upload->display_errors();
        return $image;
    } else {
        $image = $CI->upload->data();
        return $image;
    }
}

function generate_thumb($frompath, $topath, $file_name, $thumb_width = 100, $type = ''){
    $CI = &get_instance();
    $CI->load->library('Simpleimage');
    $CI->simpleimage->load($frompath . $file_name);
    $CI->simpleimage->resizeToWidth($thumb_width);
    $CI->simpleimage->save($topath . $type . $file_name);
    return $type . $file_name;
}

function getImageSrcEditor($image) {
    if (!empty($image)) {
        $ary = explode("/", $image);
        if (file_exists($image) && !empty($ary[countlength($ary) - 1])) {
            $image = str_replace('../', '', $image);
            $image = str_replace('./', '', $image);
//            if ($_SERVER['HTTP_HOST'] != 'localhost') {
                return base_url() . $image;
//            } else {
//                return base_url() . 'assets/images/no_pic.jpg';
//            }
        }
    }
    return base_url('assets/images/no_image.jpg');
}

function getImageSrc($path, $image, $no_image_type = ''){
    if (!empty($image)) {
        return base_url() . $path . $image;
    } else {
        if ($no_image_type == 'member') {
            return base_url() . 'assets/images/no_image.jpg';
        } else {
            return base_url() . 'assets/images/no-image.svg';
        }
    }
}

function get_image_src($image, $type = 'full', $user_image = ''){
    // if(date('H')>=18){
    $path_arr = array('50' => 'p50x50', '150' => 'p150x150', '300' => 'p300x300', '350' => 'p350x350', '400' => 'p400x400', 'full' => 'vp', 'att' => 'attachments', 'temp' => 'temp', 'temp_ico' => 'temp/p150x150');
    $filepath = SITE_VPATH . $path_arr[$type] . '/' . $image;
    if (!empty($image) && @getimagesize($filepath)) {
        return $filepath;
    }
   // }
    return empty($user_image) ? base_url('assets/images/no-image.svg') : base_url('assets/images/no-user.svg');
}

function get_site_image_src($path, $image, $type = '', $user_image = false){
    $filepath = base_url() . UPLOADS . $path . '/' . $type . $image;
    if (!empty($image) && @file_exists(FCPATH . 'uploads/' . $path . '/' . $type . $image)) {
        return $filepath;
    }
    return empty($user_image) ? base_url('assets/images/no_image.jpg') : base_url('assets/images/no-user.svg');
}

function get_site_video($path,$video){
    $filepath=UPLOAD_PATH.$path.'/'.$video;
    if(!empty($video) && @file_exists(FCPATH.'uploads/'.$path.'/'.$video)){
         return base_url($filepath);
    }
    return base_url('assets/404.mp4');
}

function get_site_zip_file($path, $zip_file){
    $filepath = base_url() . UPLOADS . $path . '/' . $zip_file;
    if (!empty($zip_file) && @file_exists(FCPATH . 'uploads/' . $path . '/' . $zip_file)) {
        return '<a href="'.$filepath.'" class="btn btn-info" > Download File </a>';
    }else{
        return '<img src="'.base_url("assets/images/no-zip.png").'" alt="--">';
    }
}

function getImageDimension($image){
    if (!empty($image)) {
        $ary = explode("/", $image);
        if (file_exists($image) && !empty($ary[countlength($ary) - 1])) {
            list($width, $height) = getimagesize($image);
            return $width . "x" . $height;
        }
    }
    // return '768x1191';
    return '';
}
/*** end file function ***/

### Static SELECT values

function price_format($price){
    return number_format((float)$price, 2, '.', '');
}

function char_limit($x, $length){
    if (strlen($x) <= $length) {
        echo $x;
    } else {
        $y = substr($x, 0, $length) . '...';
        echo $y;
    }
}

function getBredcrum($section, $ary){
    $bcrum = '
    <ol class="breadcrumb">
    <li>
    <a href="' . base_url($section) . '"><i class="fa fa-home"></i>Home</a>
    </li>';
    foreach ($ary as $key => $value) {
        if ($key == '#') {
            $bcrum .= '<li class="active"><strong>' . $value . '</strong></li>';
        } else {
            $bcrum .= '<li><a href="' . base_url($section . '/' . $key) . '">' . $value . '</a></li>';
        }
    }

    $bcrum .= '</ol>';
    return $bcrum;
}

function sepreat_comb($comb){
    $label = "";
    $arr = explode(',', $comb);
    foreach ($arr as $keys => $vals) {
        $label .= "<span class='badge'>" . $vals . "</span>";
    }
    return $label;
}

function checkEmptyp($val){
    if (!empty($val)) {
        return $val;
    }
    return "N/A";
}

function pr($ary, $exit = true){
    echo "<pre>";
    print_r($ary);
    echo "</pre>";
    if ($exit)
        exit;
}

function print_query(){
    global $CI;
    die($CI->db->last_query());
}

function get_default($value, $default = 'None'){
    if (empty($value))
        return $default;
    else
        return $value;
}

function showMsg($type = '', $msg = ''){
    global $CI;
    if (empty($type) && empty($msg)) {
        $type = $CI->session->userdata('f_type');
        $msg = $CI->session->userdata('f_msg');
        $CI->session->unset_userdata('f_type');
        $CI->session->unset_userdata('f_msg');
    }

    if ($type != '' && $msg != '') {
        switch ($type) {
            case 'success':
                /*return '<div class="alertMsg"><div class="alert alert-success"><button data-dismiss="alert" class="close"> × </button><strong>Success:</strong> ' . $msg . '</div><div class="clearfix"></div></div>';*/
                return '<div class="alertMsg"><div class="alert alert-success"><strong>Success:</strong> ' . $msg . '</div><div class="clearfix"></div></div>';
                break;

            case 'error':
                // return '<div class="alertMsg"><div class="alert alert-danger"><button data-dismiss="alert" class="close"> × </button><strong>Error: </strong> ' . $msg . '</div><div class="clearfix"></div></div>';
                return '<div class="alertMsg"><div class="alert alert-danger"><!--<strong>Error: </strong>--> ' . $msg . '</div><div class="clearfix"></div></div>';
                break;

            case 'warning':
                // return '<div class="alertMsg"><div class="alert alert-warning"><button data-dismiss="alert" class="close"> × </button><strong>Warning:</strong> ' . $msg . '</div><div class="clearfix"></div></div>';
                return '<div class="alertMsg"><div class="alert alert-warning"><strong>Warning:</strong> ' . $msg . '</div><div class="clearfix"></div></div>';
                break;

            default:
                // return '<div class="alertMsg"><div class="alert alert-info"><button data-dismiss="alert" class="close"> × </button><strong>Info:</strong> ' . $msg . '</div><div class="clearfix"></div></div>';
                return '<div class="alertMsg"><div class="alert alert-info"><strong>Info:</strong> ' . $msg . '</div><div class="clearfix"></div></div>';
                break;
        }
    }
}

function setMsg($type, $msg){
    global $CI;
    $CI->session->set_userdata('f_type', $type);
    $CI->session->set_userdata('f_msg', $msg);
}

function setPost($vals){
    $CI = &get_instance();
    $CI->session->set_flashdata('f_post', $vals);
}

function showVal($val){
    if (isset($val))
        return $val;
}

function cms_button($val){
    if (isset($val))
        return base_url($val);
}

function get_order_status($status){
    if ($status == 0) {
        return '<span class="badge blue">Pending</span>';
    } elseif($status == 2) {
        return '<span class="badge red">Cancelled</span>';
    } else {
        return '<span class="badge green">Complete</span>';
    }
}

function get_membership_status($status){
    if ($status == 0)
        return '<strong style="color:red;">Canceled</strong>';
    else
        return '<strong style="color:green;">Active</strong>';
}

function get_paid_status($status){
    if ($status == 0) {
        return '<span class="badge yellow">Pending</span>';
    } else {
        return '<span class="badge green">Complete</span>';
    }
}

function get_paid_status_withdraws($status){
    if ($status == 'pending') {
        return '<span class="badge yellow">Pending</span>';
    } else {
        return '<span class="badge green">Complete</span>';
    }
}

function yes_no_status($status){
    if ($status == '1') {
        return '<strong style="color:green;">Yes</strong>';
    } else {
        return '<strong style="color:blue;">No</strong>';
    }
}

function get_order_status_label($status){
    if ($status == '0') {
        return '<span class="badge blue">New Order </span>';
    } else if ($status == '1') {
        return '<span class="badge green">Seen</span>';
    }
    else{
        return '<span class="badge red">Cancelled</span>';
    }
}

function convertYoutube($string) {
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<iframe width=\"100%\" height=\"315\" src=\"//www.youtube.com/embed/$2\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>",
        $string
    );
}

function get_contact_seen_status($status){
    if ($status == '0') {
        return '<span class="badge blue">Un Seen</span>';
    }
    else if ($status == '1') {
        return '<span class="badge green">Seen</span>';
    }
}

function get_subscription_status($status){
    if ($status == 'active') {
        return '<span class="badge green">Active</span>';
    }
    else if ($status == 'non-renewing') {
        return '<span class="badge orange">Non-Renewing</span>';
    }else if ($status == 'attention') {
        return '<span class="badge blue">Attention</span>';
    }else if ($status == 'completed') {
        return '<span class="badge green">Completed</span>';
    }else if ($status == 'cancelled') {
        return '<span class="badge red">Cancelled</span>';
    }
}

function get_member_active_status($status){
    if ($status == '0') {
        return '<span class="badge red">In active</span>';
    }
    else if ($status == '1') {
        return '<span class="badge green">Active</span>';
    }
}

function get_member_verified_status($status){
    if ($status == '0') {
        return '<span class="badge red">Non Verified</span>';
    }
    else if ($status == '1') {
        return '<span class="badge green">Verified</span>';
    }
}

function get_member_type($mem_type){
    if ($mem_type == 'professional') {
        return '<h4><span class="label label-success">Professional</span></h4>';
    }
    else if ($mem_type == 'member') {
        return '<h4><span class="label label-primary">Buyer</span></h4>';
    }
}

function get_order_payment_status($status)
{
    if ($status == 'paid') {
        return '<span class="badge green">Paid</span>';
    } else if ($status == 'pending') {
        return '<span class="badge yellow">Pending</span>';
    }
}

function get_payment_method($status){
    if ($status == 'credit-card') {
        return '<span><b>Credit Card</b></span>';
    } else if ($status == 'paypal') {
        return '<span><b>PayPal</b></span>';
    }
}

function get_proof_status_label($status){
    if ($status == 'pending') {
        return '<span class="badge yellow">Pending</span>';
    } else if ($status == 'accepted') {
        return '<span class="badge green">Accepted</span>';
    } else if ($status == 'rejected') {
        return '<span class="badge red">Rejected</span>';
    }
}

function verified_status($status){
    if ($status == '1') {
        return '<strong style="color:green;">Yes</strong>';
    } else {
        return '<strong style="color:red;">No</strong>';
    }
}

function getStatus($status){
    if ($status == '1') {
        return '<strong style="color:green;">Active</strong>';
    } else {
        return '<strong style="color:red;">Inactive</strong>';
    }
}

function get_registration_status($status){
    $status_arr = array('new' => 'yellow', 'accepted' => 'green', 'deposit paid', 'paid', 'declined', 'hold', 'waitlist' => 'gray', 'canceled' => 'red');
    return '<span class="badge ' . $status_arr[$status] . '">' . ucwords($status) . '</span>';
}

function get_active_status($status){
    if ($status == 1) {
        return '<span class="badge green">Active</span>';
    } else {
        return '<span class="badge red">Inactive</span>';
    }
}

function get_mc_request_status($status){
    if ($status == 'pending') {
        return '<span class="badge yellow">Pending</span>';
    }elseif ($status == 'completed'){
        return '<span class="badge green">Completed</span>';
    } elseif ($status == 'in_progress'){
        return '<span class="badge blue">In Progress</span>';
    } 
    else {
        return '<span class="badge red">Rejected</span>';
    }
}

function get_suscription_status($status){
    if ($status == 1) {
        return '<span class="badge yellow">active</span>';
    }
    else if($status == 2)
    {
        return '<span class="badge gray">past_due</span>';
    }
    else
    {
        return '<span class="badge red">cancelled</span>';
    }
}

function service_selected_status($arr, $id){
    if (in_array($id, $arr)) {
        return 'del_btn';
    } else {
        return 'add_btn';
    }
}




function SubscriptionStatus($row){
    $current_date = date("Y-m-d");
    $expire_date = date("Y-m-d", strtotime($row->expire_date));
    if ($current_date <= $expire_date) {
        return '<strong style="color:green;">Active</strong>';
    } else {
        return '<strong style="color:red;">Expire</strong>';
    }
}

function getFeatured($status){
    if ($status == '1') {
        return '<strong style="color:green;">Yes</strong>';
    } else {
        return '<strong style="color:red;">No</strong>';
    }
}

function getPayStatus($status){
    if ($status == '1') {
        return '<strong style="color:green;">Complete</strong>';
    } else {
        return '<strong style="color:red;">Pending</strong>';
    }
}

function getStatusYesNo($status){
    if ($status == '1') {
        return '   <span class="green">Complete</span>';
    } else {
        return '   <span class="yellow">Pending</span>';
    }
}

function doEncode($data, $key = "preciousprotection")
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $cipherText = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    return base64_encode($iv . $cipherText);
}

function doDecode($encryptedData, $key = "preciousprotection")
{
    $data = base64_decode($encryptedData);
    $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $cipherText = substr($data, openssl_cipher_iv_length('aes-256-cbc'));

    return openssl_decrypt($cipherText, 'aes-256-cbc', $key, 0, $iv);
}


function format_amount($amount, $size = 2){
    $amount = floatval($amount);
    return $amount >= 0 ? "NGN " . number_format($amount, $size) : "NGN  (" . number_format(abs($amount), $size) . ')';
}

function num_size($num,$size=6){
    return sprintf('L&P'.'%0'.$size.'d',$num);
}

function num($val, $size = 2){
    return number_format(floatval($val), $size, '.', '');
}

function calculatePer($total, $portion){
    if($portion == null){
        return 0;
    }
    else{
        return $percentage = ($portion / $total) * 100; // 20
    }
}

function randCode($length = 8, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'){
    $chars_length = (strlen($chars) - 1);
    $string = $chars[rand(0, $chars_length)];

    for ($i = 1; $i < $length; $i = strlen($string)) {
        $r = $chars[rand(0, $chars_length)];
        if ($r != $string[$i - 1])
            $string .= $r;
    }
    return strtoupper($string);
}

function checkEmail($email){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function checkUsername($username){
    if (preg_match('/^[a-zA-Z0-9]{3,}$/', $username)) {
        return true;
    }
    return false;
}

function checkPassword($password){
    if (preg_match('/^[a-zA-Z0-9]{5,}$/', $password)) {
        return true;
    }
    return false;
}

function setZeroVal($val, $length = 6){
    $output = NULL;
    for ($i = 0; $i < intval($length) - strlen($val); $i++) {
        $output .= '0';
    }
    return $output . $val;
}

function toSlugUrl($text){
    $text = trim($text);
    $text = str_replace("&quot", '', $text);
    $text = preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
    $text = str_replace("--", '-', $text);
    $text = str_replace("--", '-', $text);
    return strtolower($text);
}

function getImgSize($image){
    $size = filesize($image);
    return intval($size / 1024);
}

function currentURL(){
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on" ? "s" : "");
    $proto = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($proto, 0, strpos($proto, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);

    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

function makeExternalUrl($url){
    if (strpos($url, 'http') === false) {
        $url = 'http://' . $url;
    }
    return $url;
}

function remove_file_from_directry($id, $table_name){
    global $CI;
    $ary = $CI->master->getRow($table_name, array('id' => $id));
    unlink('./assets/site-content/images/' . $ary->src);
    unlink('./assets/site-content/images/thumb/' . $ary->src);
    return;
}

function send_email($vals){
    global $CI;
    $CI = get_instance();
    if ($vals) {
        $email_to = $vals['site_email'];
        $msg = "Name: " . $vals['name'] . "<br>";
        $msg .= "Email: " . $vals['email'] . "<br>";
        // $msg .= "Order Number: " . $vals['order_number'] . "<br>";
        $msg .= "Phone: " . $vals['full_phone'] . "<br>";
        $msg .= "Subject: " . $vals['subject'] . "<br>";
        $msg .= "Message: " . $vals['msg'] . "<br>";
        $sub = "Contact Email";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . stripslashes($vals['name']) . $vals['site_noreply_email'] . "\r\n";
        if (@mail($email_to, $sub, $msg, $headers)) {
            return 1;
        } else {
            return 0;
        }
    }
    redirect(currentURL());
}

function send_site_email($mem_data, $key, $template = 'email'){
    $CI = get_instance();
    $data['site_settings'] = $CI->master->getRow("siteadmin", array('site_id' => '1'));
    extract($mem_data);
    $msg_body = addslashes(getSiteText('email', $key));
    eval("\$msg_body = \"$msg_body\";");
    $msg_body = stripslashes($msg_body);
    if (!empty($mem_data['link']))
        $msg_body .= "<p><a href='{$mem_data['link']}' style='color: #37b36f; text-decoration: none;'>" . $mem_data['link'] . "</a></p>";
    $emailto = $mem_data['email'];
    $subject = getSiteText('email', $key, 'subject');
    // $subject = $data['site_settings']->site_name." - ".getSiteText('email', $key, 'subject');
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html;charset=utf-8\r\n";
    $headers .= "From: " . $data['site_settings']->site_name . " <" . $data['site_settings']->site_noreply_email . ">" . "\r\n";
    $headers .= "Reply-To: " . $data['site_settings']->site_name . " <" . $data['site_settings']->site_email . ">" . "\r\n";

    $data['mem_data'] = $mem_data;
    $data['email_body'] = $msg_body;
    $data['email_subject'] = $subject;
    $ebody = $CI->load->view('includes/template-' . $template, $data, TRUE);
    // exit($ebody);
    if (@mail($emailto, $subject, $ebody, $headers)) {
        return 1;
    } else {
        return 0;
    }
}

function send_site_admin_email($mem_data, $key, $template = 'email'){
    $CI = get_instance();
    $data['site_settings'] = $CI->master->getRow("siteadmin", array('site_id' => '1'));
    extract($mem_data);
    $msg_body = addslashes(getSiteText('email', $key));
    eval("\$msg_body = \"$msg_body\";");
    $msg_body = stripslashes($msg_body);
    if (!empty($mem_data['link']))
        $msg_body .= "<p><a href='{$mem_data['link']}' style='color: #37b36f; text-decoration: none;'>" . $mem_data['link'] . "</a></p>";
    $emailto =  $data['site_settings']->site_email;
    $subject = "New Order has been placed";
    // $subject = $data['site_settings']->site_name." - ".getSiteText('email', $key, 'subject');
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html;charset=utf-8\r\n";
    $headers .= "From: " . $data['site_settings']->site_name . " <" . $data['site_settings']->site_noreply_email . ">" . "\r\n";
    $headers .= "Reply-To: " . $mem_data['name'] . " <" . $mem_data['email'] . ">" . "\r\n";
    $data['mem_data'] = $mem_data;
    $data['email_body'] = $msg_body;
    $data['email_subject'] = $subject;
    $ebody = $CI->load->view('includes/template-' . $template, $data, TRUE);
    // exit($ebody);
    if (@mail($emailto, $subject, $ebody, $headers)) {
        return 1;
    } else {
        return 0;
    }
}

function imageToBase64($path, $image){
    //return $path . $image;
    $type = pathinfo($path . $image, PATHINFO_EXTENSION);
    $data = file_get_contents($path . $image);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

function base64ToImage($path, $base64Image){
    list($type, $data) = explode(';', $base64Image);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    $imagename = time() . '_' . rand(1111, 9999) . '.png';
    file_put_contents($path . $imagename, $data);
    return $imagename;
}

function is_in_string($str, $main_str = 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'){
    $pos = strpos($main_str, $str);
    if ($pos === false) {
        $CI = get_instance();
        $CI->form_validation->set_message('is_in_string', 'Please select valid {field}');
        return false;
    }
    return true;
}

function get_meridian_time($d){
    $d = str_replace('/', '-', $d);
    return date("h:i A", strtotime($d));
}

function get_full_time($d){
    $d = str_replace('/', '-', $d);
    return date("H:i", strtotime($d));
}

function earning_status_badge($val){
    if ($val == 'pending') {
        return 'yellow';
    } else if ($val == 'available') {
        return 'yellow';
    } else if ($val == 'paid') {
        return 'green';
    } else {
        return 'blue';
    }
}

function earning_status($val){
    if ($val == 'pending') {
        return 'Pending';
    } else if ($val == 'paid') {
        return 'Cleared';
    } else if ($val == 'available') {
        return 'In Balance';
    } else {
        return 'Requested';
    }
}

function hours_format($h){
    $d = @explode('.', $h);
    // return countlength($d)==2?$d[0].'h '.$d[1].'m':$d[0].'h';
    if (countlength($d) == 1 && $d[0] != 0)
        return $d[0] . 'h';
    if (countlength($d) == 2 && $d[0] != 0 && $d[1] != 0)
        return $d[0] . 'h ' . ($d[1] * 6) . 'm';
    if (countlength($d) == 2 && $d[0] == 0 && $d[1] != 0)
        return ($d[1] * 6) . 'm';
}

function format_date($d, $format = '', $default_show = 'TBD'){
    $format = empty($format) ? 'm/d/Y' : $format;
    // $d = str_replace('/', '-', $d);
    if ($d == '0000:00:00' || $d == '0000-00-00' || !$d)
        return $default_show;
    $d = (is_numeric($d) && (int)$d == $d) ? $d : strtotime($d);
    return date($format, $d);

}

function makeSalaryString($min, $max, $interval) {
    $min = (int)$min;
    $max = (int)$max;
    if ($min === 0 && $max === 0) return "Competitive";
    else if ($min > 0 && $max === 0) return $min.' / '.$interval;
    else if ($min > 0 && $max > 0) return $min.' - '.$max.' / '.$interval;
    else return "Not Specified";
  }

function format_date_log_format($day, $format = '', $check = true, $default_show = 'TBD'){
    if ($check) {
        $dayIndex = explode('-', $day);
        $day = $dayIndex[2] . '-' . $dayIndex[0] . '-' . $dayIndex[1];
    }
    $format = empty($format) ? 'm/d/Y' : $format;
    if ($day == '0000:00:00' || $day == '0000-00-00' || !$day)
        return $default_show;
    $day = (is_numeric($day) && (int)$day == $day) ? $day : strtotime($day);
    return date($format, $day);
}

function db_format_date($d){
    $d = str_replace('-', '/', $d);
    pr($d);
    return empty($d) ? '' : date('Y-m-d', strtotime($d));
}

function db_format_date_csv($d){
    $d = str_replace('/', '-', $d);
    return empty($d) ? '' : date('Y-m-d', strtotime($d));
}

function db_format_date_csv_upload($d){
    $d = str_replace('/', '-', $d);
    return empty($d) ? '' : date('Y-m-d h:i:s', strtotime($d));
}

function db_format_date_csv_upload_new($d){
    $d = str_replace('/', '-', $d);
    $indexes = explode('-', $d);
    $dateTime = explode(' ', $indexes[2]);
    $final = $dateTime[0].'-'.$indexes[0].'-'.$indexes[1].' '.$dateTime[1];
    return empty($d) ? '' : date('Y-m-d h:i:s', strtotime($final));
}

function is_valid_date($date, $format = 'm/d/Y'){
    $CI = get_instance();
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    $CI->form_validation->set_message('is_valid_date', 'Please select valid {field}');
    return $d && $d->format($format) === $date;
}

function is_min_valid_date($date, $format = 'm/d/Y'){
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    if ($d && $d->format($format) === $date) {
        $date_now = new DateTime();
        $date2    = new DateTime($date);
        // if ($date_now<$date2) {
        exit($date_now->format('Y-m-d') . ' = ' . $date2->format('Y-m-d'));
        if ($date_now->format('Y-m-d') <= $date2->format('Y-m-d')) {
            return true;
        }
    }
    $CI = get_instance();
    $CI->form_validation->set_message('is_min_valid_date', 'Please select valid {field}');
    return false;
}

function compare_dates($date1, $date2, $format = 'm/d/Y'){
    $d1 = DateTime::createFromFormat($format, $date1);
    $d2 = DateTime::createFromFormat($format, $date2);
    if ($d1->format('Y-m-d') <= $d2->format('Y-m-d'))
        return true;
}

function compare_dates_jobs($date1, $date2, $format = 'm/d/Y'){
    $d1 = DateTime::createFromFormat($format, $date1);
    $d2 = DateTime::createFromFormat($format, $date2);
    if ($d1->format('Y-m-d') < $d2->format('Y-m-d'))
        return true;
	else
		return false;
}

function chat_message_time($time){
    return format_date($time) . ' at ' . get_full_time($time);
}

function get_dates_days($date1, $date2, $format = 'Y-m-d H:i:s'){
    $d1 = DateTime::createFromFormat($format, $date1);
    $d2 = DateTime::createFromFormat($format, $date2);
    $interval = $d1->diff($d2);
    return $interval->d;
}

function get_between_dates($date1, $date2){
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $dates = array();
    while ($date1 < $date2) {
        $dates[] = $date1->format('m/d/Y');
        $date1->modify('+1 day');
    }
    return $dates;
}

function get_year_difference($d1, $d2){
    $d1 = new DateTime($d1);
    $d2 = new DateTime($d2);
    $diff = $d2->diff($d1);
    return $diff->y;
}

function calc_dob_details($dob){
    $bday = new DateTime($dob); // Your date of birth
    $today = new Datetime(date('Y-m-d'));
    $diff = $today->diff($bday);
    /*printf(' Your age : %d years, %d month, %d days', $diff->y, $diff->m, $diff->d);
    printf("\n");
    exit;
    if ($array)*/
    return array('years' => $diff->y, 'months' => $diff->m, 'days' => $diff->d);
}

function time_ago($time){
    $time = str_replace('/', '-', $time);
    $timestamp = (is_numeric($time) && (int)$time == $time) ? $time : strtotime($time);
    // $strTime = array("second", "minute", "hour", "day", "month", "year");
    $strTime = array(" sec", " min", " hr", " day", " month", " year");
    $length = array("60", "60", "24", "30", "12", "10");
    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff     = $currentTime - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < countlength($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        if ($strTime[$i] == 'y' || $strTime[$i] == 'y')
            return date('M d, Y h:i a', $timestamp);
        $ago = $diff > 1 ? ' ago' : ' ago';
        $ago = $diff > 1 ? 's ago' : ' ago';
        // return $diff .$strTime[$i];
        if ($diff == 1 && $strTime[$i] == ' day')
            return 'yesterday';
        return $diff . $strTime[$i] . $ago;
    }
}

function short_text($str, $length = 150){
    $str = strip_tags($str);
    return strlen($str) > $length ? substr($str, 0, $length) . '...' : $str;
}

function short_number_format($num){
    $x = round($num);
    $x_number_format = number_format($x);
    $x_array = explode(',', $x_number_format);
    $x_parts = array('k', 'm', 'b', 't');
    $x_count_parts = countlength($x_array) - 1;
    $x_display = $x;
    $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
    $x_display .= $x_parts[$x_count_parts - 1];
    return $x_display;
}

function profile_url($mem_id, $title){
    $CI = get_instance();
    return ($CI->session->mem_id == $mem_id && $CI->session->has_userdata('mem_type')) ? site_url('profile') : site_url('profile/' . doEncode($mem_id) . '/' . toSlugUrl($title));
}

function get_video_link($link){
    $arr = explode('/', $link);
    $cod = $arr[countlength($arr) - 1];
    return substr($cod, (strpos($cod, '?') + 3));
    // return 'https://www.youtube.com/embed/'.substr($cod, (strpos($cod, '?')+3)).'?rel=0&amp;controls=0&amp;showinfo=0';
    // ?modestbranding=1&fs=0&iv_load_policy=3&rel=0
    // ?autoplay=1&loop=1&rel=0&wmode=transparent
}

function get_week_days($key = ''){
    $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    // $days=array('sun'=>'Sunday','mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday');
    if (!empty($key))
        return $days[$key];
    return $days;
}

function get_month_name($month){
    return date("F", mktime(0, 0, 0, $month, 10));
}

function curl_call($url, $parms = '', $post_method = 1, $header = array('Connection: Close')){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, $post_method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($parms))
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parms);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    if (!($res = curl_exec($ch))) {
        error_log("Got " . curl_error($ch) . " when processing curl data");
        curl_close($ch);
        return false;
    }
    /*var_dump($res);
    exit;*/
    curl_close($ch);
    return $res;
}

function dateFormat($originalDate){
        return date( 'M d Y h:i:s A' , strtotime($originalDate));
}

