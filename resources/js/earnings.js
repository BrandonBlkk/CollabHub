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
    const withdrawButtons = document.querySelectorAll('button:contains("Withdraw")');
    withdrawButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Withdrawal feature would be implemented in a live application.');
        });
    });
});
