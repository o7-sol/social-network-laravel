$(document).ready(function() {
 var pusher = new Pusher('f0946efe2974212caafa', {
    cluster: 'eu',
    encrypted: true
  });

  var channel = pusher.subscribe('test_channel');
  channel.bind('my_event', function(data) {
    var audio = new Audio('message.mp3');
    var dt = new Date();
    var mins = ('0'+dt.getMinutes()).slice(-2);
    $time = dt.getHours() + ":" + mins + ":" + dt.getSeconds();
    $(".chat").append('<li class="left clearfix"><span class="chat-img pull-left"><img class="profilePicPost" src="'+data.avatar+'" /></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">'+data.fname+'</strong><small> @'+data.username+'</small> <small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>'+$time+'</small></div><p>'+data.message+'</p></div>');
    $('.chat-panel-body').animate({scrollTop: $('.chat-panel-body').prop("scrollHeight")}, 500);
    audio.play();
  });

  $('form').submit(function( event ) {
  event.preventDefault();
  $.ajax({
      url: 'siusti-pranesima',
      type: 'post',
      data: $('form').serialize(), // Remember that you need to have your csrf token included
      dataType: 'json',
      success: function( _response ){
        $("#message").val('');
        $('.chat-panel-body').animate({scrollTop: $('.chat-panel-body').prop("scrollHeight")}, 500);
      },
      error: function( _response ){
          // Handle error
      }
  });
});
});