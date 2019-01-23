<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Rest_Client.php";

class Cron extends CI_Controller {
   public function voucherFromCRM() {
      $today = date('d-m-Y');
   	// $today = date('d-m-Y', mktime(0,0,0,12,24,2018));

   	$config = array(
   	    'server' => 'https://crm.lakita.vn/',
   	    'api_key' => 'RrF3rcmYdWQbviO5tuki3fdgfgr4',
   	    'api_name' => 'lakita-key',
   	);

   	$restClient = new Rest_Client($config);
   	$uri = "finance_api/vouchers/" . $today;
   	$result = $restClient->get($uri);
   	$rs = json_decode($result);

   	$index = 0;
   	if (is_array($rs)) {
         $this->load->model('Crm_model');
         $this->load->model('Voucher_model');

   		foreach ($rs as $contact) {
   			$index++;

		      $contact_info = array(
               'id_contact'         => $contact->id,
               'name'               => $contact->name,
               'course_code'        => $contact->course_code,
               'price_purchase'     => $contact->price_purchase,
               'payment_method_id'  => $contact->payment_method_rgt,
               'provider_id'        => $contact->provider_id,
               'method'             => $contact->method,
               'provider'           => $contact->provider_id,
               'note'               => $contact->note,
            );

   		    $this->Crm_model->create($contact_info);

   		    $code = '';
   		    $type_id = 0;
   		    $method = 0;
   		    if ($contact->payment_method_rgt == 1) {
   				$code = 'PTCOD' . time() . $index;
   				$type_id = 1;
   				$method = 1;
   			} elseif ($contact->payment_method_rgt == 2) {
   				$code = 'PTCK' . time() . $index;
   				$type_id = 5;
   				$method = 2;
   			} else {
   				$code = 'PTK' . time() . $index;
   				$type_id = 23;
   			}

   			$content = '[AUTO-FROM-CRM]-' . $contact->id . '-' . $contact->name . '-' . $contact->course_code . '-' . $contact->phone;

   			$provider = 1;
   			switch ($contact->provider_id) {
   			    case "1":
   			        $provider = 4;
   			        break;
   			    case "2":
   			        $provider = 11;
   			        break;
   			    case "3":
   			        $provider = 12;
   			        break;
   			    case "4":
   			        $provider = 13;
   			        break;
   			    case "5":
   			        $provider = 6;
   			        break;
   			    case "6":
   			        $provider = 14;
   			        break;
   			    case "7":
   			        $provider = 15;
   			        break;
   			    case "8":
   			        $provider = 5;
   			        break;
   			    default:
   			        $provider = 1;
   			}

   			$date = date('Y-m-d');

            $voucher_info = array(
               'code'      => $code,
               'type_id'   => $type_id,
               'content'   => $content,
               'income'    => 1,
               'TOT'       => $date,
               'TOA'       => $date,
               'executor'  => 0,
               'value'     => $contact->price_purchase,
               'owner'     => 0,
               'method'    => $method,
               'provider'  => $provider,
               'is_new'    => 1,
               'approved'  => 0
            );

   			$this->Voucher_model->create($voucher_info);

   		}



   	}

       echo 'its worked in ' . $today . '!|';
   }
}
