const env = process.env.NODE_ENV || 'local';

console.log(`Starting gateway in ${env} mode...`);

if (env === 'production') {
  await import('./express.js');
} else {
  await import('./standalone.js');
}