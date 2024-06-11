<?php

namespace App\Http\Controllers\Api;

use App\Helpers\TranslateTextHelper;
use App\Http\Controllers\Controller;
use App\Models\AddUser;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getPublicUsers()
    {
        $users = User::where('id', '!=', Auth::id())->where('account_type', 'public')->where('role', '0')->get();
        if ($users) {
            return response()->json([
                'status' => true,
                'public_users' =>  $users,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not data found",
            ], 200);
        }
    }
    public function incomingRequests()
    {
        $user = Auth::user();
        $incomingRequests = FriendRequest::where('receiver_id', $user->id)->where('status', 'pending')->with('sender')->get();
        if ($incomingRequests) {
            return response()->json([
                'status' => true,
                'incoming_requests' => $incomingRequests,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not data found",
            ], 200);
        }
    }

    public function sendFriendRequest(Request $request)
    {
        $senderId = Auth::id();
        
        $receiverId = $request->input('receiver_id');

        // Validate receiver_id
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);
        
        $reciever=User::findOrFail($receiverId);

        // Check if a pending request already exists
        $existingRequest = FriendRequest::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'status' => false,
                'message' => 'Friend request already exists.',
            ], 200);
        }

        // Check if a rejected request exists
        $rejectedRequest = FriendRequest::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->where('status', 'rejected')
            ->first();

        if ($rejectedRequest) {
            // Update the rejected request to pending
            $rejectedRequest->update(['status' => 'pending']);
            if ($reciever->sub_id) {
                $userIds = [$reciever->sub_id];
            } else {
                $userIds = [];
            }
            // App::setLocale($reciever->language);
            $message = "You have a new friend request!";
            $targetLanguage = $reciever->language ?? 'en';
            TranslateTextHelper::setSource('en')->setTarget($targetLanguage);
            $message = TranslateTextHelper::translate($message);
            if (!empty($message) && !empty($userIds)) {
                $result = $this->onesignal($message, $userIds);
            }
            return response()->json([
                'status' => true,
                'message' => 'Friend request sent successfully!',
            ], 200);
        }

        // Create a new friend request
        FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);
        if ($reciever->sub_id) {
            $userIds = [$reciever->sub_id];
        } else {
            $userIds = [];
        }
        $message = "You have a new friend request!";
        $targetLanguage = $reciever->language ?? 'en';
        TranslateTextHelper::setSource('en')->setTarget($targetLanguage);
        $message = TranslateTextHelper::translate($message);
        if (!empty($message) && !empty($userIds)) {
            $result = $this->onesignal($message, $userIds);
        }
        return response()->json([
            'status' => true,
            'message' => 'Friend request sent successfully!',
        ], 200);
    }

    public function acceptFriendRequest($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);
        if ($friendRequest->receiver_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $friendRequest->update(['status' => 'accepted']);
    
        $authUser = Auth::user();
        $friendUser = User::findOrFail($friendRequest->sender_id);
    
        // Attach friends to each other
        $authUser->friends()->attach($friendRequest->sender_id);
        $friendUser->friends()->attach($authUser->id);
    
        // Add friend to AddUser model if not already added
        if (!AddUser::where('user_id', $authUser->id)->where('email', $friendUser->email)->exists()) {
            $addUser = new AddUser();
            $addUser->user_id = $authUser->id;
            $addUser->first_name = $friendUser->name; // Assuming name is the first name
            $addUser->email = $friendUser->email;
            $addUser->registered_user = $authUser->name;
            $addUser->save();
        }
    
        // Add auth user to AddUser model if not already added
        if (!AddUser::where('user_id', $friendUser->id)->where('email', $authUser->email)->exists()) {
            $addUser = new AddUser();
            $addUser->user_id = $friendUser->id;
            $addUser->first_name = $authUser->name; // Assuming name is the first name
            $addUser->email = $authUser->email;
            $addUser->registered_user = $friendUser->name;
            $addUser->save();
        }
    
        return response()->json(['message' => 'Friend request accepted successfully!']);
    }

    public function rejectFriendRequest($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);
        if ($friendRequest->receiver_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $friendRequest->update(['status' => 'rejected']);

        return response()->json(['message' => 'Friend request rejected successfully!']);
    }

    public function getFriends()
    {
        $friends = Auth::user()->friends;

        if ($friends) {
            return response()->json([
                'status' => true,
                'friends' => $friends,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Not data found",
            ], 200);
        }
    }
}
