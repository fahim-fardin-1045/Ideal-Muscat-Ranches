<?php
declare(strict_types=1);
ini_set('session.use_strict_mode','1');
session_set_cookie_params(['httponly'=>true,'secure'=>!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off','samesite'=>'Lax']);
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE,'UTF-8'); }
function db(): PDO {
 static $db; if ($db) return $db;
 $c=require __DIR__.'/../config/database.php';
 try { $db=new PDO("mysql:host={$c['host']};port={$c['port']};dbname={$c['database']};charset=utf8mb4",$c['user'],$c['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]); }
 catch(PDOException $ex) { error_log($ex->getMessage()); http_response_code(503); exit('Database unavailable. Check config/database.php and import database.sql.'); }
 return $db;
}
function settings(): array { return db()->query('SELECT name,value FROM settings')->fetchAll(PDO::FETCH_KEY_PAIR); }
function csrf(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf']; }
function token(): string { return '<input type="hidden" name="csrf" value="'.e(csrf()).'">'; }
function check(): void { if(!hash_equals(csrf(),(string)($_POST['csrf']??''))) {http_response_code(403);exit('Invalid form token. Reload and try again.');} }
function admin(): void { if(empty($_SESSION['admin'])) {header('Location: login.php');exit;} }
function entries(string $kind): array { $q=db()->prepare('SELECT * FROM entries WHERE kind=? AND published=1 ORDER BY sort_order,id DESC');$q->execute([$kind]);return $q->fetchAll(); }
function imagepath(string $s): string { return preg_match('~^assets/img/[a-zA-Z0-9_./-]+\.(png|jpg|jpeg|webp|gif)$~i',$s) && strpos($s,'..')===false ? $s : ''; }
