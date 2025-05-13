<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\createOrganizationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(){
        return view('admin.organizations');
    }

    public function organizationsList(): JsonResponse
    {
        try {
            // Fetch organizations with selected fields
            $organizations = User::where('role_id',2)->select('id', 'name', 'org', 'email', 'profile_pic', 'street', 'district', 'city', 'postal_code')->get()->map(function ($user) {
                $user->profile_pic = $user->profile_pic ? Storage::url($user->profile_pic) : null;
                return $user;
            });

            // Return as JSON response
            return response()->json([
                'status' => true,
                'message' => 'User list fetched successfully.',
                'data' => $organizations
            ]);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch organizations.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(createOrganizationRequest $request)
    {
        $data = $request->validated();

        // Handle file upload if logo is provided
        if ($request->hasFile('profile_pic')) {
            $data['profile_pic'] = $request->file('profile_pic')->store('logos', 'public');
        }

        // Create new organization record
        $password=generatePassword();
        $organization = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 2,
            'org' => $data['org'] ?? null,
            'profile_pic' => $data['profile_pic'] ?? null,
            'password' => Hash::make('Admin12#'),
            'street' => $data['street'],
            'district' => $data['district'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
        ]);

        return response()->json([
            'message' => 'Organization created successfully.',
            'organization' => $organization
        ]);
    }
}
