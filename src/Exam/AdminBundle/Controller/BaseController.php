<?php

namespace Exam\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller {
    /**
     * {@inheritDoc}
     */
    public function render($view, array $parameters = array(), Response $response = null) {
        return parent::render($this->getView($view), $parameters, $response);
    }

    /**
     * {@inheritDoc}
     */
    public function renderView($view, array $parameters = array()) {
        return parent::render($this->getView($view), $parameters);
    }

    private function getView($view) {
        $realView = str_replace(array('/', '\\'), BUNDLE_SEPARATOR, $view);
        $realView = explode(BUNDLE_SEPARATOR, $realView);

        array_walk($realView, function(&$piece){
            $piece = strpos($piece, '.') ? $piece : ucfirst($piece);
        });

        $realView = implode(BUNDLE_SEPARATOR, $realView);

        if (strpos($view, $this->getBundleName()) === false) {
            $realView = $this->getBundleName().BUNDLE_SEPARATOR.$realView;
        }

        return $realView;
    }

}