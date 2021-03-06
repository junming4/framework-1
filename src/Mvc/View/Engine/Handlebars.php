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

namespace Shadon\Mvc\View\Engine;

use Handlebars\Loader\FilesystemLoader;
use Phalcon\DiInterface;
use Phalcon\Mvc\View\Engine;
use Phalcon\Mvc\View\EngineInterface;
use Phalcon\Mvc\ViewBaseInterface;
use Shadon\Mvc\View;

/**
 * Phalcon\Mvc\View\Engine\Handlebars
 * Adapter to use Handlebars library as templating engine.
 */
class Handlebars extends Engine implements EngineInterface
{
    /**
     * @var \Handlebars_Engine
     */
    protected $handlebars;

    /**
     * {@inheritdoc}
     *
     * @param ViewBaseInterface $view
     * @param DiInterface       $di
     */
    public function __construct(View $view, DiInterface $di = null)
    {
        $this->handlebars = new \Handlebars\Handlebars([
            'loader'          => new FilesystemLoader('', ['extension' => 'hbs']),
            'partials_loader' => new FilesystemLoader($view->getViewsDir().'/', ['extension' => 'hbs']),
        ]);

        $this->handlebars->addHelper('startInexd', new View\Engine\Handlebars\Helper\StartInexdHelper());
        $this->handlebars->addHelper('isEven', new View\Engine\Handlebars\Helper\IsEvenHelper());
        $this->handlebars->addHelper('compare', new View\Engine\Handlebars\Helper\CompareHelper());
        $this->handlebars->addHelper('formatTime', new View\Engine\Handlebars\Helper\FormatTimeHelper());
        $this->handlebars->addHelper('sortFun', new View\Engine\Handlebars\Helper\SortFunHelper());

        parent::__construct($view, $di);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $path
     * @param array  $params
     * @param bool   $mustClean
     */
    public function render($path, $params, $mustClean = false): void
    {
        if (!isset($params['content'])) {
            $params['content'] = $this->_view->getContent();
        }
        $content = $this->handlebars->render($path, $params);

        if ($mustClean) {
            $this->_view->setContent($content);
        } else {
            echo $content;
        }
    }
}
