<?php

namespace Drupal\register\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class RegisterController.
 *
 * @package Drupal\register\Controller
 */
class RegisterController extends ControllerBase {

    /**
     * Display.
     *
     * @return string
     *   Return Hello string.
     */
    public function display() {
        return [
            '#type' => 'markup',
            '#markup' => $this->t('This page contain all inforamtion about registers ')
        ];
    }

}