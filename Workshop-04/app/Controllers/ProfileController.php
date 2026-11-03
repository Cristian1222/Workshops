<?php
class ProfileController extends Controller {
    public function __construct(private PDO $db) {}
    public function show(): void {
        $this->auth(); $user=(new User($this->db))->get((int)$_SESSION['user_id']);
        if(!$user) go('login',['error'=>'login_required']); $this->view('profile/show',compact('user'));
    }
    public function update(): void {
        $this->auth(); $this->post(); $id=(int)$_SESSION['user_id'];
        $full=trim($_POST['full_name']??''); $name=trim($_POST['username']??''); $email=trim($_POST['email']??'');
        if(!$full||strlen($full)>100||!$name||strlen($name)>50||!filter_var($email,FILTER_VALIDATE_EMAIL)) go('profile',['error'=>'invalid_input']);
        $m=new User($this->db); if($m->usernameUsed($name,$id)) go('profile',['error'=>'invalid_input']);
        try { $m->update($id,$full,$name,$email); $_SESSION['username']=$name; go('profile',['success'=>'profile_updated']); }
        catch(PDOException $e) { error_log($e->getMessage()); go('profile',['error'=>'server_error']); }
    }
}
