<?php

namespace App\Contracts\Jobs;

interface JobContract
{
    public function setUp();

    public function perform($args);

    public function tearDown();
}
