document.addEventListener('DOMContentLoaded', function() {
    // Open image in a modal (lightbox)
    const modal = document.querySelector('.gallery-modal');
    const modalImg = modal?.querySelector('img');
    const modalCaption = modal?.querySelector('.caption');
    const closeBtn = modal?.querySelector('.close');

    // Use .photo-image class instead of .photo-card img
    document.querySelectorAll('.photo-image').forEach(img => {
        img.addEventListener('click', (e) => {
            if (!modal) return;
            e.stopPropagation();
            modalImg.src = img.dataset.full || img.src;
            modalCaption.textContent = img.alt || '';
            modal.classList.add('active');
        });
    });

    function closeModal() {
        if (modal) modal.classList.remove('active');
    }

    if (closeBtn) closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        closeModal();
    });
    if (modal) modal.addEventListener('click', (ev) => {
        if (ev.target === modal) closeModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });
});
