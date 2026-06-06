 (function () {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const openBtn = document.getElementById('openSidebar');
      const closeBtn = document.getElementById('closeSidebar');

      function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        requestAnimationFrame(() => overlay.classList.add('opacity-100'));
        openBtn?.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
      }

      function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-100');
        overlay.addEventListener('transitionend', () => overlay.classList.add('hidden'), { once: true });
        openBtn?.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }

      openBtn?.addEventListener('click', openSidebar);
      closeBtn?.addEventListener('click', closeSidebar);
      overlay?.addEventListener('click', closeSidebar);
      window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSidebar(); });
    })();