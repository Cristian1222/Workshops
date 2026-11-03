<?php
class User {
    public function __construct(private PDO $db) {}
    public function byUsername(string $name): ?array {
        $s=$this->db->prepare('SELECT * FROM users WHERE username=? LIMIT 1'); $s->execute([$name]); return $s->fetch()?:null;
    }
    public function create(string $full,string $name,string $email,string $pass): void {
        $s=$this->db->prepare('INSERT INTO users(full_name,username,email,password_hash) VALUES(?,?,?,?)');
        $s->execute([$full,$name,$email,password_hash($pass,PASSWORD_DEFAULT)]);
    }
    public function get(int $id): ?array {
        $s=$this->db->prepare('SELECT id,full_name,username,email FROM users WHERE id=?'); $s->execute([$id]); return $s->fetch()?:null;
    }
    public function usernameUsed(string $name,int $id=0): bool {
        $s=$this->db->prepare('SELECT id FROM users WHERE username=? AND id<>?'); $s->execute([$name,$id]); return (bool)$s->fetch();
    }
    public function update(int $id,string $full,string $name,string $email): void {
        $s=$this->db->prepare('UPDATE users SET full_name=?,username=?,email=? WHERE id=?'); $s->execute([$full,$name,$email,$id]);
    }
}
