<?php

use models\EmailSender;

class ContactController extends Controller
{
    public function process(array $params): void
    {
        $this->head = [
            'title' => 'Contact form',
            'description' => 'Contact us using our email form.'
        ];

        if (isset($_POST["email"]))
        {
            if ($_POST['abc'] == date("Y"))
            {
                $emailSender = new EmailSender();
                $emailSender->send(
                    "admin@address.com",
                    "Email from your website",
                    $_POST['message'],
                    $_POST['email']
                );
            }
        }
        $this->view = 'contact';
    }
}