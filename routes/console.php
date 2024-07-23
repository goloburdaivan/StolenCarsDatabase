<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:fetch-auto-data')->monthly();
