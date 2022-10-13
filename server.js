const server = require('http').Server();
const socketIo = require('socket.io');
const io = socketIo(server, {
    cors: {
        origin: '*',
    }
});
const Redis = require('ioredis');

const redis = new Redis();
redis.subscribe('graph-action');
redis.on('message', function (channel, message) {
    console.log('Message recieved:', channel);
    console.log('Channel recieved:', message);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});

server.listen(3000, function () {
    console.log('Listening on port: 3000');
});
