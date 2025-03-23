<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\SendApplicationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendNewApplicationEmailJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $details;
    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $details = [
            'title' =>  $this->details['title'],
            'body' => $this->details['body'],
            'files' => $this->details['files'],
            'email' => $this->details['email'],
          ];
        Mail::to($this->details['email'])->send(new SendApplicationEmail($details));
    }
}