function showComments(comments) {
    document.getElementById('commentsText').textContent = comments;
    document.getElementById('commentsModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('commentsModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('commentsModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}