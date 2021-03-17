<?php

namespace App\Observers;
use App\Models\User;

class UserObserver
{
    public function updating(User $user)
    {

    	if($user->isDirty('email'))
    	{
        	// email has changed
	        $new_email = $user->email; 
	        $old_email = $user->getOriginal('email');
	    }
	    
        // $user->first_name = $user->first_name;
        // $user->last_name = $user->last_name;
        // $user->mobile = $user->mobile;
        // $user->email = $user->email;
        // $user->profile_pic = $user->profile_pic;
        // $user->status = $user->status;
        // $user->source = $user->source;
    }

    // updated
}
