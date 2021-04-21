<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GetATreatmentAutoResponse extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected array $data;

    /**
     * Create a new message instance.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return ContactMeAutoResponse
     */
    public function build()
    {
        return $this
                    ->from(env('ADMIN_MAIL'))
                    ->subject('Thank you for your bodywork request')
                    ->markdown('mail.getATreatmentAutoResponse', ['data' => $this->data]);

//        return (new MailMessage())
//          ->subject('Thank you for your bodywork request')
//          ->markdown('emails.getATreatmentAutoResponse', ['data' => $this->data]);
    }
}
