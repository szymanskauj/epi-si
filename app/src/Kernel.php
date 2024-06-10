<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * The kernel class of the application.
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
