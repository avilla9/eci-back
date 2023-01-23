<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
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

    $email->id = $this->data['id'];
    $email->name = $this->data['name'];
    $email->email = $this->data['email'];

    Mail::to($email->email)
      ->send(new ResetPasswordMail($email));
  }
}
