<?php

namespace Drupal\register\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\register\Controller
 */
class DisplayTableController extends ControllerBase {

    public function getContent() {
        // First we'll tell the user what's going on. This content can be found
        // in the twig template file: templates/description.html.twig.
        // @todo: Set up links to create nodes and point to devel module.
        $build = [
            'description' => [
                '#theme' => 'register_description',
                '#description' => 'foo',
                '#attributes' => [],
            ],
        ];
        return $build;
    }

    /**
     * Display.
     *
     * @return string
     *   Return Hello string.
     */
    public function display() {
        //create table header
        $header_table = array(
            'id'=> t('No'),
            'name' => t('Name'),
            'mobilenumber' => t('MobileNumber'),
            'email'=>t('Email'),
            'age' => t('Age'),
            'gender' => t('Gender'),
            'website' => t('Web site'),
            'opt' => t('Operations'),
            'opt1' => t('Operations'),
        );

        //select records from table
        $query = \Drupal::database()->select('register', 'r');
        $query->fields('r', ['id','name','mobilenumber','email','age','gender','website']);
        $results = $query->execute()->fetchAll();
        $rows = array();
        foreach($results as $data){
            $delete = Url::fromUserInput('/register/form/delete/'.$data->id);
            $edit   = Url::fromUserInput('/register/form/register?num='.$data->id);

            //print the data from table
            $rows[] = array(
                'id' =>$data->id,
                'name' => $data->name,
                'mobilenumber' => $data->mobilenumber,
                'email' => $data->email,
                'age' => $data->age,
                'gender' => $data->gender,
                'website' => $data->website,

                \Drupal::l('Delete', $delete),
                \Drupal::l('Edit', $edit),
            );
        }
    
        //display data in site
        $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
        $form['#cache'] = ['max-age' => 0];
        return $form;
    }
}