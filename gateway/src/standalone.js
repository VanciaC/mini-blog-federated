import { startStandaloneServer } from '@apollo/server/standalone';
import { createServer } from './server.js';

const server = createServer();

const { url } = await startStandaloneServer(server, {
  listen: { port: process.env.PORT || 4000 },
  context: async ({ req }) => ({
    // Forward Authorization header to subgraphs
    token: req.headers.authorization || '',
  }),
});

console.log(`🚀 [LOCAL] Gateway ready at ${url}`);