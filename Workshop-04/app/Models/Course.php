<?php
class Course {
    public function __construct(private PDO $db) {}
    public function all(): array {
        return $this->db->query('SELECT c.*, ca.name career_name FROM courses c JOIN careers ca ON ca.id=c.career_id ORDER BY c.id DESC')->fetchAll();
    }
    public function careers(): array { return $this->db->query('SELECT id,name FROM careers ORDER BY name')->fetchAll(); }
    public function find(int $id): ?array {
        $s=$this->db->prepare('SELECT * FROM courses WHERE id=?'); $s->execute([$id]); return $s->fetch()?:null;
    }
    public function save(array $d): void {
        if($d['operation']==='create') {
            $s=$this->db->prepare('INSERT INTO courses(name,course_code,career_id,credits,description) VALUES(?,?,?,?,?)');
            $s->execute([$d['name'],$d['course_code'],$d['career_id'],$d['credits'],$d['description']]);
        } else {
            $s=$this->db->prepare('UPDATE courses SET name=?,course_code=?,career_id=?,credits=?,description=? WHERE id=?');
            $s->execute([$d['name'],$d['course_code'],$d['career_id'],$d['credits'],$d['description'],$d['id']]);
        }
    }
    public function delete(int $id): void { $s=$this->db->prepare('DELETE FROM courses WHERE id=?'); $s->execute([$id]); }
}
