@extends('layouts.app')

@section('content')
<div class="chat-container">
    <h1 class="chat-header">Chat with {{ $customer->name }}</h1>

    <!-- Chat Messages -->
    <div class="chat-box">
        @foreach($chats as $chat)
            <div class="chat-message {{ $chat->is_admin == 1 ? 'sent' : 'received' }}">
                <div class="message-content">
                    <p class="chat-text">{{ $chat->text }}</p>

                    {{-- Display images --}}
                    @if ($chat->images)
                        @foreach (json_decode($chat->images, true) as $image)
                            <img src="{{ asset('images/' . $image) }}" alt="Chat Image" class="chat-image">
                        @endforeach
                    @endif

                    {{-- Display audios --}}
                    @if ($chat->audios)
                        @foreach (json_decode($chat->audios, true) as $audio)
                            <audio controls class="chat-audio">
                                <source src="{{ asset('audios/' . $audio) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        @endforeach
                    @endif
                </div>
                <span class="chat-time">{{ $chat->created_at->format('H:i') }}</span>
            </div>
        @endforeach
    </div>


    <!-- Send Message -->
    <form action="{{ route('chats.store') }}" method="POST" enctype="multipart/form-data" class="send-message-form">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
        <textarea name="text" placeholder="Type your message..." required class="message-input"></textarea>
        <input type="file" name="images[]" multiple class="file-input">
        <button type="submit" class="send-btn">Send</button>
    </form>
</div>
@endsection

@section('styles')
<style>
    /* Chat container styling */
    .chat-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border-radius: 8px;
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    /* Header styling */
    .chat-header {
        margin-bottom: 20px;
        text-align: center;
        font-size: 24px;
        color: #333;
    }

    /* Chat box */
    .chat-box {
        max-height: 400px;
        overflow-y: auto;
        background: #ffffff;
        padding: 10px;
        border-radius: 8px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    /* Chat message styles */
    .chat-message {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
        max-width: 70%;
        border-radius: 10px;
        padding: 10px;
        position: relative;
    }

    .chat-message.sent {
        align-self: flex-end;
        background-color: #dcf8c6;
    }

    .chat-message.received {
        align-self: flex-start;
        background-color: #f1f0f0;
    }

    .chat-text {
        font-size: 14px;
        margin: 0 0 5px;
        color: #333;
    }

    .chat-image {
        max-width: 100px;
        margin-top: 5px;
        border-radius: 5px;
    }

    .chat-time {
        font-size: 10px;
        color: #888;
        position: absolute;
        bottom: 5px;
        right: 10px;
    }

    /* Send message form */
    .send-message-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .message-input {
        flex-grow: 1;
        height: 40px;
        border-radius: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
        outline: none;
    }

    .file-input {
        width: 120px;
    }

    .send-btn {
        background-color: #25d366;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
    }

    .send-btn:hover {
        background-color: #128c7e;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .chat-container {
            padding: 15px;
        }

        .chat-message {
            max-width: 85%;
        }

        .message-input {
            font-size: 12px;
        }

        .send-btn {
            font-size: 12px;
            padding: 8px 15px;
        }
    }
    .chat-image {
    max-width: 100px; /* Set maximum width */
    max-height: 100px; /* Set maximum height */
    width: auto; /* Maintain aspect ratio */
    height: auto; /* Maintain aspect ratio */
    margin-top: 5px;
    border-radius: 5px; /* Optional: Add rounded corners */
    object-fit: cover; /* Ensures the image fits well within the dimensions */
}

</style>
@endsection
