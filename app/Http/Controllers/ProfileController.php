<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use App\Models\Tracking;

class ProfileController extends Controller
{
    /**
     * Show the user profile page
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Show the change password form
     */
    public function showChangePasswordForm()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        // Performance monitoring
        $startTime = microtime(true);
        
        try {
            // Validate the request
            $request->validate([
                'current_password' => ['required', 'string'],
                'new_password' => [
                    'required', 
                    'string', 
                    'min:8',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
                'new_password_confirmation' => ['required', 'string']
            ], [
                'current_password.required' => 'Password saat ini harus diisi',
                'new_password.required' => 'Password baru harus diisi',
                'new_password.min' => 'Password baru minimal 8 karakter',
                'new_password.confirmed' => 'Konfirmasi password tidak cocok',
                'new_password_confirmation.required' => 'Konfirmasi password harus diisi'
            ]);

            $user = Auth::user();

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak benar'
                ])->withInput();
            }

            // Check if new password is different from current
            if (Hash::check($request->new_password, $user->password)) {
                return back()->withErrors([
                    'new_password' => 'Password baru harus berbeda dari password saat ini'
                ])->withInput();
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->password_changed_at = now();
            $user->save();

            // Log the activity
            Tracking::create([
                'user' => $user->name,
                'event' => 'Password berhasil diubah'
            ]);

            // Performance monitoring
            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000;

            Log::info('Password Change Success', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'execution_time_ms' => round($executionTime, 2),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('profile.change-password')
                ->with('success', 'Password berhasil diubah! Silakan login ulang dengan password baru.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Password Change Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.'
            ])->withInput();
        }
    }

    /**
     * Update user profile information
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ], [
                'name.required' => 'Nama harus diisi',
                'name.max' => 'Nama maksimal 255 karakter',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah digunakan pengguna lain'
            ]);

            // Update user information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            // Log the activity
            Tracking::create([
                'user' => $user->name,
                'event' => 'Profile berhasil diperbarui'
            ]);

            return redirect()->route('profile.index')
                ->with('success', 'Profile berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Profile Update Error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return back()->withErrors([
                'general' => 'Terjadi kesalahan saat memperbarui profile.'
            ])->withInput();
        }
    }

    /**
     * Show password strength requirements
     */
    public function getPasswordRequirements()
    {
        return response()->json([
            'requirements' => [
                'Minimal 8 karakter',
                'Mengandung huruf besar dan kecil',
                'Mengandung angka',
                'Mengandung simbol (!@#$%^&*)',
                'Tidak menggunakan password yang mudah ditebak'
            ]
        ]);
    }
}