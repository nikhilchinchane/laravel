namespace Alireza\Authentication;
<?php

namespace Nikhil\Authentication;

use Config, Request, Session, Hash;
use App\User;
 
Class MyAuth
{
    public $redirect_login = '/users/home';
    public $redirect_logout = '/users/logout';
    public $login = '/user/login';
    protected $data;
 
    public function __construct()
    {
        if (Request::isMethod('post')) //Get post inputs
            $this->data = array('username' => Input::get('username'), 'password' => Input::get('password'));
    }
 
    public function login($data = false)
    {
        $this->data = $data;
 
        if ($this->data && !is_array($this->data))
            return redirect($this->login)->with('message', 'sorry no array to log-in manually')->send();
 
        if ($this->data && !Session::has('user')) {
            $result = User::Where(['email' => $this->data['username']
            ])
                ->first();
 
            if ($result && Hash::check($this->data['password'], $result->password)) {
                Session::put('user', $result);
                return Redirect($this->redirect_login)->with('message', 'Welcome log-in succeeded ')->send();
            }
            Session::flush();
            return redirect($this->login)->with('message', 'Login Failed, wrong username or password')->send();
        }
    }
 
    public function logout()
    {
        Session::flush();
        return redirect($this->login)->with('message', 'logout succeeded')->send();
    }
 
}