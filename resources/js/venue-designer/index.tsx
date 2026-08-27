import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App.tsx';

const container = document.getElementById('layout-designer-root');
if (container) {
  const layoutId = container.getAttribute('data-layout-id') || '0';
  const root = ReactDOM.createRoot(container);
  root.render(
    <React.StrictMode>
      <App layoutId={parseInt(layoutId)} />
    </React.StrictMode>
  );
}
