<?php

class Auth extends Controller{

    public $userModel;
    public $googleAuth;
    public $mailAuth;

    function __construct()
    {
        $this->userModel = $this->model("NguoiDungModel");
        $this->googleAuth = $this->model("GoogleAuth");
        $this->mailAuth = $this->model("MailAuth");
        parent::__construct();
    }

    public function default()
    {
        header("Location: ./auth/signin");
    }

    function signin()
    {
        AuthCore::onLogin();
        $p = parse_url($_SERVER['REQUEST_URI']);
        if(isset($p['query'])) {
            $query = $p['query'];
            $queryitem = explode('&', $query);
            $get = array();
            foreach($queryitem as $key => $qi) {
                $r = explode('=', $qi);
                $get[$r[0]] = $r[1];
            }
            $this->googleAuth->handleCallback(urldecode($get['code']));
        } else {
            $authUrl = $this->googleAuth->getAuthUrl();
            $this->view("single_layout", [
                "Page" => "auth/signin",
                "Title" => "Đăng nhập",
                'authUrl' => $authUrl,
                "Script" => "signin",
                "Plugin" => [
                    "jquery-validate" => 1,
                    "notify" => 1
                ]
            ]);
        }
    }
    


    function signup(){
        AuthCore::onLogin();
        $this->view("single_layout", [
            "Page" => "auth/signup",
            "Title" => "Đăng ký tài khoản",
            "Script" => "signup",
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1
            ]
        ]);
    }

    function recover(){
        AuthCore::onLogin();
        $this->view("single_layout", [
            "Page" => "auth/recover",
            "Title" => "Khôi phục tài khoản",
            "Script" => "recover",
            "Plugin" => [
                "jquery-validate" => 1,
                "notify" => 1
            ]
        ]);
    }


    public function addUser()
    {   
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $this->userModel->create($email,$fullname,$password,"1990-01-01",1,1,1);
            echo $result;
        } 
    }

    public function getUser()
    {
        if(isset($_POST['email'])) {
            $user = $this->userModel->getById($_POST['email']);
            echo json_encode($user);
        }
    }

    public function checkLogin(){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $this->userModel->checkLogin($email,$password);
            echo $result;
        }
    }

    public function checkEmail(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $mail = $_POST['email'];
            $check = $this->userModel->getByEmail($mail);
            echo $check == '';
        }
    }
    

    public function sendOptAuth(){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $opt = rand(111111,999999);
            $email = $_POST['email'];
            $this->mailAuth->sendOpt($email,$opt);
            $this->userModel->updateOpt($email,$opt);
        }
    }

    public function logout()
    {
        $email = $_SESSION['user_email'];
        $result = $this->userModel->updateToken($email, NULL);
        if($result){
            session_destroy();
            setcookie("token","",time()-10,'/');
            header("Location: ../auth/signin");
        }
    }
}
?>