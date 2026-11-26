<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    function login(Request $r) {
        $u = DB::select('select * from staff where username = ?', [$r->username]);
        if ($u && password_verify($r->password, $u[0]->password)) {
            session(['id' => $u[0]->id, 'role' => $u[0]->role]);
            return redirect('/home');
        }
        return back()->with('msg', 'Wrong username or password');
    }

    function logout() {
        session()->flush();
        return redirect('/')->with('ok', 'You have been logged out');
    }

    function password(Request $r) {
        $u = DB::select('select * from staff where id = ?', [session('id')]);
        if (!password_verify($r->old, $u[0]->password)) return back()->with('msg', 'Old password is wrong');
        if (strlen($r->new) < 8) return back()->with('msg', 'Password must have at least 8 characters');
        if ($r->new != $r->confirm) return back()->with('msg', 'Passwords do not match');
        DB::update('update staff set password = ? where id = ?', [password_hash($r->new, PASSWORD_DEFAULT), session('id')]);
        return back()->with('ok', 'Password changed');
    }

    function register(Request $r) {
        if (session('role') == 'logistic')
            DB::insert('insert into equipment (name, qty) values (?, ?)', [$r->name, $r->qty]);
        return redirect('/equipment');
    }

    function request(Request $r) {
        if (session('role') == 'coordinator')
            DB::insert('insert into requests (name, qty) values (?, ?)', [$r->name, $r->qty]);
        return redirect('/requests');
    }

    function decide($id, $status) {
        if (session('role') == 'hod')
            DB::update('update requests set status = ? where id = ?', [$status, $id]);
        return redirect('/requests');
    }

    function home() {
        if (!session('id')) return redirect('/');
        if (session('role') == 'logistic') {
            $units = DB::select('select coalesce(sum(qty), 0) c from equipment')[0]->c;
            return view('home', ['units' => $units]);
        }
        $n = fn($s) => DB::select('select count(*) c from requests where status = ?', [$s])[0]->c;
        return view('home', ['pending' => $n('pending'), 'approved' => $n('approved'), 'rejected' => $n('rejected')]);
    }

    function list($table, Request $r) {
        $page = max(1, (int) $r->page);
        $t = $table == 'equipment' ? 'equipment' : 'requests';
        $rows = DB::select("select * from $t limit ? offset ?", [5, ($page - 1) * 5]);
        $total = DB::select("select count(*) c from $t")[0]->c;
        return view('list', ['rows' => $rows, 'table' => $table, 'page' => $page, 'pages' => ceil($total / 5)]);
    }
}
