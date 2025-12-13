import Sortable from 'sortablejs';

export function initSortable() {
    const topicLists = document.querySelectorAll('[data-sortable="topics"]');

    topicLists.forEach(list => {
        const roadmapId = list.dataset.roadmapId;

        Sortable.create(list, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'bg-indigo-100',
            dragClass: 'opacity-50',

            onEnd: function(evt) {
                const topicIds = Array.from(list.children).map(el => el.dataset.topicId);

                fetch(`/roadmaps/${roadmapId}/topics/reorder`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ order: topicIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success toast
                        if (window.showToast) {
                            window.showToast('Topics reordered successfully!', 'success');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (window.showToast) {
                        window.showToast('Failed to reorder topics', 'error');
                    }
                });
            }
        });
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initSortable);
