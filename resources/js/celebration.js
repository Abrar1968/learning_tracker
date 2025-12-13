import confetti from 'canvas-confetti';

export function celebrate(milestone) {
    // Confetti animation
    confetti({
        particleCount: 100,
        spread: 70,
        origin: { y: 0.6 },
        colors: ['#667eea', '#764ba2', '#f093fb']
    });

    // Show milestone modal
    showMilestoneModal(milestone);
}

function showMilestoneModal(milestone) {
    const messages = {
        25: { emoji: '🚀', text: 'Great Start!', sub: "You're 25% there!" },
        50: { emoji: '🎯', text: 'Halfway There!', sub: "You're crushing it!" },
        75: { emoji: '💪', text: 'Almost Done!', sub: "The finish line is near!" },
        100: { emoji: '🎉', text: 'Complete!', sub: "You did it! Amazing work!" }
    };

    const msg = messages[milestone];

    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm';
    modal.innerHTML = `
        <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform scale-0 transition-transform duration-500" id="milestone-content">
            <div class="text-6xl mb-4">${msg.emoji}</div>
            <h2 class="text-3xl font-black text-gray-900 mb-2">${msg.text}</h2>
            <p class="text-xl text-gray-600 mb-4">${msg.sub}</p>
            <div class="text-5xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-6">
                ${milestone}%
            </div>
            <button onclick="this.closest('.fixed').remove()"
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-xl transition-all">
                Continue Learning!
            </button>
        </div>
    `;

    document.body.appendChild(modal);

    // Animate in
    setTimeout(() => {
        document.getElementById('milestone-content').style.transform = 'scale(1)';
    }, 10);

    // Auto-close after 5 seconds
    setTimeout(() => {
        modal.remove();
    }, 5000);
}

// Check for milestone on page load
document.addEventListener('DOMContentLoaded', () => {
    const milestone = document.querySelector('[data-milestone]')?.dataset.milestone;
    if (milestone) {
        setTimeout(() => celebrate(parseInt(milestone)), 500);
    }
});
