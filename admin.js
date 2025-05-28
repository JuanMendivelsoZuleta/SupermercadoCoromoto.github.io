
function loadContent(url) {
    const contentDiv = document.getElementById('main-content');
    contentDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando...</p></div>';

    fetch(url)
        .then(response => {
        if (!response.ok) throw new Error('Error al cargar el contenido.');
        return response.text();
        })
        .then(data => {
        contentDiv.innerHTML = data;
        })
        .catch(error => {
        contentDiv.innerHTML = '<div class="alert alert-danger">Hubo un error al cargar el contenido.</div>';
        console.error(error);
        });
    }


