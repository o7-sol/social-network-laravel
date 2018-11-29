    $(document).ready(function() {

    function notzi(message, type) {

        var html =  '<div class="alert alert-' + type + ' alert-dismissable page-alert">';
        html +=     '<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
        html +=     message;
        html +=     '</div>';

        $(html).hide().prependTo('#notzi').slideDown(200);
    };

      var pusher = new Pusher('f0946efe2974212caafa', {
        cluster: 'eu',
        encrypted: true
      });

      var channel = pusher.subscribe('posts_channel');
      channel.bind('post_event', function(data) {
        notzi(data.message, 'warning');
        $('.page-alert .close').click( function(e) {
            e.preventDefault();
            $(this).closest('.page-alert').slideUp(200);
        });
      }); 
        });