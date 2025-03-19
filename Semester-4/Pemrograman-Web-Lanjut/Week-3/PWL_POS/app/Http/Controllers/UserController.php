<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Level;
use App\Models\LevelModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function page() {
        $users = User::with('level')->get();
        $levels = Level::all();
        $metadata = [
            'pageTitle' => 'Users',
            'breadcrumbs' => [
                [
                    'name' => 'Users',
                    'route' => 'users.page'
                ],
                [
                    'name' => 'List',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.user.index', compact('users', 'levels', 'metadata'));
    }

    public function storePage() {
        $levels = Level::all();
        $metadata = [
            'pageTitle' => 'Create User',
            'breadcrumbs' => [
                [
                    'name' => 'Users',
                    'route' => 'users.page'
                ],
                [
                    'name' => 'Create',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.user.store', compact('metadata', 'levels'));
    }

    public function updatePage(string $id) {
        $user = User::with('level')->findOrFail($id);
        $levels = Level::all();
        $metadata = [
            'pageTitle' => 'Update User',
            'breadcrumbs' => [
                [
                    'name' => 'Users',
                    'route' => 'users.page'
                ],
                [
                    'name' => 'Update',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.user.update', compact('metadata', 'user', 'levels'));
    }

    public function list(Request $request) {
        $users = User::with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('actions', function ($user) {
            $btn = '<a href="' . route('users.show', ['id' => $user->user_id]) . '" class="btn btn-primary btn-sm">Details</a>';
            $btn .= '<a href="' . route('users.update-page', ['id' => $user->user_id]) . '" class="btn btn-warning btn-sm ml-0 ml-md-2">Update</a>';
            $btn .= '<form action="' . route('users.delete', ['id' => $user->user_id]) . '" method="POST" style="display:inline-block;">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm ml-0 ml-md-2" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</button></form>';

            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(UserRequest $request) {
        $validatedData = $request->validated();

        User::create([
            'level_id' => $validatedData['level_id'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect()->route('users.page')->with('success', 'User created successfully.')->withInput($request->only('username', 'name'));
    }

    public function show(string $id) {
        $user = User::with('level')->findOrFail($id);
        $metadata = [
            'pageTitle' => 'User Details',
            'breadcrumbs' => [
                [
                    'name' => 'Users',
                    'route' => 'users.page'
                ],
                [
                    'name' => 'Details',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.user.show', compact('user', 'metadata'));
    }

    public function update(UserRequest $request, string $id) {
        $validatedData = $request->validated();

        $user = User::findOrFail($id);
        $user->update([
            'level_id' => $validatedData['level_id'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect()->route('users.page')->with('success', 'User updated successfully.')->withInput($request->only('username', 'name'));
    }

    public function delete(string $id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.page')->with('success', 'User deleted successfully.');
    }
    // public function index()
    // {   

    //     // $user = LevelModel::with('level')->get();
    //     // dd($user);

    //     $user = LevelModel::with('level')->get();
    //     return view('user',['data' =>$user]);

    //     // // tambah data user dengan Eloquent Model
    //     // $data = [
    //     //     'nama' => 'Pelanggan Pertama',
    //     // ];
    //     // UserModel::where('username', 'customer-1')->update($data); //tambahkan data ke tabel m_user
        
    //     // //Coba akses Model UserModel
    //     // $user = UserModel::all(); //ambil semua data dari table m_user
    //     // return view ('user', ['data' => $user]);

    //     // implementasi dari $fillable yang dimana menampilkan kolom yang diinginkan
    //     // $data = [ 
    //     //     'level_id' => 2,
    //     //     'username' => 'manager_tiga',
    //     //     'nama' => 'Manager 3',
    //     //     'password' => Hash::make('12345')
    //     // ];
    //     // UserModel ::create($data);

    //     // $user = UserModel ::all();
    //     // return view('user' , ['data' => $user]);

    //     // Implementasi function find berfungsi untuk menampilkan atau mencari satu kondisi saja
    //     // $user = UserModel::find(1);
    //     // return view('user', ['data' => $user]);

    //     // //Implementasi function where dengan kondisi first 
    //     // $user = UserModel::where('level_id', 1)-> first();
    //     // return view('user', ['data' => $user]);

    //     // // Alternatif penggunaan function where dengan kondisi first 
    //     // $user = UserModel::firstwhere('level_id', 1);
    //     // return view('user', ['data' => $user]);

    //     //Implementasi FindOr yang dimana digunakan untuk menampilkan column dengan kondisi yang dipilih 
    //     // $user = UserModel::findOr(1, ['username', 'nama'], function(){
    //     //     abort(404);
    //     // });
    //     // return view ('user', ['data' => $user]);

    //     // //Implementasi FindOr yang dimana disini menghasilkam outpur abort karena tidak ada user id 20 
    //     // $user = UserModel::findOr(20, ['username', 'nama'], function(){
    //     //     abort(404);
    //     // });
    //     // return view ('user', ['data' => $user]);

    //     // // Implementasi FindOrFail 
    //     // $user = UserModel::findOrFail(1);
    //     // return view ('user', ['data' => $user]);

    //     // //Implementasi firstOrFail dimaana terjadi fail dengan tidak adanya manager 9 memunculkan 404 abort 
    //     // $user = UserModel::where('username', 'manager 9')->firstOrFail();
    //     // return view('user', ['data' => $user]);

    //     // // Implementasi Retrieving Aggregates dengan output script link 
    //     // $user = UserModel::where('level_id', 2)->count();
    //     // dd($user);
    //     // return view ('user', ['data' => $user]);

    //     // // Implementasi Retrieving Aggregates dengan output tetap table
    //     // $user = UserModel::where('level_id', 2)->count();
    //     // return view ('user', ['data' => $user]);

    //     // Implementasi firstOrCreate tetapi output nya error dikarenakan tidak ada field untuk password
    //     // $user = UserModel::firstOrCreate(
    //     //     [
    //     //         'username' => 'manager22' , 
    //     //         'nama' => 'Manager Dua Dua',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ],
    //     // );
    //     // return view('user', ['data' => $user]);
         
    //     // // Implementasi dari firstOrNew
    //     // $user = UserModel::firstOrNew(
    //     //         [
    //     //             'username' => 'manager' , 
    //     //             'nama' => 'Manager',
    //     //         ],
    //     //     );
    //     //     return view('user', ['data' => $user]);

    //     // // Implementasi firstOrCreate yang dimana tetap akan mengeluarkan output error karena tidak adanya fields password dalam fillable
    //     // $user = UserModel::firstOrCreate(
    //     //     [
    //     //         'username' => 'manager33' , 
    //     //         'nama' => 'Manager Tiga Tiga',
    //     //         'password' => Hash::make('12345'),
    //     //         'level_id' => 2
    //     //     ],
    //     // );
    //     // return view('user', ['data' => $user]);

    //     //Implementasi isDirty and isClean
    //     // $user = UserModel::create([
    //     //     'username' => 'manager44',
    //     //     'nama' => 'Manager44' , 
    //     //     'password' => Hash::make('12345'),
    //     //     'level_id' => 2,
    //     // ]);

    //     // $user->username ='manager45';

    //     // $user->isDirty();//true
    //     // $user->isDirty('username'); //true
    //     // $user->isDirty('nama'); //false
    //     // $user->isDirty(['nama', 'username']); //true 

    //     // $user->isClean();//false
    //     // $user->isClean('username'); //false
    //     // $user->isClean('nama'); //true
    //     // $user->isClean(['nama', 'username']); //false

    //     // $user-save();

    //     // $user->isDirty(); //false
    //     // $user->isClean(); //true
    //     // dd($user->isDirty());

    //     //Implementasi wasChanged
    //     // $user = UserModel::create([
    //     //     'username' => 'manager11',
    //     //     'nama' => 'Manager11' , 
    //     //     'password' => Hash::make('12345'),
    //     //     'level_id' => 2,
    //     // ]);

    //     // $user->username ='manager12';

    //     // $user->save();

    //     // $user->wasChanged();//true
    //     // $user->wasChanged('username'); //true
    //     // $user->wasChanged('nama'); //true
    //     // $user->wasChanged(['nama', 'username']); //false
    //     // dd($user->wasChanged(['nama', 'username'])); //true

    //     // $user = UserModel::all();
    //     // return view('user', ['data' => $user]);
    // }

    // // function untuk menambah user
    // public function tambah()
    // {
    //     return view('user_tambah');
    // }

    // // function tambah user dan menyimpan dalam data base
    // public function tambah_simpan(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'level_id' => $request->level_id
    //     ]);
    //     return redirect('/user');
    // }

    // public function ubah($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->name = $request->nama;
    //     $user->password = Hash::make('$request->password');
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');
    // }

    // public function hapus($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }

}
