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
	 * Show the email verification notice.
	 *
	 */
	public function show()
	{
		//
	}
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
		$user->email_verified_at = $date; // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
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
		if ($request->user()->hasVerifiedEmail()) {
			return response()->json('User already have verified email!', 422);
			// return redirect($this->redirectPath());
		}
		$request->user()->sendEmailVerificationNotification();
		return response()->json('The notification has been resubmitted');
		// return back()->with('resent', true);
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
}
