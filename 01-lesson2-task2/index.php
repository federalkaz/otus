<?php

namespace otus\lesson02;

use otus\lesson02\CheckBrackets as CheckBrackets;

$checkBrackets = new CheckBrackets();
echo var_dump($checkBrackets->verify('(())'));
