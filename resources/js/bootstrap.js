import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

const broadcastAuthInstance = axios.create({
    baseURL: `http://127.0.0.1:8000/broadcasting/`,
    headers: {  
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        "X-CSRF-TOKEN": csrfToken,
    },
    withCredentials: true,
})

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "demo_pusher_key",
    cluster: 'mt1',
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    authorizer: (channel, option) => {
        return {
          authorize: (socketId, callback) => {
            broadcastAuthInstance
              .post("auth", {
                socket_id: socketId,
                channel_name: channel.name,
              })
              .then((response) => {
                // console.log("ressss", response);
                callback(false, response.data);
              })
              .catch((error) => {
                console.log("error", error);
                callback(true, error);
              });
          },
        };
      },
});


