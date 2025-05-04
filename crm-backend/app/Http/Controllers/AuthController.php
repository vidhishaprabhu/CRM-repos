<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        if (Str::endsWith($user->email, '@admin.com')) {
            $user->assignRole('Admin');
        } elseif(Str::endsWith($user->email,'@sales.com')) {
            $user->assignRole('Sales Manager');
        }
        elseif(Str::endsWith($user->email,'@support.com')){
            $user->assignRole('Support');
        }    
        return response()->json(['message'=>'User registered successfully','user'=>$user]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Invalid Credentials']]);
        }

        if (Str::endsWith($user->email, '@admin.com')) {
            $user->assignRole('Admin');
        } elseif (Str::endsWith($user->email, '@sales.com')) {
            $user->assignRole('Sales Manager');
        } elseif (Str::endsWith($user->email, '@support.com')) {
            $user->assignRole('Support');
        }
        LoginLog::create([
            'user_id'=>$user->id,
        ]);
        $role = $user->roles->first()->name ?? null;

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
            'role' => $role
        ]);
    }
    public function getAllUsers(Request $request){
        $user=User::with('roles')->get();
        return response()->json($user);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message'=>'User logged out successfully']);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));
        if ($request->has('role')) {
            $user->syncRoles([$request->role]);
        }
        return response()->json(['message' => 'User Updated Successfully']);
    }

    public function delete($id){
        $user=User::findorFail($id);
        $user->delete();
        return response()->json(['message'=>'User deleted successfully']);
    }

    public function getLoginChartData()
    {
        $startDate = Carbon::now()->subDays(6); 
        $endDate = Carbon::now();

        $logins = LoginLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('count', 'date');

        $dateRange = new Collection();
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
        $formatted = $date->format('Y-m-d');
        $dateRange->put($formatted, $logins->get($formatted, 0));
        }

        return response()->json([
            'labels' => $dateRange->keys(),
            'data' => $dateRange->values()
        ]);
    }
    public function getLoginChartAdminData(){
        $role='Admin';
        $startDate =Carbon::now()->subDays(6);
        $endDate=Carbon::now();
        $logins=LoginLog::selectRaw('DATE(created_at) as date,COUNT(*) as count')
        ->whereBetween('created_at',[$startDate,$endDate])
        ->whereHas('user.roles', function($query) use ($role){
            $query->where('name',$role);
        
        })
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('count','date');
        $dateRange = new Collection();
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
        $formatted = $date->format('Y-m-d');
        $dateRange->put($formatted, $logins->get($formatted, 0));
        }

        return response()->json([
            'labels' => $dateRange->keys(),
            'data' => $dateRange->values()
        ]);
    }
}
