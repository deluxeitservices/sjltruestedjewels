  function showContent(section) {
    // Hide all sections
    document.querySelectorAll(".content-section").forEach(el => el.classList.add("d-none"));
    // Show selected
    document.getElementById(section).classList.remove("d-none");
    // Update active button
    document.querySelectorAll(".sidebar-menu button").forEach(btn => btn.classList.remove("active"));
    event.target.classList.add("active");
  }