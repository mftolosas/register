<?php

namespace Drupal\register\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * Provides a 'RegisterBlock' block.
 *
 * @Block(
 *  id = "register_block",
 *  admin_label = @Translation("Register block"),
 * )
 */
class RegisterBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {

        $form = \Drupal::formBuilder()->getForm('Drupal\register\Form\RegisterForm');
        return $form;
    }
}