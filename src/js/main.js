const nav_btn = document.getElementById('nav-btn');
const sidebar = document.getElementById('content');
nav_btn.addEventListener('click', () => {
  if (Array.from(sidebar.classList).includes('sidebar-unhidden')) {
    sidebar.classList.remove('sidebar-unhidden');
  } else {
    sidebar.classList.add('sidebar-unhidden');
  }
});
const nav_links = Array.from(document.getElementsByClassName('nav-link'));
nav_links.forEach(e => {
  if (e.href == window.location.href.split('?')[0]) {
    e.classList.add('active');
  }
});