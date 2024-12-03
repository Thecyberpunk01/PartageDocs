document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', () => {
        const filter = button.getAttribute('data-filter');
        const courseCards = document.querySelectorAll('.course-card');

        courseCards.forEach(card => {
            if (filter === 'all' || card.getAttribute('data-level') === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        document.querySelector('.filter-btn.active').classList.remove('active');
        button.classList.add('active');
    });
});
