@include('navbar')
@extends('layouts.app')

@section('content')
 
<div x-data="chatIndex()" x-init="init()" style="max-width: 1200px; margin: 20px auto; padding: 0 12px;">
    <h2 style="font-weight: 800; font-size: 22px; color:#0f2942; margin-bottom: 16px;">Messages</h2>

    @if($conversations->isEmpty())
        <div style="text-align:center; padding: 40px; background:#fff; border-radius:12px; border:1px solid rgba(15,41,66,0.12);">
            <div style="color:#6b7280; font-size: 16px; margin-bottom: 8px;">No conversations yet.</div>
            <div style="color:#9ca3af; font-size: 14px;">
                @if(auth()->user()->role === 'user')
                    Start a conversation with a coach.
                @else
                    Wait for users to start conversations with you.
                @endif
            </div>
        </div>
    @else
        <div style="display:grid; grid-template-columns: 320px 1fr; gap: 16px; height: 540px;">
            <!-- Conversations list -->
            <div style="border:1px solid rgba(15,41,66,0.12); border-radius: 12px; background:#fff; overflow-y:auto;">
                <div style="padding: 12px 14px; border-bottom:1px solid rgba(15,41,66,0.06); font-weight: 600; font-size: 14px; color:#0f2942;">
                    Conversations
                </div>
                @foreach($conversations as $conv)
                    <a href="{{ route('chat.show', $conv->id) }}"
                       style="display:flex; align-items:center; gap:12px; padding: 12px 14px; text-decoration:none; color: inherit; border-bottom:1px solid rgba(15,41,66,0.06); transition:background-color 0.2s; {{ request()->route('user')?->id == $conv->id ? 'background:#eff6ff;' : '' }}"
                       onmouseover="this.style.backgroundColor='{{ request()->route('user')?->id != $conv->id ? '#f9fafb' : '#eff6ff' }}'"
                       onmouseout="this.style.backgroundColor='{{ request()->route('user')?->id == $conv->id ? '#eff6ff' : 'transparent' }}'">
                        <div style="position: relative;">
                            <img src="{{ $conv->profile_photo_url }}" alt="{{ $conv->name }}" style="width:44px; height:44px; border-radius:50%; object-fit:cover; border:1px solid rgba(15,41,66,0.1);" />
                             
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight: 700; font-size: 15px; color:#0f2942;">{{ $conv->name }}</div>
                            <div style="font-size: 13px; color:#6b7280; display:flex; align-items:center; gap:4px;">
                                <span>{{ $conv->role }}</span>
                                 
                            </div>
                        </div>
                        <div style="font-size: 11px; color:#9ca3af;">
                            {{ now()->format('H:i') }}
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Chat area (placeholder) -->
            <div style="border:1px solid rgba(15,41,66,0.12); border-radius: 12px; background:#fff; display:flex; align-items:center; justify-content:center; color:#6b7280; font-size: 15px;">
                <div style="text-align:center;">
                    <div style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;">💬</div>
                    <div style="font-weight: 600; margin-bottom: 8px;">Select a conversation</div>
                    <div style="font-size: 14px;">Choose a conversation from the list to start messaging</div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function chatIndex() {
    return {
        init() {
            // You can add real-time updates here if needed
            console.log('Chat index initialized');
        }
    }
}
</script>
@include('footer')
@endsection
