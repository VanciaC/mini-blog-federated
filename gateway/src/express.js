import express from 'express';
import helmet from 'helmet';
import cors from 'cors';
import { expressMiddleware } from '@apollo/server/express4';
import { createServer } from './server.js';

const server = createServer();
await server.start();

const app = express();

// Security headers
app.use(helmet());

// CORS
app.use(cors({ origin: process.env.CORS_ORIGIN || '*' }));

// JSON body parser
app.use(express.json());

// GraphQL endpoint
app.use('/graphql', expressMiddleware(server, {
  context: async ({ req }) => ({
    // Forward Authorization header to subgraphs
    token: req.headers.authorization || '',
  }),
}));

app.listen(process.env.PORT || 4000, () => {
  console.log(`🚀 [PROD] Gateway ready on port ${process.env.PORT || 4000}`);
});