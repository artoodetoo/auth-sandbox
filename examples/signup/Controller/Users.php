<?php

namespace Examples\Signup\Controller;

use Examples\Signup\Base;
use Examples\Signup\Model\User as UserModel;
use Examples\Signup\Model\Auth as AuthModel;

class Users extends Base
{

    public function index()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('users/profile');
        } else {
            $this->redirect('users/login');
        }
    }

    public function login()
    {
        $data = [];

        // login form submitted?
        if (count($_POST)) {
            // load user and authentication models
            $user = new UserModel();

            // get the user data from database
            $user_data = $user->findByEmailAndPassword($_POST['email'], $_POST['password']);

            // user found?
            if ($user_data) {
                $_SESSION['user'] = $user_data['id'];

                $this->redirect('users/profile');
            }

            $data['error_message'] = '<b style="color:red">Bad Email or password! Try again.</b>';
        }
        $data['providers'] = [];
        foreach (self::$config['auth']['providers'] as $name => $value) {
            if ($value['enabled']) {
                $data['providers'][] = $name;
            }
        }

        // load login view
        $this->render('users/login', $data);
    }

    public function logout()
    {
        // every thing is within php sessions, just destory it
        $_SESSION = [];
        session_destroy();

        // go back home
        $this->redirect('users/login');
    }

    public function register()
    {
        $data = [];

        // load user model
        $user = new UserModel();

        // registration form submitted?
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $data = $this->collectPostForm(['email', 'password', 'first_name', 'last_name', 'provider', 'auth']);

            if (empty($data['email']) || empty($data['password'])) {
                $data['error_message'] = '<br /><b style="color:red">Your email and a password are required!</b>';
            } else {
                // check if email is in use?
                $user_info = $user->findByEmail($data['email']);

                // if email used on users table, we display an error
                if ($user_info) {
                    $data['error_message'] = '<br /><b style="color:red">Email alredy in use with another account!</b>';
                } else {
                    // create new user
                    $new_user_id = $user->create(
                        $data['email'],
                        $data['password'],
                        $data['first_name'],
                        $data['last_name']
                    );

                    // set user connected
                    $_SESSION['user'] = $new_user_id;

                    $this->redirect('users/profile');
                }
            }
        }

        $this->render('users/register', $data);
    }

    public function completeRegistration()
    {
        $data = [];

        // load user model
        $user = new UserModel();

        // complete registration form submitted?
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $email      = $_POST['email'];
            $password   = $_POST['password'];
            $first_name = $_POST['first_name'];
            $last_name  = $_POST['last_name'];

            if (!$email || !$password) {
                $data['error_message'] =
                    '<br /><b style="color:red">Your email and a password are really important for us!</b>';
            } else {
                // check if email is in use?
                $user_info = $user->findByEmail($email);

                // if email used on users table, we display an error
                if ($user_info && $user_info['id'] != $_SESSION['user']) {
                    $data['error_message'] =
                        '<br /><b style="color:red">Email already in use with another account!</b>';
                } else {
                    // update user profile
                    $user->update($_SESSION['user'], $email, $password, $first_name, $last_name);

                    // here we go
                    $this->redirect('users/profile');
                }
            }
        }

        // get the user data from database
        $user_data = $user->findById($_SESSION['user']);

        // load complete registration form view
        $data['user_data'] = $user_data;
        $this->render('users/complete_registration', $data);
    }

    public function profile()
    {
        // user connected?
        if (!isset($_SESSION['user'])) {
            $this->redirect('users/login');
        }

        // load user and authentication models
        $user = new UserModel();
        $authentication = new AuthModel();

        // get the user data from database
        $user_data = $user->findById($_SESSION['user']);

        // provider like twitter, linkedin, do not provide the user email
        // in this case, we should ask them to complete their profile before continuing
        if (!$user_data['email']) {
            $this->redirect('users/complete_registration');
        }

        // get the user authentication info from db, if any
        $user_authentication = $authentication->findByUserId($_SESSION['user']);

        // load profile view
        $data = ['user_data' => $user_data, 'user_authentication' => $user_authentication];
        $this->render('users/profile', $data);
    }
}
