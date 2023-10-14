<?php

namespace NormanHuth\ConsoleApp\Console\Commands;

use Illuminate\Console\Command as ConsoleCommand;

class Command extends ConsoleCommand
{
    public function __construct()
    {
        set_time_limit(0);
        parent::__construct();
    }
}
