function loadContent(url) {
  fetch(url)
    .then(res => res.text())
    .then(html => {
      document.getElementById('main-content').innerHTML = html;
    });
}

