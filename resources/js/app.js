import './bootstrap';
import { createApp } from 'vue';
import '../sass/app.scss';

const app = createApp({});

Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(
  ([path, definition]) => {
    app.component(
      path
        .split('/')
        .pop()
        .replace(/\.\w+$/, ''),
      definition.default,
    );
  },
);

app.mount('#app');
