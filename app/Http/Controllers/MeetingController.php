<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function create(Request $request)
    {
        // Authenticate user
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        // Generate unique meeting ID
        $meetingId = Str::uuid();
        
        // Create meeting record
        $meeting = Meeting::create([
            'meeting_id' => $meetingId,
            'user_id' => auth()->id(),
            'title' => $request->input('title'),
            'password' => Str::random(8),
            'expires_at' => now()->addHours(2),
        ]);
        
        return redirect()->route('meeting.join', $meetingId);
    }
    
    public function join($meetingId)
    {
        $meeting = Meeting::where('meeting_id', $meetingId)->firstOrFail();
        
        // Authorization check
        if (!auth()->check() || !$this->userCanJoin(auth()->user(), $meeting)) {
            abort(403);
        }
        
        // Generate JWT token for secure Jitsi authentication
        $jwtToken = $this->generateJitsiJWT(auth()->user(), $meeting);
        
        return view('meeting.join', [
            'meeting' => $meeting,
            'jwtToken' => $jwtToken,
        ]);
    }
    
    protected function userCanJoin($user, $meeting)
    {
        // Implement your authorization logic
        return $user->id === $meeting->user_id 
            || $user->hasPermission('join_any_meeting')
            || $meeting->participants->contains($user->id);
    }
    
    protected function generateJitsiJWT($user, $meeting)
    {
        $payload = [
            'context' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar_url,
                ],
                'features' => [
                    'recording' => false,
                    'livestreaming' => false,
                    'screen-sharing' => true,
                ]
            ],
            'aud' => 'jitsi',
            'iss' => config('services.jitsi.app_id'),
            'sub' => config('services.jitsi.domain'),
            'room' => $meeting->meeting_id,
            'exp' => time() + 3600, // 1 hour expiration
            'moderator' => $user->id === $meeting->user_id,
        ];
        
        return JWT::encode($payload, config('services.jitsi.secret_key'), 'HS256');
    }
}
