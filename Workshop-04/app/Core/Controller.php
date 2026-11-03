<?php
class Controller {
    protected function view(string $file, array $data=[]): void {
        extract($data, EXTR_SKIP);
        require __DIR__.'/../Views/layout/header.php';
        require __DIR__.'/../Views/'.$file.'.php';
        require __DIR__.'/../Views/layout/footer.php';
    }
    protected function auth(): void { if(empty($_SESSION['user_id'])) go('login',['error'=>'login_required']); }
    protected function post(): void { if($_SERVER['REQUEST_METHOD']!=='POST') go('login',['error'=>'invalid_request']); }
}
