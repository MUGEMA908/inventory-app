<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    function up() {
        Schema::create('staff', function (Blueprint $t) {
            $t->id(); $t->string('username'); $t->string('password'); $t->string('role');
        });
        Schema::create('equipment', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->integer('qty');
        });
        Schema::create('requests', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->integer('qty'); $t->string('status')->default('pending');
        });
        $users = ['logistic' => 'Logistic@2026', 'coordinator' => 'Coord@2026', 'hod' => 'HoD@2026'];
        foreach ($users as $role => $pass) {
            DB::insert('insert into staff (username, password, role) values (?, ?, ?)',
                [$role, password_hash($pass, PASSWORD_DEFAULT), $role]);
        }
    }
    function down() {
        Schema::dropIfExists('staff'); Schema::dropIfExists('equipment'); Schema::dropIfExists('requests');
    }
};
