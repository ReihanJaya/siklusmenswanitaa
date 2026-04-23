<x-app-layout>
    <div class="flex flex-col h-[calc(100vh-8rem)]">
        <!-- Header -->
        <div class="mb-3 flex-shrink-0 flex items-center shadow-lg p-4 rounded-3xl bg-gradient-to-r from-pink-500 via-rose-500 to-purple-600 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-pink-600/20 to-purple-600/20 animate-pulse"></div>
            <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center font-bold text-xl mr-4 shadow-inner relative z-10 border border-white/20">
                <img src="https://api.dicebear.com/9.x/bottts/svg?seed=Ameng&backgroundColor=ffb8b8" alt="Ameng" class="w-10 h-10 object-cover rounded-xl">
            </div>
            <div class="relative z-10">
                <h2 class="text-xl font-extrabold flex items-center gap-2">
                    Ameng AI 
                    <span class="bg-white/20 text-[9px] px-2.5 py-0.5 rounded-full backdrop-blur-sm font-bold uppercase tracking-wider">Beta</span>
                </h2>
                <p class="text-xs text-pink-100 mt-0.5">Asisten virtual pribadimu 💕</p>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 overflow-y-auto bg-transparent p-1 mb-3 space-y-4 scroll-smooth scrollbar-hide" id="chat-window">
            
            <!-- Bot Greeting -->
            <div class="flex items-start animate-slide-up">
                <div class="flex-shrink-0 mr-3">
                    <div class="bg-gradient-to-tr from-pink-400 to-primary text-white rounded-2xl w-9 h-9 flex items-center justify-center shadow-md overflow-hidden">
                        <img src="https://api.dicebear.com/9.x/bottts/svg?seed=Ameng&backgroundColor=ffb8b8" alt="Ameng" class="w-7 h-7 object-cover">
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl rounded-tl-none p-4 max-w-[85%] text-sm text-gray-700 dark:text-gray-200 shadow-sm border border-pink-50 dark:border-gray-700">
                    <p class="font-semibold text-primary mb-1">Halo, aku Ameng! Siap bantu kamu 😊</p>
                    <p class="text-gray-500 text-xs leading-relaxed">Ada keluhan atau mau tanya-tanya soal kesehatan hari ini? Ketik pertanyaanmu atau pilih topik di bawah!</p>
                </div>
            </div>

            <!-- Quick Replies -->
            <div class="flex overflow-x-auto gap-2 mt-3 pb-2 scrollbar-hide -mx-1 px-1" id="quick-replies">
                <button onclick="sendUserMsg('Apa itu PMS?')" class="flex-shrink-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-pink-200 dark:border-gray-600 text-pink-600 dark:text-pink-400 text-xs font-semibold py-2.5 px-4 rounded-2xl hover:bg-pink-50 transition shadow-sm active:scale-95">🤔 Apa itu PMS?</button>
                <button onclick="sendUserMsg('Bagaimana menghitung masa subur?')" class="flex-shrink-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-purple-200 dark:border-gray-600 text-purple-600 dark:text-purple-400 text-xs font-semibold py-2.5 px-4 rounded-2xl hover:bg-purple-50 transition shadow-sm active:scale-95">📅 Hitung Masa Subur</button>
                <button onclick="sendUserMsg('Obat alami sakit perut bawah?')" class="flex-shrink-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-red-200 dark:border-gray-600 text-red-600 dark:text-red-400 text-xs font-semibold py-2.5 px-4 rounded-2xl hover:bg-red-50 transition shadow-sm active:scale-95">💊 Obat Nyeri Alami</button>
                <button onclick="sendUserMsg('Telat haid 5 hari normalkah?')" class="flex-shrink-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-blue-200 dark:border-gray-600 text-blue-600 dark:text-blue-400 text-xs font-semibold py-2.5 px-4 rounded-2xl hover:bg-blue-50 transition shadow-sm active:scale-95">⏳ Telat Haid Normal?</button>
                <button onclick="sendUserMsg('Apa itu keputihan?')" class="flex-shrink-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-teal-200 dark:border-gray-600 text-teal-600 dark:text-teal-400 text-xs font-semibold py-2.5 px-4 rounded-2xl hover:bg-teal-50 transition shadow-sm active:scale-95">🩺 Keputihan</button>
                <button onclick="sendUserMsg('Cara mengatasi mood swing?')" class="flex-shrink-0 bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-amber-200 dark:border-gray-600 text-amber-600 dark:text-amber-400 text-xs font-semibold py-2.5 px-4 rounded-2xl hover:bg-amber-50 transition shadow-sm active:scale-95">🎭 Mood Swing</button>
            </div>
        </div>

        <!-- Input Area -->
        <div class="flex-shrink-0 flex items-center bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-pink-100 dark:border-gray-700 p-1.5">
            <input type="text" id="chat-input" placeholder="Tanya soal haid, nyeri, atau kesehatan..." class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-3 px-4 dark:text-white placeholder-gray-400" autocomplete="off">
            <button onclick="handleSend()" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-xl w-11 h-11 flex items-center justify-center shadow-md transition active:scale-90 hover:shadow-lg flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
            </button>
        </div>
    </div>

    <script>
        const chatWindow = document.getElementById('chat-window');
        const chatInput = document.getElementById('chat-input');
        const quickReplies = document.getElementById('quick-replies');

        function scrollToBottom() {
            chatWindow.scrollTo({ top: chatWindow.scrollHeight, behavior: 'smooth' });
        }

        function appendUserMsg(msg) {
            chatWindow.innerHTML += `
            <div class="flex items-start justify-end mt-3 animate-slide-up">
                <div class="bg-gradient-to-r from-purple-500 to-primary text-white rounded-2xl rounded-tr-none p-3.5 max-w-[85%] text-sm shadow-md font-medium">
                    ${msg}
                </div>
            </div>`;
            scrollToBottom();
        }

        function showTyping() {
            const typingId = 'typing-' + Date.now();
            chatWindow.innerHTML += `
            <div class="flex items-start mt-3" id="${typingId}">
                <div class="flex-shrink-0 mr-3">
                    <div class="bg-gradient-to-tr from-pink-400 to-primary text-white rounded-2xl w-9 h-9 flex items-center justify-center shadow overflow-hidden">
                        <img src="https://api.dicebear.com/9.x/bottts/svg?seed=Ameng&backgroundColor=ffb8b8" alt="Ameng" class="w-7 h-7 object-cover">
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl rounded-tl-none p-3.5 text-sm text-gray-500 shadow-sm border border-pink-50 dark:border-gray-700">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>`;
            scrollToBottom();
            return typingId;
        }

        function appendBotMsg(msg, typingId) {
            if (typingId) {
                const el = document.getElementById(typingId);
                if (el) el.remove();
            }
            chatWindow.innerHTML += `
            <div class="flex items-start mt-3 animate-slide-up">
                <div class="flex-shrink-0 mr-3">
                    <div class="bg-gradient-to-tr from-pink-400 to-primary text-white rounded-2xl w-9 h-9 flex items-center justify-center shadow overflow-hidden">
                        <img src="https://api.dicebear.com/9.x/bottts/svg?seed=Ameng&backgroundColor=ffb8b8" alt="Ameng" class="w-7 h-7 object-cover">
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl rounded-tl-none p-3.5 max-w-[85%] text-sm text-gray-700 dark:text-gray-200 shadow-sm border border-pink-50 dark:border-gray-700 leading-relaxed">
                    ${msg}
                </div>
            </div>`;
            scrollToBottom();
        }

        function processBotAnswer(msg) {
            const lowerM = msg.toLowerCase();
            let reply = "Waduh, aku belum punya jawaban pasti soal itu nih 🤔 Karena setiap tubuh itu unik, mending sekalian konsultasi ke dokter spesialis ya biar lebih tenang! 😊";
            
            if (lowerM.includes('pms')) {
                reply = "PMS (Sindrom Pra-Haid) itu paket lengkap gejala: perut kram, <b>mood swing</b>, payudara nyeri, sampai jerawat menjelang haid. Wajar banget kok! 💗<br><br>Tips: Perbanyak air putih, tidur cukup, dan sediakan coklat hitam favorit! 🍫";
            } else if (lowerM.includes('subur') || lowerM.includes('ovulasi') || lowerM.includes('hitung')) {
                reply = "Gampang! Biasanya <b>masa subur</b> terjadi 12-16 hari sebelum menstruasi berikutnya. 📅<br><br>Siklus kamu 28 hari? Berarti ovulasi sekitar <b>hari ke-14</b>. Masa subur di hari ke-9 sampai ke-15.<br><br>Cek tab <b>Kalender</b> kamu deh, sudah aku hitung otomatis! ✨";
            } else if (lowerM.includes('nyeri') || lowerM.includes('sakit') || lowerM.includes('obat') || lowerM.includes('kram')) {
                reply = "Duh kram perut ya? 😣 Coba ini:<br><br>🔥 Kompres air hangat di perut bawah<br>🧘‍♀️ Tiduran posisi fetal (melingkar)<br>☕ Teh chamomile hangat<br>🍫 Dark chocolate (mengandung magnesium)<br>💊 Paracetamol jika perlu<br><br>Kalau sakitnya sampai pingsan, segera ke dokter ya!";
            } else if (lowerM.includes('telat') || lowerM.includes('normal')) {
                reply = "Siklus normal itu berkisar <b>21-35 hari</b>. Kalau telat 5-7 hari dari biasanya, itu masih tahap normal kok (bisa karena stres atau lelah). 😊<br><br>Tapi kalau sudah lebih dari <b>3 bulan</b> gak haid, waktunya cek ke Obgyn ya! 🩺";
            } else if (lowerM.includes('keputihan') || lowerM.includes('putih')) {
                reply = "Keputihan itu normal kok! Cairan vagina berfungsi menjaga kelembaban dan kebersihan. 🩺<br><br><b>Normal:</b> Bening/putih, tidak berbau<br><b>Waspada:</b> Kuning/hijau, gatal, bau menyengat<br><br>Kalau terasa tidak normal, segera konsultasi ke dokter kandungan ya!";
            } else if (lowerM.includes('mood') || lowerM.includes('swing') || lowerM.includes('emosi')) {
                reply = "Mood swing saat PMS itu karena fluktuasi hormon estrogen & progesteron 🎭<br><br>Tips mengatasinya:<br>😴 Tidur cukup 7-8 jam<br>🏃‍♀️ Olahraga ringan (jalan kaki/yoga)<br>🥗 Makan teratur & seimbang<br>🧘‍♀️ Meditasi atau deep breathing<br>🍵 Hindari kafein berlebih";
            } else if (lowerM.includes('kapan') || lowerM.includes('haid') && lowerM.includes('pertama')) {
                reply = "Haid pertama (menarche) biasanya terjadi di usia <b>10-16 tahun</b>, rata-rata sekitar 12 tahun. Setiap orang berbeda-beda ya! 🌸<br><br>Tanda-tanda akan datang: tumbuh payudara, rambut ketiak/kemaluan, dan keputihan.";
            } else if (lowerM.includes('kb') || lowerM.includes('kontrasepsi') || lowerM.includes('pil')) {
                reply = "Ada banyak metode KB yang tersedia 💊<br><br>📋 <b>Pil KB:</b> Diminum setiap hari, sangat efektif<br>💉 <b>Suntik KB:</b> Setiap 1-3 bulan<br>📎 <b>IUD/Spiral:</b> Jangka panjang 3-10 tahun<br>💪 <b>Implan:</b> Ditanam di lengan, 3 tahun<br><br>Konsultasikan dengan dokter untuk metode terbaik untukmu! 🩺";
            } else if (lowerM.includes('halo') || lowerM.includes('hai') || lowerM.includes('hi') || lowerM.includes('hey')) {
                reply = "Halooo! 👋😊 Aku Ameng, asisten kesehatanmu! Ada yang bisa aku bantu hari ini? Silakan tanya soal haid, kesehatan reproduksi, atau tips-tips seputar siklus menstruasi ya! 💕";
            } else if (lowerM.includes('terima kasih') || lowerM.includes('makasih') || lowerM.includes('thanks')) {
                reply = "Sama-sama! 💕 Senang bisa membantu kamu. Jangan ragu tanya lagi kalau ada yang ingin kamu ketahui ya! Jaga kesehatan selalu 🌸😊";
            }

            const typingId = showTyping();
            setTimeout(() => {
                appendBotMsg(reply, typingId);
            }, 1200);
        }

        function sendUserMsg(msg) {
            if (quickReplies) quickReplies.style.display = 'none';
            appendUserMsg(msg);
            processBotAnswer(msg);
        }

        function handleSend() {
            const val = chatInput.value.trim();
            if (!val) return;
            chatInput.value = '';
            sendUserMsg(val);
        }

        chatInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') handleSend();
        });
    </script>
</x-app-layout>
