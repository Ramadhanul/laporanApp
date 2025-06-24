<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Informasi Mutasi Barang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #e6f1ff;
            color: #333;
        }

        .header {
            background-color: #2e86de;
            padding: 1rem 2rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .chat-container {
            max-width: 800px;
            margin: 30px auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: #d1e7dd;
            padding: 1rem 1.5rem;
            font-weight: bold;
            font-size: 1.1rem;
            border-bottom: 1px solid #ccc;
        }

        .chat-box {
            height: 450px;
            overflow-y: auto;
            padding: 1rem 1.5rem;
            background: #f8fbfd;
            display: flex;
            flex-direction: column;
        }

        .bubble {
            max-width: 75%;
            padding: 0.75rem 1rem;
            margin: 0.5rem 0;
            border-radius: 16px;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .bot-msg {
            align-self: flex-start;
            background: #d1e7dd;
            border-top-left-radius: 0;
        }

        .user-msg {
            align-self: flex-end;
            background: #cfe2ff;
            border-top-right-radius: 0;
        }

        .chat-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #ddd;
            background: #f1f6f9;
        }

        .chat-footer form {
            display: flex;
            gap: 10px;
        }

        .chat-footer input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .chat-footer button {
            background: #2e86de;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .chat-footer button:hover {
            background: #1b4f8a;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #2e86de;
            display: inline-block;
            margin-right: 10px;
        }

        .bot-avatar {
            background-image: url('https://img.icons8.com/color/48/doctor-male.png');
            background-size: cover;
        }

        .user-avatar {
            background-image: url('https://img.icons8.com/color/48/user.png');
            background-size: cover;
        }

        .bubble-container {
            display: flex;
            align-items: flex-start;
        }

        .bubble-container.user {
            justify-content: flex-end;
        }

        .bubble-container.bot {
            justify-content: flex-start;
        }
    </style>
</head>
<body>

<header style="background-color: #2e86de; padding: 1rem 2rem; color: white; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
    <div style="font-size: 1.5rem; font-weight: bold;" class="d-flex align-items-center">
        <img src="{{ asset('img/logoyarsi.png') }}" alt="Logo RS" height="36" class="me-2">
        MUTASI BARANG YARSISUMBAR
    </div>

    <nav style="display: flex; gap: 1.5rem; margin-top: 0.5rem;">
        <a href="{{ route('public.index') }}" style="color: white; text-decoration: none; font-weight: {{ request()->is('public') ? '600' : '400' }}">Dashboard</a>
        <a href="{{ route('public.data') }}" style="color: white; text-decoration: none; font-weight: {{ request()->is('public/data') ? '600' : '400' }}">Data</a>
        <a href="{{ route('public.chatbot') }}" style="color: white; text-decoration: none; font-weight: {{ request()->is('public/chatbot') ? '600' : '400' }}">Chatbot</a>
    </nav>
</header>

    <div class="chat-container">
        <div class="chat-header">Asisten Virtual RS - Chatbot Mutasi Barang</div>

        <div id="chat-box" class="chat-box">
            {{-- Pesan akan ditambahkan lewat JS --}}
        </div>

        <div class="chat-footer">
            <form id="chat-form">
                <input type="text" id="question" placeholder="Tanyakan sesuatu..." required>
                <button type="submit">Kirim</button>
            </form>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('question');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const question = input.value.trim();
            if (!question) return;

            appendMessage(question, 'user');
            input.value = '';
            input.disabled = true;

            try {
                const res = await fetch("{{ route('public.chatbot.ask') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ question })
                });

                const data = await res.json();
                appendMessage(data.reply, 'bot');
            } catch (err) {
                appendMessage("⚠️ Maaf, server tidak merespons.", 'bot');
            } finally {
                input.disabled = false;
            }
        });

        function appendMessage(text, type) {
            const container = document.createElement('div');
            container.className = `bubble-container ${type}`;

            const avatar = document.createElement('div');
            avatar.className = `avatar ${type === 'bot' ? 'bot-avatar' : 'user-avatar'}`;

            const bubble = document.createElement('div');
            bubble.className = `bubble ${type}-msg`;
            bubble.innerText = text;

            container.appendChild(avatar);
            container.appendChild(bubble);
            chatBox.appendChild(container);

            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
</body>
</html>
