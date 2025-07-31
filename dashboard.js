// ========== FUNCTION THAT SHOWS COMMENTS TO ADMIN DASHBOARD IF COMMENTS ARRAY IS NOT EMPTY ================= //
function showComments(comments) {
    document.getElementById('commentsText').textContent = comments;
    document.getElementById('commentsModal').style.display = 'block';
}

// =========== FUNCTION THAT LETS USER TO CLOSE MESSAGE WHEN PRESSED X OR OUTSIDE =================== //
function closeModal() {
    document.getElementById('commentsModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('commentsModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}