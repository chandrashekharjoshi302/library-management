<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user signup.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Signup(Request $request)
    {
        // Validate the incoming request data
        $validateUser = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',  // Ensure email is unique
            'password' => 'required|string|min:6',  // Validate password with minimum length
        ]);

        // Check if validation failed
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Validation Error',  // Error message
                'errors' => $validateUser->errors()->all(),  // Include validation errors
            ], 422);  // 422 Unprocessable Entity status code
        }

        // Create a new user and hash the password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  // Hash the password for security
        ]);

        // Return a JSON response indicating success
        return response()->json([
            'status' => true,  // Indicate that the operation was successful
            'message' => 'User Created Successfully',  // Success message
            'data' => $user,  // Include the created user data in the response
        ], 201);  // 201 Created status code for successful creation
    }

    /**
     * Handle user login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if validation failed
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Authentication Failed',  // Error message
                'errors' => $validateUser->errors()->all(),  // Include validation errors
            ], 422);  // 422 Unprocessable Entity status code
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();

            // Return a JSON response with the user's token
            return response()->json([
                'status' => true,  // Indicate that the operation was successful
                'message' => 'User Logged in Successfully',  // Success message
                'token' => $authUser->createToken('API Token')->plainTextToken,  // Include the token in the response
                'token_type' => 'bearer',  // Token type
            ], 200);  // 200 OK status code for a successful login
        } else {
            // Return a JSON response indicating authentication failure
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Email & Password does not Match',  // Error message
            ], 401);  // 401 Unauthorized status code for failed authentication
        }
    }

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Get the currently authenticated user
        $user = $request->user();

        // Revoke all of the user's tokens
        $user->tokens()->delete();

        // Return a JSON response indicating successful logout
        return response()->json([
            'status' => true,  // Indicate that the operation was successful
            'message' => 'You Logged Out Successfully',  // Success message
        ], 200);  // 200 OK status code for a successful logout
    }
}
