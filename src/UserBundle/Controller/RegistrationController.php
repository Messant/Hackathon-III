<?php

// src/UserBundle/Controller/RegistrationController.php
namespace UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        $response = parent::registerAction();

        // ... do custom stuff
        return $response;
    }
}
