<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactEmail extends Mailable {
  use Queueable, SerializesModels;

  /**
   * The contact object instance.
   *
   * @var Contact
   */
  public $email;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($email) {
    $this->email = $email;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build() {
    return $this->from(env('MAIL_USERNAME'))
      ->view('mails.contact')
      ->text('mails.contact_plain')
      /* ->with(
                [
                    'testVarOne' => '1',
                    'testVarTwo' => '2',
                ]
            ) */
      /* ->attach(public_path('/images') . '/contact.jpg', [
                'as' => 'contact.jpg',
                'mime' => 'image/jpeg',
            ]) */;
  }
}
