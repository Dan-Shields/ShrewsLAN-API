<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Signup;

use Exception;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use App\Mail\InfoEmail;

/**
 * Class sendWeekEmailsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class SendInfoEmailsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "email:info {user?} {--all}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send info email designed for a few days before the event";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            if ($this->option('all')) {
                $signups = Signup::all();
           
                if (!$signups) {
                    $this->warn("No signups exist");
                    return;
                }

                foreach ($signups as $signup) {
                    Mail::to($signup['email'])->send(new InfoEmail($signup['name']));
                }

                $this->info("All emails have been sent");
            } else if ($this->argument('user') && is_numeric($this->argument('user'))) {
                $id = $this->argument('user');

                $signup = Signup::find($id);

                if (!$signup) {
                    $this->error('Signup not found');
                    return;
                }

                Mail::to($signup['email'])->send(new InfoEmail($signup['name']));
            } else {
                $this->warn("Please specifiy a valid userid or use the --all option");
            }
        } catch (Exception $e) {
            $this->error("An error occurred");
            $this->error($e);
        }
    }
}
