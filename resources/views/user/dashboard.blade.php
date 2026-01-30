@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 20px auto; padding: 0 12px;">
    <h2 style="font-weight: 800; font-size: 22px; color:#0f2942; margin-bottom: 16px;">User Dashboard</h2>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('courses.index') }}" style="text-decoration:none;">
            <div style="border:1px solid rgba(15,41,66,0.12); border-radius: 12px; background:#fff; padding: 20px; text-align:center;">
                <div style="font-size: 32px; margin-bottom: 8px;">📚</div>
                <div style="font-weight: 700; color:#0f2942;">Courses</div>
            </div>
        </a>

        <a href="{{ route('chat.index') }}" style="text-decoration:none;">
            <div style="border:1px solid rgba(15,41,66,0.12); border-radius: 12px; background:#fff; padding: 20px; text-align:center;">
                <div style="font-size: 32px; margin-bottom: 8px;">💬</div>
                <div style="font-weight: 700; color:#0f2942;">Messages</div>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}" style="text-decoration:none;">
            <div style="border:1px solid rgba(15,41,66,0.12); border-radius: 12px; background:#fff; padding: 20px; text-align:center;">
                <div style="font-size: 32px; margin-bottom: 8px;">👤</div>
                <div style="font-weight: 700; color:#0f2942;">Profile</div>
            </div>
        </a>
    </div>
</div>
@endsection
