<?php

declare(strict_types=1);

/*
 * This file is part of eelly package.
 *
 * (c) eelly.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eelly\Doc\Adapter;

use Eelly\Di\Injectable;

/**
 * Class HomeDocumentShow.
 */
class HomeDocumentShow extends Injectable implements DocumentShowInterface
{
    public function display(): void
    {
        // TODO create view
        echo 'home doc';
    }
}
