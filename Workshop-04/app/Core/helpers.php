<?php
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function go(string $route, array $params=[]): never {
    header('Location: index.php?'.http_build_query(['route'=>$route]+$params)); exit;
}
function alert(): void {
    $messages = [
        'success'=>['registered'=>'Usuario registrado correctamente.','course_created'=>'Curso creado correctamente.','course_updated'=>'Curso actualizado correctamente.','course_deleted'=>'Curso eliminado correctamente.','profile_updated'=>'Perfil actualizado.','logged_out'=>'Sesión cerrada correctamente.'],
        'error'=>['invalid_input'=>'Complete los datos correctamente.','invalid_credentials'=>'Usuario o contraseña incorrectos.','login_required'=>'Debe iniciar sesión.','server_error'=>'Ocurrió un error. Inténtelo más tarde.','duplicate_code'=>'El código del curso ya existe.','course_not_found'=>'No se encontró el curso.','invalid_request'=>'Solicitud no válida.']
    ];
    foreach (['success'=>'success','error'=>'danger'] as $key=>$class) {
        $code=$_GET[$key]??'';
        if(isset($messages[$key][$code])) echo '<div class="alert alert-'.$class.'">'.e($messages[$key][$code]).'</div>';
    }
}
