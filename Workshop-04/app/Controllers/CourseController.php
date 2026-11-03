<?php
class CourseController extends Controller {
    public function __construct(private PDO $db) {}
    public function index(): void { $this->auth(); $courses=(new Course($this->db))->all(); $this->view('courses/index',compact('courses')); }
    public function create(): void { $this->auth(); $careers=(new Course($this->db))->careers(); $this->view('courses/create',compact('careers')); }
    public function edit(): void {
        $this->auth(); $id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT); $m=new Course($this->db);
        $course=$id?$m->find($id):null; if(!$course) go('courses',['error'=>'course_not_found']);
        $careers=$m->careers(); $this->view('courses/edit',compact('course','careers'));
    }
    public function save(): void {
        $this->auth(); $this->post();
        $d=['operation'=>$_POST['operation']??'', 'id'=>(int)($_POST['id']??0),
            'name'=>trim($_POST['name']??''),'course_code'=>trim($_POST['course_code']??''),
            'career_id'=>(int)($_POST['career_id']??0),'credits'=>(int)($_POST['credits']??-1),
            'description'=>trim($_POST['description']??'')];
        if(!in_array($d['operation'],['create','update'],true)||($d['operation']==='update'&&$d['id']<1)||
           $d['name']===''||strlen($d['name'])>150||$d['course_code']===''||strlen($d['course_code'])>30||
           $d['career_id']<1||$d['credits']<0||$d['credits']>255||$d['description']==='') go('courses',['error'=>'invalid_input']);
        try { (new Course($this->db))->save($d); go('courses',['success'=>$d['operation']==='create'?'course_created':'course_updated']); }
        catch(PDOException $e) { error_log($e->getMessage()); go('courses',['error'=>($e->errorInfo[1]??0)==1062?'duplicate_code':'server_error']); }
    }
    public function delete(): void {
        $this->auth(); $this->post(); $id=(int)($_POST['id']??0); if($id<1) go('courses',['error'=>'invalid_input']);
        try { (new Course($this->db))->delete($id); go('courses',['success'=>'course_deleted']); }
        catch(PDOException $e) { error_log($e->getMessage()); go('courses',['error'=>'server_error']); }
    }
}
