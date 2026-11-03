<?php
session_start();
require_once __DIR__.'/../app/Core/helpers.php';
require_once __DIR__.'/../app/Core/Controller.php';
require_once __DIR__.'/../app/Config/database.php';
foreach (['User','Course'] as $m) require_once __DIR__.'/../app/Models/'.$m.'.php';
foreach (['Auth','Dashboard','Course','Profile'] as $c) require_once __DIR__.'/../app/Controllers/'.$c.'Controller.php';
try { $db=db(); } catch(PDOException $e) { error_log($e->getMessage()); http_response_code(500); exit('Error de conexión. Revise app/Config/database.php.'); }
$route=$_GET['route']??'login';
$auth=new AuthController($db); $dashboard=new DashboardController(); $courses=new CourseController($db); $profile=new ProfileController($db);
switch($route) {
 case 'login': $auth->loginForm(); break;
 case 'login_process': $auth->login(); break;
 case 'register': $auth->registerForm(); break;
 case 'register_process': $auth->register(); break;
 case 'logout': $auth->logout(); break;
 case 'dashboard': $dashboard->index(); break;
 case 'courses': $courses->index(); break;
 case 'course_create': $courses->create(); break;
 case 'course_edit': $courses->edit(); break;
 case 'course_save': $courses->save(); break;
 case 'course_delete': $courses->delete(); break;
 case 'profile': $profile->show(); break;
 case 'profile_update': $profile->update(); break;
 default: http_response_code(404); echo 'Página no encontrada.';
}
