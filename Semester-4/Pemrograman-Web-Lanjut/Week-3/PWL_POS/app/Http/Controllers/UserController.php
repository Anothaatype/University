<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   

        // $user = LevelModel::with('level')->get();
        // dd($user);

        $user = LevelModel::with('level')->get();
        return view('user',['data' =>$user]);

        // // tambah data user dengan Eloquent Model
        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); //tambahkan data ke tabel m_user
        
        // //Coba akses Model UserModel
        // $user = UserModel::all(); //ambil semua data dari table m_user
        // return view ('user', ['data' => $user]);

        // implementasi dari $fillable yang dimana menampilkan kolom yang diinginkan
        // $data = [ 
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel ::create($data);

        // $user = UserModel ::all();
        // return view('user' , ['data' => $user]);

        // Implementasi function find berfungsi untuk menampilkan atau mencari satu kondisi saja
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);

        // //Implementasi function where dengan kondisi first 
        // $user = UserModel::where('level_id', 1)-> first();
        // return view('user', ['data' => $user]);

        // // Alternatif penggunaan function where dengan kondisi first 
        // $user = UserModel::firstwhere('level_id', 1);
        // return view('user', ['data' => $user]);

        //Implementasi FindOr yang dimana digunakan untuk menampilkan column dengan kondisi yang dipilih 
        // $user = UserModel::findOr(1, ['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view ('user', ['data' => $user]);

        // //Implementasi FindOr yang dimana disini menghasilkam outpur abort karena tidak ada user id 20 
        // $user = UserModel::findOr(20, ['username', 'nama'], function(){
        //     abort(404);
        // });
        // return view ('user', ['data' => $user]);

        // // Implementasi FindOrFail 
        // $user = UserModel::findOrFail(1);
        // return view ('user', ['data' => $user]);

        // //Implementasi firstOrFail dimaana terjadi fail dengan tidak adanya manager 9 memunculkan 404 abort 
        // $user = UserModel::where('username', 'manager 9')->firstOrFail();
        // return view('user', ['data' => $user]);

        // // Implementasi Retrieving Aggregates dengan output script link 
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // return view ('user', ['data' => $user]);

        // // Implementasi Retrieving Aggregates dengan output tetap table
        // $user = UserModel::where('level_id', 2)->count();
        // return view ('user', ['data' => $user]);

        // Implementasi firstOrCreate tetapi output nya error dikarenakan tidak ada field untuk password
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22' , 
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // return view('user', ['data' => $user]);
         
        // // Implementasi dari firstOrNew
        // $user = UserModel::firstOrNew(
        //         [
        //             'username' => 'manager' , 
        //             'nama' => 'Manager',
        //         ],
        //     );
        //     return view('user', ['data' => $user]);

        // // Implementasi firstOrCreate yang dimana tetap akan mengeluarkan output error karena tidak adanya fields password dalam fillable
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager33' , 
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // return view('user', ['data' => $user]);

        //Implementasi isDirty and isClean
        // $user = UserModel::create([
        //     'username' => 'manager44',
        //     'nama' => 'Manager44' , 
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username ='manager45';

        // $user->isDirty();//true
        // $user->isDirty('username'); //true
        // $user->isDirty('nama'); //false
        // $user->isDirty(['nama', 'username']); //true 

        // $user->isClean();//false
        // $user->isClean('username'); //false
        // $user->isClean('nama'); //true
        // $user->isClean(['nama', 'username']); //false

        // $user-save();

        // $user->isDirty(); //false
        // $user->isClean(); //true
        // dd($user->isDirty());

        //Implementasi wasChanged
        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11' , 
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username ='manager12';

        // $user->save();

        // $user->wasChanged();//true
        // $user->wasChanged('username'); //true
        // $user->wasChanged('nama'); //true
        // $user->wasChanged(['nama', 'username']); //false
        // dd($user->wasChanged(['nama', 'username'])); //true

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);
    }

    // function untuk menambah user
    public function tambah()
    {
        return view('user_tambah');
    }

    // function tambah user dan menyimpan dalam data base
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->name = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }

}
