<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Mail;
use App\Mail\Api\SendRecoveryEmail;
use App\Mail\Api\SendVerifyEmail;

class MailService
{
	static public function sendRecoveryEmail($email, $data)
	{
		$message = (new SendRecoveryEmail($data))->onQueue('emails');
        Mail::to($email)->queue($message);
	}

	static public function sendVerifyEmail($email, $data)
	{
		$message = (new SendVerifyEmail($data))->onQueue('emails');
        Mail::to($email)->queue($message);
    }
}
