<?php

namespace App\Controller;

use App\Models\User;

class AuthController extends BaseController {


    public function login(){
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userModel = new User($this->db);

            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($userModel->login($email, $password)) {
                
                $_SESSION['user_id'] = $userModel->getId();
                $_SESSION['user_name'] = $userModel->getName();
                $_SESSION['user_email'] = $userModel->getEmail();

                header('Location: /dashboard');
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        }

        return $this->render('auth/login.twig', [
            'error' => $error
        ]);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User($this->db);

            if ($userModel->register($_POST)) {
                header('Location: /login');
                exit();
            }
        }

        return $this->render('auth/register.twig');
    }
}