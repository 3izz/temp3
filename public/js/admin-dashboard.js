// Admin Dashboard JavaScript

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar navigation links
    document.querySelectorAll('[data-section]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('data-section');
            showSection(sectionId);
        });
    });

    // Menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleSidebar);
    }
});

// Sidebar Navigation Logic
function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(sec => sec.classList.remove('active'));

    // Show target section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }

    // Update Active Link State
    const links = document.querySelectorAll('.nav-links a');
    links.forEach(link => link.classList.remove('active'));
    
    // Highlight current link
    const activeLink = document.getElementById('nav-' + sectionId);
    if(activeLink) {
        activeLink.classList.add('active');
    }

    // On mobile, close sidebar after selection
    if(window.innerWidth <= 768) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.remove('show');
        }
    }
}

// Mobile Menu Toggle
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        sidebar.classList.toggle('show');
    }
}

// Table Actions (Delete Row)
function deleteRow(btn) {
    if(confirm('Are you sure you want to delete this item?')) {
        const row = btn.closest('tr');
        if (row) {
            row.remove();
        }
    }
}

// Initialize Chart.js
document.addEventListener("DOMContentLoaded", function() {
    // Pie Chart: Student Distribution
    const pieChart = document.getElementById('pieChart');
    if (pieChart && typeof Chart !== 'undefined') {
        const pieCtx = pieChart.getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Web Dev', 'Data Science', 'Design', 'Marketing'],
                datasets: [{
                    data: [40, 25, 20, 15],
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    // Bar Chart: Enrolled Students
    const barChart = document.getElementById('barChart');
    if (barChart && typeof Chart !== 'undefined') {
        const barCtx = barChart.getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Enrollments',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: '#4f46e5',
                    borderRadius: 5
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Line Chart: Course Completion
    const lineChart = document.getElementById('lineChart');
    if (lineChart && typeof Chart !== 'undefined') {
        const lineCtx = lineChart.getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Completion Rate %',
                    data: [65, 59, 80, 81],
                    fill: true,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    }
});
