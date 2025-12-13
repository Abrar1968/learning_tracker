import Chart from 'chart.js/auto';

// Progress Timeline Chart
export function initProgressChart(canvasId, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    const labels = Object.keys(data);
    const values = Object.values(data);

    // Show placeholder if no data
    if (labels.length === 0) {
        ctx.parentElement.innerHTML = `
            <div class="flex items-center justify-center h-full">
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="mt-2 text-gray-500 text-sm">No activity in the last 30 days</p>
                    <p class="text-gray-400 text-xs">Complete some topics to see your progress!</p>
                </div>
            </div>
        `;
        return;
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Topics Completed',
                data: values,
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Learning Progress (Last 30 Days)',
                    font: { size: 16, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
}

// Time Distribution Chart
export function initTimeDistributionChart(canvasId, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    const labels = Object.keys(data);
    const values = Object.values(data);

    if (labels.length === 0) {
        ctx.parentElement.innerHTML = `
            <div class="flex items-center justify-center h-full">
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="mt-2 text-gray-500 text-sm">No time tracked yet</p>
                    <p class="text-gray-400 text-xs">Start learning to see your time distribution!</p>
                </div>
            </div>
        `;
        return;
    }

    const colors = [
        'rgba(99, 102, 241, 0.8)',
        'rgba(168, 85, 247, 0.8)',
        'rgba(236, 72, 153, 0.8)',
        'rgba(251, 146, 60, 0.8)',
        'rgba(34, 197, 94, 0.8)',
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#fff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                title: {
                    display: true,
                    text: 'Time Distribution by Roadmap (Hours)',
                    font: { size: 16, weight: 'bold' }
                }
            }
        }
    });
}

// Completion Funnel Chart
export function initCompletionFunnelChart(canvasId, data) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Topics',
                data: data.data,
                backgroundColor: [
                    'rgba(156, 163, 175, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                ],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Completion Funnel',
                    font: { size: 16, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

// Initialize all charts
export function initAllCharts(chartData) {
    if (chartData.progressTimeline && Object.keys(chartData.progressTimeline).length > 0) {
        initProgressChart('progressChart', chartData.progressTimeline);
    }
    if (chartData.timeDistribution && Object.keys(chartData.timeDistribution).length > 0) {
        initTimeDistributionChart('timeChart', chartData.timeDistribution);
    }
    if (chartData.completionFunnel) {
        initCompletionFunnelChart('funnelChart', chartData.completionFunnel);
    }
}
