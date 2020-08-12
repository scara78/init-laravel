@if (Auth::user())
<script>
    var socket_token = "{{ Auth::user()->socket_token }}";
</script>
@else
<script>
    var socket_token = "unknown";
</script>
@endif
<script>
    function timeAgo(datetime){
        const diff = (new Date() - new Date(datetime+" UTC"))/1000;
        if(diff<60){
            const v = Math.round(diff)
            return v + ' second' + (v===1?'':'s') + ' ago';   
        }
        else if(diff<60*60){
            const v = Math.round(diff/60)
            return v + ' minute' + (v===1?'':'s') + ' ago';   
        }
        else if(diff<60*60*24){
            const v = Math.round(diff/(60*60))
            return v + ' hour' + (v===1?'':'s') + ' ago';   
        }
        else if(diff<60*60*24*30.436875){
            const v = Math.round(diff/(60*60*24))
            return v + ' day' + (v===1?'':'s') + ' ago';
        }
        else if(diff<60*60*24*30.436875*12){
            const v = Math.round(diff/(60*60*24*30.436875))
            return v + ' month' + (v===1?'':'s') + ' ago';
        }
        const v = Math.round(diff/(60*60*24*30.436875*12)) 
        return v + ' year' + (v===1?'':'s') + ' ago';
    }
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function convertTime(time) {
        return time.getHours() + '.' + time.getMinutes();
    }
</script>
<script src="{{ asset('js/socket.io-client/socket.io.js') }}"></script>
<script src="{{ asset('js/socket-client.js') }}"></script>
