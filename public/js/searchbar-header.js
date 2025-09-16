 document.querySelector('.searchToggle').addEventListener('click', function (e) {
      e.preventDefault();
      const searchBar = document.querySelector('.searchBar');
      searchBar.classList.toggle('d-none');
      // Set focus on the search input when it becomes visible
      document.querySelector('#searchInputDesk').focus();
    });

    document.querySelector('#closeSearch').addEventListener('click', function () {
      const searchBar = document.querySelector('.searchBar');
      searchBar.classList.add('d-none');
    });