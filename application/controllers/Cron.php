<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Rest_Client.php";

class Cron extends CI_Controller {
   public function voucherFromCRM() {
      // $today = date('d-m-Y');

    // $timestamp = mktime(0,0,0,1,2,2019);
   	// $today = date('d-m-Y', $timestamp);

    $date_from_file = file_get_contents(FCPATH . 'tmp.txt');
    $today = date('d-m-Y', strtotime($date_from_file));

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
    $error = false;
    $courses_arr = array();
    $course_missing = array();
   	if (is_array($rs)) {
         $this->load->model('Crm_model');
         $this->load->model('Voucher_model');
         $this->load->model('DetailDimension_model');

         // get list courses
         $input = array(
           'select' => 'name',
           'where' => array(
             'dimen_code' => 'SP'
           )
         );

         $rs_query = $this->DetailDimension_model->get_list($input);
         foreach ($rs_query as $rs_obj) {
           $courses_arr[] = $rs_obj->name;
         }

      // loop $rs;
   		foreach ($rs as $contact) {
   			$index++;

        // check if the system have a new course
        if (!in_array($contact->course_code, $courses_arr)) {
          if (!in_array($contact->course_code, $course_missing)) {
            $course_missing[] = $contact->course_code;
          }
        }

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

   			$content = '[AUTO~FROM~CRM]~' . $contact->id . '~' . $contact->name . '~' . $contact->course_code . '~' . $contact->phone;

   			$provider = 0;
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
   			        $provider = 0;
   			}

   			// $date = date('Y-m-d');
        // $date = date('Y-m-d', $timestamp);
        $date = date('Y-m-d', strtotime($today));

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
           'approved'  => 0
        );

   			if (!$this->Voucher_model->create($voucher_info)) {
          $error = true;
        }
   		}

   	}

    if ($error) {
      echo 'its worked in ' . $today . ' with some error!';
    } else {
      echo 'its worked in ' . $today . '!';
    }

    if (count($course_missing) > 0) {
      // sent a warning to accountant
      echo ' missing courses: ';
      foreach ($course_missing as $item) {
        echo $item . ', ';
      }
    }

    echo '|';

    $today = date('d-m-Y', strtotime($date_from_file . "+1 days"));
    file_put_contents(FCPATH . 'tmp.txt', $today);
   }

   public function autoApprove() {
     $this->load->model('Voucher_model');
     $filter = array(
       'where' => array('approved' => 0, 'income' => 1, 'deleted' => 0)
     );

     $vc_news = $this->Voucher_model->get_list($filter);

     if (count($vc_news) > 0) {
       $this->load->model('Crm_model');
       foreach ($vc_news as $vc) {
         $parts = explode('-', $vc->content);

         if (count($parts) > 5) {
           $id_contact = $parts[3];
           $vc->{"course_code"} = $parts[5];

           $input = array(
             'where' => array('id_contact' => $id_contact)
           );

           $contact_info = $this->Crm_model->get_list($input);
           if (count($contact_info) > 0) {
             $vc->{"crm_note"} = $contact_info[0]->note;
           } else {
             $vc->{"crm_note"} = '';
           }
         } else {
           $vc->{"course_code"} = '';
           $vc->{"crm_note"} = '';
         }


       }
       pre($vc_news);
     }
   }

}
