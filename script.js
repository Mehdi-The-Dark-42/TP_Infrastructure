function openTab(event, id) {
  document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
  const tab = document.getElementById(id);
  if (tab) tab.classList.add('active');
  if (event && event.currentTarget) event.currentTarget.classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
  const firstBtn = document.querySelector('.tab-btn');
  const firstTab = document.querySelector('.tab-content');
  if (firstBtn) firstBtn.classList.add('active');
  if (firstTab) firstTab.classList.add('active');
});
