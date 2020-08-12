window.socket = io('http://' + document.domain + ':2222');
window.direction = false;

socket.on('connect', function(data) {
    console.log('socket connected : ', socket_token);
    socket.emit('login', { socket_token })
})

socket.on('login', function(direction) {
    window.direction = direction;
})

socket.on('online_state', function({ user_id, online_state }) {
    console.log(`.avatar.avatar__${user_id}`)
    var user_avatars = $(`.avatar.avatar__${user_id}`);
    if (online_state) {
        user_avatars.removeClass('avatar-offline')
        user_avatars.addClass('avatar-online')
    } else {
        user_avatars.removeClass('avatar-online')
        user_avatars.addClass('avatar-offline')
    }
})

socket.on('disconnect', function(data) {
    console.log('socket disconnect', data);
})

socket.on('error', function(error) {
    console.log(error);
})