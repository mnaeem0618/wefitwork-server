<?php
class Webhooks extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->library('my_paystack_lib');
        $this->load->model('member_model');
    }

    public function paystack_events()
    {
        // Replace 'your_paystack_secret_key' with your actual Paystack secret key
        $paystackSecretKey = 'sk_test_95663f53a5793a65c283396ed0f6ceb69b0a63a6';
        
        // Get the Paystack event payload
        $payload = file_get_contents('php://input');
        writ_post_data('response', $payload);
        // Get the Paystack signature from the headers
        $signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'];
        // writ_post_data('signature', $signature);
        // Verify the webhook signature
        if (hash_hmac('sha512', $payload, $paystackSecretKey) === $signature) {
            // Webhook signature is valid
            $event = json_decode($payload);

            $data = $event->data;

            $customer = $data->customer;
            



            // Process the event based on the event type
            $eventType = $event->event;
            
            $memData = $this->member_model->getMemByCustomerCode($customer->customer_code);

            // Handle the event based on your application's logic
            switch ($eventType) {
                
                case 'subscription.create':
                    $plan = $data->plan;
                    $start_date = $data->createdAt;
                    $next_payment_date = $data->next_payment_date;

                    $charged_amount = $data->amount / 100;

                    $save_sub = array(
                        'mem_id' => $memData->mem_id,
                        'paystack_plan_code' => $plan->plan_code,
                        'paystack_plan_name' => $plan->name,
                        'paystack_subscription_code' => $data->subscription_code,
                        'paystack_customer_code' => $customer->customer_code,
                        'plan_interval' => $plan->interval,
                        'amount' => $charged_amount,
                        'start_date' => format_date($start_date, 'Y-m-d h:i:s'),
                        'end_date' => format_date($next_payment_date, 'Y-m-d h:i:s'),
                        'subscription_status' => $data->status,
                        'status' => 1,
                        'created_date' => date('Y-m-d h:i:s'),
                    );

                    $sub_id = $this->master->save('mem_subscriptions', $save_sub);
                    writ_post_data('save_data', $save_sub);
                    writ_post_data('last_query', $this->db->last_query());


                    // Handle subscription creation event
                    break;
                case 'subscription.not_renew':
                    // Handle subscription not_renew event
                    writ_post_data('not_renew', $payload);
                    $this->master->update('mem_subscriptions', ['subscription_status' => $data->status], array('paystack_subscription_code' => $data->subscription_code, 'mem_id' => $memData->mem_id));
                    break;

                case 'subscription.disable':
                    // Handle subscription disable event
                    $this->master->update('mem_subscriptions', ['subscription_status' => $data->status], array('paystack_subscription_code' => $data->subscription_code, 'mem_id' => $memData->mem_id));

                    break;

                case 'subscription.expiring_cards':
                    // Handle subscription disable event
                    $this->master->update('mem_subscriptions', ['subscription_status' => $data->status], array('paystack_subscription_code' => $data->subscription_code, 'mem_id' => $memData->mem_id));

                    break;

                case 'invoice.create':
                        // Handle subscription disable event
                    $this->master->update('mem_subscriptions', ['subscription_status' => $data->subscription->status, 'paystack_trx_ref' => $data->transaction->reference], array('paystack_subscription_code' => $data->subscription->subscription_code, 'mem_id' => $memData->mem_id));
                    $this->member->update(['paystack_transaction_ref' => $data->transaction->reference], array('mem_id' => $memData->mem_id));
    
                break;    
                    // Add more cases for other subscription-related events as needed
                default:
                    // Handle other events
                    break;
            }

            http_response_code(200);
            echo 'Webhook received successfully.';
        } else {

            // Invalid signature
            http_response_code(400);
            echo 'Invalid signature.';
        }
    }
}
