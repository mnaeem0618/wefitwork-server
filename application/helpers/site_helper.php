<?php

$CI = & get_instance();
function get_header()
{
    $CI = get_instance();
    if($CI->session->has_userdata('mem_id') && $CI->session->has_userdata('mem_type'))
        $CI->load->view('includes/header-logged');
    else
        $CI->load->view('includes/header');
}

function get_pages()
{
    return [
        '/'             => 'Home',
        '/about'             => 'About',
        '/become-professional' => 'Become Professional',
        '/contact'   => 'Contact Us',
        '/resources'    => 'Recources',
        '/faq'          => 'FAQ\'s',
        '/login'       => 'Sign In',
        '/signup'        => 'Sign Up',
        '/trade-person-signup' => 'Professional Signup',
        '/privacy-policy'=> 'Privacy Policy',
        '/terms-conditions' => 'Terms And Conditions',
        'search-result' => 'Search Result',
        '/help' => 'Help'
    ];
}

function get_pages_referralable()
{
    return [
        [ 
            'key'    => 'home',
             'value' => 'Home'
        ],
        [ 
            'key'    => 'subscription',
            'value' => 'Subscription'
        ],
        [ 
            'key'    => 'about-us',
             'value' => 'About Us'
        ],
        [ 
            'key'    => 'contact-us',
             'value' => 'Contact Us'
        ],
        [
             'key' => 'resources',
             'value' => 'Resources'
        ],
        [
            'key' => 'faq',
            'value' => 'FAQ\'s'
        ],
        [
             'key' => 'signup',
             'value' => 'Sign Up'
        ],
        [ 
            'key' => 'privacy-policy',
            'value' => 'Privacy Policy'
        ],
        [ 
            'key' => 'terms-conditions',
            'value' => 'Terms And Conditions'
        ]
    ];
}





function get_sub_service_title($id){
    $CI = get_instance();
    $service = $CI->master->getRow('sub_services',array('id'=>$id));
    return $service->title;
}
function get_service_name($id){
    $CI = get_instance();
    $service = $CI->master->getRow('services',array('id'=>$id));
    return $service->name;
}
function get_services(){
    $CI = get_instance();
    return $CI->master->getRows('services',array('status'=>1));
}
function get_partners(){
    $CI = get_instance();
    return $CI->master->getRows('partners',array('status'=>1));
}

function get_papular_products($limit)
{
    $CI = get_instance();
    $CI->db->select("p.*, (SELECT GROUP_CONCAT(DISTINCT size SEPARATOR ' ') FROM `tbl_product_sizes` WHERE p_id = p.id) as sizes", FALSE);
    $CI->db->where('status', 1);
    $CI->db->limit($limit);
    $CI->db->order_by('id', 'desc');
    return $CI->db->get('products p')->result();
}

function get_main_cats ($type = 'product')
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT * FROM `tbl_categories` WHERE type = '$type' AND parent_id = 0 AND status = 1");
}

function get_sub_cats ($type = 'product')
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT * FROM `tbl_categories` WHERE type = '$type' AND parent_id<>0 AND status = 1");
}

function get_group_colors ()
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT color, color_name FROM `tbl_product_colors` GROUP BY color_name");
}

function get_group_sizes ()
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT size FROM `tbl_product_sizes` GROUP BY size");
}

function get_max_price()
{
    $CI = get_instance();
    $CI->db->select_max('default_price');
    $query = $CI->db->get('products');
    return floatval($query->row()->default_price);
}



function get_cat_help($cat_id)
{
    $CI = get_instance();
    $CI->db->where('cat_id', $cat_id);
    $query = $CI->db->get('help');
    return $query->result();
}

function is_mem_service($mem_id, $service_id)
{
    $CI = get_instance();
    $CI->db->where('mem_id', $mem_id);
    $CI->db->where('service_id', $service_id);
    $query = $CI->db->get('mem_services');
    return $query->row();
}

function get_yes_no($status)
{
    return $status ==1 ? 'Yes' : 'No';
}

function get_booking_status($status)
{
    if ($status == 0)
        return '<span class="miniLbl gray">Pending</span>';
    elseif ($status == 1)
        return '<span class="miniLbl yellow">Accepted</span>';
    else if ($status == 2)
        return '<span class="miniLbl green">Booked</span>';
    else
        return '<span class="miniLbl red">Declined</span>';
}


function get_completed_status($status)
{
    if ($status == 1)
        return '<span class="miniLbl yellow">Pending</span>';
    else if ($status == 2)
        return '<span class="miniLbl green">Completed</span>';
    
}


//***** PERMISSIONS*******///
function has_access($permission_id = 0)
{
    $CI = get_instance();
    if(is_admin())
        return true;
    if(!in_array($permission_id, $CI->session->permissions)){
    // if($permission_id>0 && !is_admin() && !in_array($permission_id,$CI->session->userdata('permissions'))){
        show_404();
        exit;
    }
    return $CI->session->loged_in['id'];
}

function access($permission_id)
{
    $CI = get_instance();
    if(is_admin()) return true;
    return in_array($permission_id, $CI->session->permissions);
}

function is_admin()
{
    $CI = get_instance();
    return $CI->session->loged_in['admin_type']=='admin' ? true : false;
}

function has_permissions($permission_id, $id = 0)
{
    $CI = get_instance();
    if($id<1)
        $id=$CI->session->loged_in['id'];
    return $CI->master->getRow('permissions_admin', array('permission_id' => $permission_id, 'admin_id' => $id));
}

function get_size_weight($size)
{
    $weights = array('small' => '0-15lbs', 'medium' => '16-40lbs', 'large' => '41-100lbs', 'giant' => '101+lbs');
    return $weights[$size];
}
//***** end PERMISSIONS*******///

function get_location_detail($zipcode, $country='gb')
{
    $url = 'https://geocoder.api.here.com/6.2/geocode.json?app_id=IAcDhEZWhrGYOn6m3JnI&app_code=52n2G76qxgU7qRyswkqYaw%20&searchtext='.urlencode($zipcode).',%20'.$country;
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    if (curl_error($ch)) {
        echo $error_msg = curl_error($ch);
    }
    curl_close($ch);
    $response = json_decode($data);
    return $response->Response->View[0]->Result[0]->Location->DisplayPosition;
    /*echo $response->Response->View[0]->Result[0]->Location->DisplayPosition->Latitude.'<br>';
    echo $response->Response->View[0]->Result[0]->Location->DisplayPosition->Longitude*/;
}
?>
