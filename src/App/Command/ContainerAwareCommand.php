<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;

class ContainerAwareCommand extends Command
{
    const EXIT_CODE_ERROR = 1;
    const EXIT_CODE_SUCCESS = 0;

    public function getContainer()
    {
        return $this->getApplication()->getContainer();
    }
}
