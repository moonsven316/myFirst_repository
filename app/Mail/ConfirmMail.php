<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class ConfirmMail extends Mailable
{
    use Queueable, SerializesModels;
  
    public $details;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $bccAry = [$this->details['title']];
        return $this->subject($this->details['title'])
                    ->from($address = 'info-support@mogrico.com', $name = 'info-support')      
                    ->bcc($this->details["_charge_mail"])                         
                    ->view('emails.myConfirmMail');
    }
}