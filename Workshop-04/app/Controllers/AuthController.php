<?php
class AuthController extends Controller {
    public function __construct(private PDO $db) {}
    public function loginForm(): void { $this->view('auth/login'); }
    public function login(): void {
        $this->post(); $name=trim($_POST['username']??''); $pass=$_POST['password']??'';
        $u=(new User($this->db))->byUsername($name);
        if(!$u || !password_verify($pass,$u['password_hash'])) go('login',['error'=>'invalid_credentials']);
        session_regenerate_id(true); $_SESSION['user_id']=(int)$u['id']; $_SESSION['username']=$u['username']; go('dashboard');
    }
    public function registerForm(): void { $this->view('auth/register'); }
    public function register(): void {
        $this->post(); $full=trim($_POST['full_name']??''); $name=trim($_POST['username']??'');
        $email=trim($_POST['email']??''); $pass=$_POST['password']??'';
        if(!$full||strlen($full)>100||!$name||strlen($name)>50||!filter_var($email,FILTER_VALIDATE_EMAIL)||!$pass) go('register',['error'=>'invalid_input']);
        try { $m=new User($this->db); if($m->usernameUsed($name)) go('register',['error'=>'invalid_input']); $m->create($full,$name,$email,$pass); go('login',['success'=>'registered']); }
        catch(PDOException $e) { error_log($e->getMessage()); go('register',['error'=>'server_error']); }
    }
    public function logout(): void {
        $this->post(); $_SESSION=[]; session_destroy(); header('Location: index.php?route=login&success=logged_out'); exit;
    }
}
