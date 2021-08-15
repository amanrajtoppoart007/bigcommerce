<?php
namespace App\Traits;

use App\Mail\SendOrderNotAssignedMailToAdmin;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

trait MailSenderTrait{

    public function sendOrderNotAssignedMailToAdmins($order)
    {
        $emails = Admin::whereApproved(true)->whereVerified(true)->pluck('email');
        if(empty($emails)) return true;
        return Mail::to($emails)->send(new SendOrderNotAssignedMailToAdmin($order));
    }
}
