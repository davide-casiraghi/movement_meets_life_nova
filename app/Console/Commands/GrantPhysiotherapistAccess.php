<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

/**
 * Gives (or removes) a user access to the physiotherapy panel and its health data.
 */
class GrantPhysiotherapistAccess extends Command
{
    protected $signature = 'gestionale:grant-access {email} {--revoke : Toglie l\'accesso invece di darlo}';

    protected $description = 'Assegna o toglie il ruolo Fisioterapista a un utente (accesso a /gestionale).';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('Nessun utente con questa email.');

            return self::FAILURE;
        }

        if ($this->option('revoke')) {
            $user->removeRole(User::PHYSIOTHERAPIST_ROLE);
            $this->info("Accesso al gestionale tolto a {$user->email}.");

            return self::SUCCESS;
        }

        $user->assignRole(User::PHYSIOTHERAPIST_ROLE);
        $this->info("{$user->email} può ora entrare in /gestionale (al primo accesso dovrà attivare l'autenticazione a due fattori).");

        return self::SUCCESS;
    }
}
