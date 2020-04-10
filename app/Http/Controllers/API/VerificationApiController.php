<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationApiController extends Controller
{
	use VerifiesEmails;
	/**
	 * Mark the authenticated user's email address as verified.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function verify(Request $request)
	{
		$userID = $request['id'];
		$user = User::findOrFail($userID);
		$date = date("Y-m-d g:i:s");
		$user->email_verified_at = $date; 
		$user->save();
		$user->greetingUser();
		return response()->json('Email verified!');
	}
	/**
	 * Resend the email verification notification.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function resend(Request $request)
	{

		$user = User::find($request->id);
		if ($user->email_verified_at) {
		return response()->json('User already have verified email!', 422);
	}
		$user->sendEmailVerificationNotification();
		return response()->json('The notification has been resubmitted');
	}


	/**
	 * change password.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function reset(Request $request)
	{
		$user = User::where('email', $request->email)->first();
		if ($user) {
			if($request['password'] == $request['confirm_password']){
				$user->update([
						'password'=> Hash::make($request['password']),
					]);
				return response()->json("You're password has been reset!", 200);
			}
			return response()->json('Confirmed password does not match the field password!', 304);
		}
		return response()->json('Enter Valid Email', 404);
	}


	public function verifyLink(Request $request)
	{
		$userID = $request->id;
		$user = User::find($userID);
        $user->sendApiEmailVerificationNotification();
        return response()->json([
        	'Verfication Email' => 'If you didn\'t receive any verification Email click http://pharmacy.test/api/email/resend/'.$userID,
        	'Data' => $user,
            ], 403);
	}
}
