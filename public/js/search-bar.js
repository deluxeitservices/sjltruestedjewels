document.querySelectorAll('.searchToggle').forEach(toggle => {
  toggle.addEventListener('click', function (e) {
    e.preventDefault();

    // Find the global searchBar (assuming only one in navbar)
    const searchBar = document.querySelector('.searchBar');
    searchBar.classList.toggle('d-none');

    // Focus input if searchBar is visible
    const input = searchBar.querySelector('#searchInputDesk');
    if (!searchBar.classList.contains('d-none')) {
      input.focus();
    }
  });
});

document.querySelector('#closeSearch').addEventListener('click', function () {
  const searchBar = document.querySelector('.searchBar');
  searchBar.classList.add('d-none');
});