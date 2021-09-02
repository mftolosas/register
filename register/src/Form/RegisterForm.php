<?php

namespace Drupal\register\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class RegisterForm.
 *
 * @package Drupal\register\Form
 */
class RegisterForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'register_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $conn = Database::getConnection();
        $record = array();
        if (isset($_GET['num'])) {
            $query = $conn->select('register', 'r')
                ->condition('id', $_GET['num'])
                ->fields('r');
            $record = $query->execute()->fetchAssoc();
        }
        $form['candidate_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Full Name'),
            '#required' => TRUE,
            '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
        );
        $form['mobile_number'] = array(
            '#type' => 'textfield',
            '#title' => t('Mobile Number'),
            '#default_value' => (isset($record['mobilenumber']) && $_GET['num']) ? $record['mobilenumber']:'',
        );
        $form['candidate_mail'] = array(
            '#type' => 'email',
            '#title' => t('Email Address'),
            '#required' => TRUE,
            '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email']:'',
        );
        $form['candidate_age'] = array (
            '#type' => 'textfield',
            '#title' => t('Age'),
            '#required' => TRUE,
            '#default_value' => (isset($record['age']) && $_GET['num']) ? $record['age']:'',
        );
        $form['candidate_gender'] = array (
            '#type' => 'select',
            '#title' => ('Gender'),
            '#options' => array(
                'female' => t('Female'),
                'male' => t('Male'),
            ),
            '#default_value' => $record['gender'],
        );
        $form['web_site'] = array (
            '#type' => 'textfield',
            '#title' => t('web site'),
            '#default_value' => (isset($record['website']) && $_GET['num']) ? $record['website']:'',
        );
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'save',
        ];
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        
        global $base_url;
        $field = $form_state->getValues();
        $name = $field['candidate_name'];
        $number = $field['mobile_number'];
        $email = $field['candidate_mail'];
        $age = $field['candidate_age'];
        $gender = $field['candidate_gender'];
        $website = $field['web_site'];

        if (isset($_GET['num'])) {
            $field  = array(
                'name'   => $name,
                'mobilenumber' =>  $number,
                'email' =>  $email,
                'age' => $age,
                'gender' => $gender,
                'website' => $website,
            );
            $query = \Drupal::database();
            $query->update('register')
                ->fields($field)
                ->condition('id', $_GET['num'])
                ->execute();
            drupal_set_message("succesfully updated");
            $form_state->setRedirect('register.display_table_controller_display');
        }
        else
        {
            $field  = array(
                'name'   =>  $name,
                'mobilenumber' =>  $number,
                'email' =>  $email,
                'age' => $age,
                'gender' => $gender,
                'website' => $website,
            );
            $query = \Drupal::database();
            $query ->insert('register')
                ->fields($field)
                ->execute();
            drupal_set_message("succesfully saved");
            $response = new RedirectResponse($base_url.'/register/hello/table');
            $response->send();
        }
    }
}
