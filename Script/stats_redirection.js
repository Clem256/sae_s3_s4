document.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.getElementById('category_stats_select');

    if (categorySelect) {
        categorySelect.addEventListener('change', () => {
            const selectedCategory = categorySelect.value;
            window.location.href = `get_content.php?category=statistiques&category_stats_select=${encodeURIComponent(selectedCategory)}`;
        });
    }
});