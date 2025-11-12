function getSearchKeyword() {
  const params = new URLSearchParams(window.location.search);
  return params.get('search') || '';
}

function normalize(str) {
  return str
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/đ/g, 'd');
}

// This function is specific to mqd1.html and should only run there.
// mqd1.html's body should have an ID like 'mqd1-page' for this to work.
function filterProducts(keyword) {
  ['.kem-grid label', '.ngot-grid label', '.quy-grid label'].forEach(selector => {
    document.querySelectorAll(selector).forEach(label => {
      const name = label.querySelector('p.text-gray-900')?.innerText || '';
      if (!keyword || normalize(name).includes(normalize(keyword))) {
        label.style.display = '';
      } else {
        label.style.display = 'none';
      }
    });
  });
}

// Common search functionality for header
function goToSearch() {
  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    const keyword = searchInput.value.trim();
    if (keyword) {
      window.location.href = 'mqd1.html?search=' + encodeURIComponent(keyword);
    }
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const searchBtn = document.getElementById('searchBtn');
  const searchInput = document.getElementById('searchInput');

  if (searchBtn) searchBtn.addEventListener('click', goToSearch);
  if (searchInput) searchInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') goToSearch(); });

  // Run filterProducts only on mqd1.html
  if (document.body.id === 'mqd1-page') filterProducts(getSearchKeyword());
});