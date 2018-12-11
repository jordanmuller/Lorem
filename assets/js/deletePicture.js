document.querySelectorAll('[data-delete]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        fetch(link.getAttribute('href'), {
            // Define Ajax request, headers and body, we have to send the token to AdminPictureController
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({'_token': link.dataset.token})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // On récupère le parent du parent du lien pour supprimer le parent du lien
                    link.parentNode.parentNode.removeChild(link.parentNode)
                } else {
                    alert(data.error);
                }
            })
            .catch(e => alert(e));
    });
});