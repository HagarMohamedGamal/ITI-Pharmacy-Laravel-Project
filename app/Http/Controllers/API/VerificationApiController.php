<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

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
	public function verify(Request $request) {
		$userID = $request['id'];
		$user = User::findOrFail($userID);
		$date = date("Y-m-d g:i:s");
		$user->email_verified_at = $date; 
		$user->save();
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
		// return redirect($this->redirectPath());
	}
		$user->sendEmailVerificationNotification();
		return response()->json('The notification has been resubmitted');
		// return back()->with('resent', true);
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
