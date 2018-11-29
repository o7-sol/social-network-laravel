        $(document).ready(function() {

            // OPTIONS FOR PUBLIC OR FRIENDS
        $('input[type="checkbox"]').on('change', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);
        });

            // REPLIES
            $(".comment_form").hide();

            $(".comment_link").click (function(e){
                $(this).next(".comment_form").show();
                e.preventDefault();
            });

            $(".replies").hide();

            $(".replies_show").click (function(e){
                $(this).hide();
                $(this).next(".replies").show(300);
                e.preventDefault();
            });

             $(".replies_hide").click (function(e){
                $(".replies_show").show();
                $(this).closest(".replies").hide(300);
                e.preventDefault();
            });  

            // REPLY BUTTON         
        $('.reply').on('input', function(e) {
            $(".replyBtn").hide();
          if ($(this).val().length > 0) {
            $(".replyBtn").removeClass('disabled');
            $(".replyBtn").show();
          }
        });

        });