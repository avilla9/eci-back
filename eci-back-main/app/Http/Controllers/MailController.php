<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {
  /**
   * The contact object instance.
   *
   * @var Contact
   */
  public $data;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data) {
    $this->data = $data;
    $this->send($data);
  }

  public function send($data) {
    $email = new \stdClass();

    $email->dni = $this->data['dni'];
    $email->name = $this->data['name'];
    $email->email = $this->data['email'];
    $email->agent_code = $this->data['agent_code'];
    $email->type = $this->data['type'];
    $email->message = $this->data['message'];

    Mail::to(env('MAIL_USERNAME'))
      ->cc($email->email)
      ->send(new ContactEmail($email));
  }
}
