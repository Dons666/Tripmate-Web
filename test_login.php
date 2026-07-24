<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$req = Illuminate\Http\Request::create('/api/auth/login', 'POST', ['email'=>'test@gmail.com', 'password'=>'password123']);
$res = $kernel->handle($req);
echo $res->getStatusCode() . "\n";
echo $res->getContent() . "\n";
