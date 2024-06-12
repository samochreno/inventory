<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="/">Autodiely</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a
            v-for="page in pages"
            class="nav-link fw-semibold"
            :class="{ active: page.isActive }"
            :aria-current="page.isActive ? 'page' : ''"
            :href="page.href"
            >{{ page.name }}</a
          >
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
function createPage(name, href) {
  return {
    name,
    href,
    isActive: window.location.pathname == href,
  };
}

const pages = [createPage('Autá', '/auta'), createPage('Diely', '/diely')];
</script>
