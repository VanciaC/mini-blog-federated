import { ApolloServer } from '@apollo/server';
import { ApolloGateway, IntrospectAndCompose } from '@apollo/gateway';

// Creates the Apollo Server with the federated gateway
export const createServer = () => {
  const gateway = new ApolloGateway({
    supergraphSdl: new IntrospectAndCompose({
      subgraphs: [
        { name: 'users', url: process.env.USERS_SERVICE_URL },
        { name: 'posts', url: process.env.POSTS_SERVICE_URL },
      ],
    }),
  });

  return new ApolloServer({ gateway });
};