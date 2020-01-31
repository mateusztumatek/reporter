
{{--<script>--}}

    var element = window.document.getElementById('reporter-app');
    if(!element || typeof reporter_api == 'undefined'){
        console.error('Brak elementu z ID reporter-app lub brak wartości reporter_api');
    }else{
        var iframe_style = document.createElement('link');
        iframe_style.type = 'text/css';
        iframe_style.rel = 'stylesheet';
        iframe_style.href = '{{url('/css/iframe.css')}}';
        iframe_style.onload = () => {
            var url = '{{url('/')}}';
            var iframe = document.createElement('iframe');
            iframe.src = url+'/dist/index.php?api='+reporter_api;
            iframe.id = 'reporter-iframe';
            iframe.scrolling = 'no';
            element.replaceWith(iframe);
            var eventMethod = window.addEventListener
                ? "addEventListener"
                : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod === "attachEvent"
                ? "onmessage"
                : "message";

            eventer(messageEvent, function (e) {
                console.log(e.data);
                if(e.data){
                    if(e.data.width){
                        var data = e.data;
                        iframe.style.width = data.width+'px';
                        iframe.style.height= data.height+'px';
                    }
                }
            });
        }
        document.head.appendChild(iframe_style);
    }
