<?php

namespace App\Jobs;

use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserSendMessageToPropertyOwner extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $owner;
    protected $user;
    protected $text;

    /**
     * Create a new job instance.
     *
     * @param \App\User        $user
     * @param \App\Jobs\string $text
     * @param \App\User        $owner
     */
    public function __construct(User $user,  string $text, User $owner)
    {
        $this->owner = $owner;
        $this->user = $user;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @param \Illuminate\Contracts\Mail\Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $data = [
            'sender'=>$this->user,
            'owner'=>$this->owner,
            'content'=>$this->text
        ];

        Mail::send('emails.test', $data, function ($m) {
            $subject = 'Someone send you a message';
            $name = $this->user->name;

            $m->from($this->user->email, $name);
            $m->to('xavier.au@gmail.com', 'Xavier Au');
            $m->subject($subject);
        });
    }
}
