    // Add event listeners to search inputs for Enter key press
    document.querySelectorAll('.search-box').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    });