import { ApolloServer } from '@apollo/server';
import { ApolloGateway, IntrospectAndCompose, RemoteGraphQLDataSource } from '@apollo/gateway';

class AuthenticatedDataSource extends RemoteGraphQLDataSource {
    willSendRequest({ request, context }) {
        if (context.token) {
            request.http.headers.set('Authorization', context.token);
        }
    }
}

export const createServer = () => {
    const gateway = new ApolloGateway({
        supergraphSdl: new IntrospectAndCompose({
            subgraphs: [
                { name: 'users', url: process.env.USERS_SERVICE_URL },
                { name: 'posts', url: process.env.POSTS_SERVICE_URL },
            ],
        }),
        buildService({ url }) {
            return new AuthenticatedDataSource({ url });
        },
    });

    return new ApolloServer({ gateway });
};