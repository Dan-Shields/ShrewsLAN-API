<?php

namespace App\Mail;

use Sichikawa\LaravelSendgridDriver\SendGrid;

class InfoEmail extends \Illuminate\Mail\Mailable
{
    use SendGrid;

    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_address = 'info@shrewslan.uk';
        $from_name = 'ShrewsLAN Info';
        $subject = 'Only a few days to go!';
        
        return $this->view('emails.info')
                    ->from($from_address, $from_name)
                    ->replyTo($from_address, $from_name)
                    ->subject($subject);
    }
}
