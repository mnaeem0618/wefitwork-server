<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

# ADMIN

$route['admin/login']                   = 'admin/index/login';
$route['admin/logout']                  = 'admin/index/logout';
$route['admin/meta-info']               = 'admin/Meta_info/index';
$route['admin/meta-info/manage']        = 'admin/Meta_info/manage';
$route['admin/meta-info/manage/(:any)'] = 'admin/Meta_info/manage/$1';
$route['admin/meta-info/delete/(:any)'] = 'admin/Meta_info/delete/$1';

# API ROUTES

$route['api/site-settings']             = 'api/pages/site_settings';
$route['api/home']                      = 'api/pages/home';
$route['api/about']                     = 'api/pages/about';
$route['api/become-pro']                = 'api/pages/become_pro';
$route['api/contact-us']                = 'api/pages/contact_us';
$route['api/reset-request-page']        = 'api/pages/forgot_password_content';
$route['api/login-page']                = 'api/pages/login';
$route['api/signup-page']               = 'api/pages/signup';
$route['api/terms-and-conditions']      = 'api/pages/terms_and_conditions';
$route['api/privacy-policy']            = 'api/pages/privacy_policy';
$route['api/help']                      = 'api/pages/help';
$route['api/help-detail/(:any)']        = 'api/pages/help_detail/$1';
$route['api/professional-signup-page']  = 'api/pages/professional_signup_page';
$route['api/reset-password-page']       = 'api/pages/reset_password_content';
$route['api/email-verify-page']         = 'api/pages/email_verify_content';
$route['api/blogs']         = 'api/pages/blogs';
$route['api/blog-detail/(:any)']         = 'api/pages/blog_detail/$1';
$route['api/blogsByCat'] = 'api/pages/blogsByCat';



$route['api/save-contact-message']      = 'api/pages/save_contact_message';
$route['api/save-newsletter']           = 'api/pages/save_newsletter';
$route['api/get-sub-services']          = 'api/pages/get_sub_services';
$route['api/save-search']               = 'api/pages/save_search';
$route['api/search-profession']         = 'api/pages/search_profession';
$route['api/search-detail/(:any)']         = 'api/pages/search_detail/$1';
$route['api/search-services']         = 'api/pages/search_services';
$route['api/work-scope/(:any)']         = 'api/pages/work_scope/$1';
$route['api/search-profession-page-for-review']         = 'api/pages/search_profession_page_for_review';

$route['api/upload-file']      = 'api/pages/upload_file';
$route['api/maintenance-covers']      = 'api/pages/maintenance_covers';
$route['api/maintenance-cover-detail/(:any)']         = 'api/pages/maintenance_cover_detail/$1';
$route['api/checkout-page/(:any)']         = 'api/pages/checkout_page/$1';


$route['api/get-mc-sub-services']          = 'api/pages/get_mc_sub_services';












//AUTH ROUTES

$route['api/auth/create-account']       = 'api/auth/sign_up';
$route['api/auth/verify-email']         = 'api/auth/verify_email';
$route['api/auth/signin']               = 'api/auth/sign_in';
$route['api/auth/forgot-password']      = 'api/auth/forgot_password';
$route['api/auth/reset-password']       = 'api/auth/reset_password';
$route['api/auth/create-new-password']  = 'api/auth/create_new_password';
$route['api/auth/resend-email']  = 'api/auth/resend_email';

//Buyer DASHBOARD

$route['api/user/buyer-dashboard']            = 'api/user/buyer_dashboard';
$route['api/user/buyer-profile-settings']     = 'api/user/buyer_profile_settings';
$route['api/user/save-buyer-profile-settings']= 'api/user/save_buyer_profile_settings';
$route['api/user/change-password']      = 'api/user/change_password';
$route['api/user/booking-details/(:any)']      = 'api/user/booking_details/$1';
$route['api/user/review-page-data/(:any)']      = 'api/user/review_page_data/$1';
$route['api/user/save-review']      = 'api/user/save_review';
$route['api/user/update-booking-statuses/(:any)']      = 'api/user/update_booking_statuses/$1';
$route['api/user/add-remove-to-wishlist']      = 'api/user/add_remove_to_wishlist';
$route['api/user/buyer-wishlist']      = 'api/user/buyer_wishlist';
$route['api/user/start-chat']      = 'api/user/start_chat';
$route['api/user/fetch-conversation-data']      = 'api/user/fetch_conversation_data';
$route['api/user/buyer-bookings']      = 'api/user/buyer_bookings';
$route['api/user/buyer-notifications']         = 'api/user/buyer_notifications';
$route['api/user/save-maintenance-cover-payment']         = 'api/user/save_maintenance_cover_payment';
$route['api/user/buyer-maintenance-requests']         = 'api/user/buyer_maintenance_requests';
$route['api/user/add-request-page']         = 'api/user/add_request_page';

$route['api/user/add-maintenance-cover-request']         = 'api/user/add_maintenance_cover_request';
$route['api/user/buyer-maintenance-request-detail']         = 'api/user/buyer_maintenance_request_detail';
$route['api/user/delete-maintenance-cover-request']         = 'api/user/delete_maintenance_cover_request';

















//Professional Dashboard
$route['api/user/professional-dashboard']            = 'api/user/professional_dashboard';
$route['api/user/create-professional-profile']            = 'api/user/create_professional_profile';
$route['api/user/professional-profile-settings']            = 'api/user/professional_profile_settings';
$route['api/user/save-professional-profile-settings']            = 'api/user/save_professional_profile_settings';
$route['api/user/delete-portfolio-image']            = 'api/user/delete_portfolio_image';
$route['api/user/get-mem-services-data']            = 'api/user/get_mem_services_data';
$route['api/user/update-sub-services']      = 'api/user/update_sub_services';
$route['api/user/save-business-data']      = 'api/user/save_business_data';
$route['api/user/request-verify-phone']      = 'api/user/request_verify_phone';
$route['api/user/verify-phone']      = 'api/user/verify_phone';
$route['api/user/send-message']         = 'api/user/send_message';
$route['api/user/get-pro-mem-subscriptions']         = 'api/user/get_pro_mem_subscriptions';
$route['api/user/professional-notifications']         = 'api/user/professional_notifications';



// PAYSTACK ROUTES
$route['api/paystack/create-customer']         = 'api/paystack/create_customer';
$route['api/paystack/fetch-customer']         = 'api/paystack/fetch_customer';

$route['api/webhooks/paystack_events']         = 'api/webhooks/paystack_events';




//datatable routes

$route['admin/members/fetch'] = 'admin/members/fetch_members'; 
$route['admin/jobs/fetch']    = 'admin/jobs/fetch_jobs'; 
$route['admin/jobs_stats']    = 'admin/jobs/stats'; 
$route['admin/requests']    = 'admin/withdraws/requests'; 
$route['ajax/upload_editor_attach']    = 'admin/ajax/upload_editor_attach'; 

