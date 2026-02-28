// Simple chart hover effect
document.addEventListener('DOMContentLoaded', function() {
    const bars = document.querySelectorAll('[style*="height"]');
    bars.forEach(bar => {
        bar.addEventListener('mouseover', function() {
            this.classList.add('opacity-80');
        });
        bar.addEventListener('mouseout', function() {
            this.classList.remove('opacity-80');
        });
    });

    // Withdrawal buttons
    const withdrawMessage = document.querySelector('[data-withdraw-message]')?.dataset?.withdrawMessage ||
        'Withdrawal feature would be implemented in a live application.';
    const withdrawButtons = document.querySelectorAll('[data-withdraw-action]');
    withdrawButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert(withdrawMessage);
        });
    });
});
