<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalesUserController extends Controller
{
    /**
     * Tampilkan daftar sales/admin.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        $users = $query->withCount('visits')
            ->orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('users'));
    }

    /**
     * Tampilkan formulir tambah sales baru.
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Simpan sales baru ke database.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->has('is_active') ? true : false;

        $user = User::create($data);

        return redirect()->route('sales.index')
            ->with('success', "Pengguna '{$user->name}' ({$user->role}) berhasil ditambahkan.");
    }

    /**
     * Tampilkan detail pengguna sales beserta daftar kunjungannya.
     */
    public function show($id)
    {
        $user = User::with(['visits.store' => function ($q) {
            $q->orderBy('visit_date', 'desc');
        }])->findOrFail($id);

        return view('sales.show', compact('user'));
    }

    /**
     * Tampilkan formulir edit sales.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('sales.edit', compact('user'));
    }

    /**
     * Perbarui data sales di database.
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->has('is_active') ? true : false;

        $user->update($data);

        return redirect()->route('sales.index')
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Hapus data sales dari database.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan izinkan menghapus diri sendiri jika sedang login
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('sales.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang Anda gunakan.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('sales.index')
            ->with('success', "Pengguna '{$name}' berhasil dihapus dari sistem.");
    }
}
