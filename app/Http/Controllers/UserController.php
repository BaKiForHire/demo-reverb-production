<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing users.
 * Handles listing, showing, updating, upgrading tiers, and deleting users.
 */
class UserController extends Controller
{
    /**
     * Display a listing of all users.
     * Admin only.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return response()->json($user);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->only(['name', 'email', 'is_admin']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully.', 'user' => $user]);
    }

    /**
     * Handle the upgrade of a user's tier.
     */
    public function upgradeTier(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        // Validate request data
        $request->validate([
            'tier_id' => 'required|exists:tiers,id',
        ]);

        $user->tiers()->syncWithoutDetaching([$request->tier_id => ['status' => true]]);

        return response()->json(['message' => 'User tier upgraded successfully.']);
    }

    /**
     * Remove the specified user from storage.
     * Admin only.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

    /**
     * Share user's location.
     */
    public function shareLocation(Request $request)
    {
        // Get the authenticated user from the request
        $user = $request->user();
    
        // Check if the user has a location set
        if ($user->location) {
            return response()->json($user->location); // Return the user's location
        }
    
        // Return an error if no location is set
        return response()->json(['error' => 'User has no location set.'], 404);
    }
}
