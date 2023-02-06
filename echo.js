require('dotenv').config()

const { env } = process

require('laravel-echo-server').run({
  authHost: env.APP_URL,
  authEndpoint: '/broadcasting/auth',
  database: 'redis',
  databaseConfig: {
    redis: {
      host: env.REDIS_HOST,
      port: env.REDIS_PORT,
    },
  },
  devMode: true,
  host: null,
  port: env.MIX_ECHO_PORT,
  protocol: env.MIX_ECHO_PROTOCOL,
  socketio: {},
  secureOptions: 67108864,
  sslCertPath: env.MIX_ECHO_SSL_CERT_PATH,
  sslKeyPath: env.MIX_ECHO_SSL_KEY_PATH,
  sslCertChainPath: env.MIX_ECHO_SSL_CERT_CHAIN_PATH,
  sslPassphrase: env.MIX_ECHO_SSL_PASSPHRASE,
  subscribers: {
    http: true,
    redis: true,
  },
  apiOriginAllow: {
    allowCors: true,
    allowOrigin: 'http://127.0.0.1',
    allowMethods: 'GET, POST',
    allowHeaders: 'Origin, Content-Type, X-Auth-Token, X-Requested-With, Accept, Authorization, X-CSRF-TOKEN, X-Socket-Id',
  },
});