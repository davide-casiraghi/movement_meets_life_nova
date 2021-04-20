<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMeAutoResponse extends Mailable
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
                    ->subject('Thank you for your contact request')
                    ->markdown('mail.contactMeAutoResponse', ['data' => $this->data]);
    }
}
