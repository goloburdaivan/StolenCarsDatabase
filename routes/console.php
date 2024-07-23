<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:parse-marks-with-models')->monthly();
