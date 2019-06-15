<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "libraries/Rest_Client.php";

class Cron extends CI_Controller {
  var $accountant_emails = array('iuiut0203@gmail.com','huynv2909@gmail.com');
  var $manager_emails = array('huynv2909@gmail.com');

   public function voucherFromCRM() {
      $today = date('d-m-Y');

    // mktime(H,i,s,m,d,y)
    // $timestamp = mktime(0,0,0,6,14,2018);
   	// $today = date('d-m-Y', $timestamp);

    // $date_from_file = file_get_contents(FCPATH . 'tmp.txt');
    // $today = date('d-m-Y', strtotime($date_from_file));

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

   			$date = date('Y-m-d');
        // $date = date('Y-m-d', $timestamp);
        // $date = date('Y-m-d', strtotime($today));

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
      echo "its worked in " . $today . " with some error!";
    } else {
      echo "its worked in " . $today . "!";
    }

    if (count($course_missing) > 0) {
      // sent a warning to accountant
      $list_missing = '';
      echo " missing courses: ";
      foreach ($course_missing as $item) {
        echo $item . ", ";
        $list_missing .= $item . ", ";
      }

      $this->missingCourseEmail($list_missing);
    }

    echo "\n";

    // $today = date('d-m-Y', strtotime($date_from_file . "+1 days"));
    // file_put_contents(FCPATH . 'tmp.txt', $today);
   }

   private function initSentMail() {
     //Load email library
     $this->load->library('email');

     $config = array();
     $config['protocol']     = 'smtp';
     $config['smtp_host']    = 'ssl://smtp.googlemail.com'; //neu sử dụng gmail
     $config['smtp_user']    = 'kenshiner96@gmail.com';
     $config['smtp_pass']    = 'nguyenhuyy';
     $config['smtp_port']    = '465'; //nếu sử dụng gmail
     $config['mailtype'] = 'html';

     $this->email->initialize($config);

     $this->email->set_newline("\r\n");

     $this->email->from('kenshiner96@gmail.com', 'Finance Management System');

     $this->email->subject('Lakita - Hệ thống quản trị tài chính thông báo');
   }

   public function missingCourseEmail($list_missing = '') {
     if (count($this->accountant_emails) > 0 && $list_missing != '') {
       $this->initSentMail();
       $data = array(
         'missing_course' => $list_missing
       );
       $this->email->to($this->accountant_emails);
       $this->email->message($this->load->view('email/warning-course-missing-min', $data, true));

       $this->email->send();
     }

   }

   public function approveNotify() {
     $this->load->model('Voucher_model');

     $amount = $this->Voucher_model->get_total(array('where' => array('approved' => 0, 'deleted' => 0) ));

     if (count($this->accountant_emails) > 0 && $amount > 0) {
       $this->initSentMail();
       $data = array(
         'amount' => $amount
       );
       $this->email->to($this->accountant_emails);
       $this->email->message($this->load->view('email/approve-notify-min', $data, true));

       $this->email->send();
       echo date('d-m-Y H:i:s') . ", sent approve notify." . "\n";

     }
   }

   public function autoReportManager() {
     if (count($this->manager_emails) > 0) {
       $this->initSentMail();
       $this->email->to($this->manager_emails);
       $this->email->message($this->totalReportContent());

       $this->email->send();
       echo date('d-m-Y H:i:s') . ", sent report to manager." . "\n";

     }

   }

   public function totalReportContent() {
     $data = array();
     $data['min_date'] = date('Y-m-01');
     $data['max_date'] = date('Y-m-d');

     $this->load->model('Distribution_model');

    // cost
    $input = array(
      'select' => array('SUM(value) AS cost'),
      'where' => array(
        'deleted' => 0,
        'TOA >=' => $data['min_date'],
        'TOA <=' => $data['max_date']
      ),
      'where_in' => array('dimensional_id', array(310,320,330,340,250,350) )
    );

    $cost = $this->Distribution_model->get_list($input)[0]->cost;
    $data['cost'] = $cost;

    // revenue
    $input = array(
      'select' => array('SUM(value) AS revenue'),
      'where' => array(
        'dimensional_id' => 210,
        'deleted' => 0,
        'TOA >=' => $data['min_date'],
        'TOA <=' => $data['max_date']
      )
    );

    $revenue = $this->Distribution_model->get_list($input)[0]->revenue;

    $data['revenue'] = $revenue;

    // New records;
    $input = array(
      'select' => array('id', 'approved', 'deleted'),
      'where' => array(
        'date >=' => $data['min_date'] . ' 00:00:00',
        'date <=' => $data['max_date'] . ' 23:59:59'
      )
    );
    $this->load->model('Voucher_model');
    $new_records = $this->Voucher_model->get_list($input);
    $data['new_records'] = count($new_records);

     return $this->load->view('email/general-report-sent', $data, true);
   }

}
