<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\traits\ApiResonse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use ApiResonse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_name' => 'required',
            'user_email' => 'required|email|unique:customers,email',
            'phone_number' => 'required|unique:customers,phone',
            'gender' => 'nullable|in:male,female',
            'user_password' => 'required',
            'health_status' => 'nullable|max:255',
            'health_goal' => 'nullable|max:255',
        ]);

        if ($validated->fails()) {
            return $this->error($validated->errors(), $validated->errors()->first());
        }
        if ($request->hasFile('image')) {
            $image = $request['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image = $request['image']->storeAs('images', $imageName, 'public');

        } else {
            $image = null;
        }

        $customer = Customer::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'phone' => $request->phone_number,
            'code' => rand('100000', '999999'),
            'referal_code' => rand('100000', '999999'),
            'address' => $request->address ?? null,
            'gender' => $request->gender ?? null,
            'password' => Hash::make($request->user_password),
            'status' => $request->health_status ?? null,
            'image' => $image ?? null,
            'height' => $request->height ?? null,
            'weight' => $request->weight ?? null,
            'device_token' => $request->mobile_fire_token ?? null,
            'health_goal' => $request->health_goal ?? null,
            'age' => $request->age ?? null,
            'blood_type' => $request->blood_type ?? null,
            'is_active' => 1,

        ]);
        $token = $customer->createToken('customer')->plainTextToken;

        return $this->success(['customer' => new CustomerResource($customer), 'token_type' => 'Bearer', 'token' => $token], 'Customer Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        // Step 1: Validate the incoming request
        $validated = Validator::make($request->all(), [
            'user_email' => 'required|email|exists:customers,email',
            'user_password' => 'required',
        ]);

        if ($validated->fails()) {
            return $this->error($validated->errors(), $validated->errors()->first());
        }

        // Step 2: Check if the customer exists by email
        $customer = Customer::where('email', $request->user_email)->first();

        if (!$customer) {
            return $this->error([], 'Customer not found with this email.');
        }

        // Step 3: Verify the provided password matches the stored password
        if (!Hash::check($request->user_password, $customer->password)) {
            return $this->error([], 'Invalid password.');
        }
        if ($request->has('mobile_fire_token')) {
            $customer->device_token = $request->mobile_fire_token;
        }

        // Step 4: Generate a token for the authenticated user
        $token = $customer->createToken('customer')->plainTextToken;

        // Step 5: Return a response with user data and token
        return $this->success(
            ['customer' => new CustomerResource($customer), 'token' => $token],
            'Login successful'
        );
    }

    // Google Login
    public function redirectToGoogle()
    {
        // return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // try {
        //     $googleUser = Socialite::driver('google')->user();
        //     $customer = Customer::firstOrCreate(
        //         ['email' => $googleUser->getEmail()],
        //         ['name' => $googleUser->getName(), 'password' => Hash::make(str_random(16))]
        //     );

        //     $token = $customer->createToken('customer')->plainTextToken;

        //     return response()->json([
        //         'customer' => new CustomerResource($customer),
        //         'token_type' => 'Bearer',
        //         'token' => $token
        //     ], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Something went wrong'], 500);
        // }
    }

    // Facebook Login
    public function redirectToFacebook()
    {
        // return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        // try {
        //     $facebookUser = Socialite::driver('facebook')->user();
        //     $customer = Customer::firstOrCreate(
        //         ['email' => $facebookUser->getEmail()],
        //         ['name' => $facebookUser->getName(), 'password' => Hash::make(str_random(16))]
        //     );

        //     $token = $customer->createToken('customer')->plainTextToken;

        //     return response()->json([
        //         'customer' => new CustomerResource($customer),
        //         'token_type' => 'Bearer',
        //         'token' => $token
        //     ], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Something went wrong'], 500);
        // }
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_name' => 'nullable',
            'user_email' => 'nullable|email',
            'phone_number' => 'nullable|unique:customers,phone,' . auth('customer')->user()->id,
            'gender' => 'nullable|in:male,female',
        ]);

        if ($validated->fails()) {
            return response()->json(['error' => $validated->errors()->first()], 400);
        }


        $customer = Customer::find(auth('customer')->user()->id);
        // Handle image upload if exists
        if ($request->hasFile('image')) {
            if ($customer->image) {
                Storage::disk('public')->delete($customer->image);
            }
            $image = $request['image'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image = $request['image']->storeAs('images', $imageName, 'public');
            $customer->image = $image;
        }

        $customer->name = $request->user_name ?? $customer->name;
        $customer->email = $request->user_email ?? $customer->email;
        $customer->phone = $request->phone_number ?? $customer->phone;
        $customer->address = $request->address ?? $customer->address;
        $customer->gender = $request->gender ?? $customer->gender;
        $customer->password = Hash::make($request->user_password) ?? $customer->password;
        $customer->status = $request->status ?? $customer->status;
        $customer->height = $request->height ?? $customer->height;
        $customer->weight = $request->weight ?? $customer->weight;
        $customer->device_token = $request->device_token ?? $customer->device_token;
        $customer->health_goal = $request->health_goal ?? $customer->health_goal;
        $customer->age = $request->age ?? $customer->age;
        $customer->blood_type = $request->blood_type ?? $customer->blood_type;
        $customer->save();

        return $this->success(
            ['customer' => new CustomerResource($customer)],
            'Profile updated successfully'

        );
    }

    // Get Profile
    public function getProfile()
    {
        return $this->success(
            ['customer' => new CustomerResource(auth('customer')->user())],
            'Profile retrieved successfully'
        );
    }

    // Logout
    public function logout()
    {
        // Revoke the user's token to log them out
        auth('customer')->user()->currentAccessToken()->delete();

        return $this->success([], 'Logout successful');
    }

    // Delete Account
    public function deleteAccount()
    {
        $customer = Customer::find(auth('customer')->user()->id);

        // Delete user image if exists
        if ($customer->image) {
            Storage::disk('public')->delete($customer->image);
        }

        // Delete the customer
        $customer->delete();

        return $this->success([], 'Account deleted successfully');
    }
}
