        $(document).ready(function() {
            $(".fancybox-thumb").fancybox({
                helpers : {
                    title   : {
                        type: 'inside'
                    },
                    overlay : {
                                css : {
                                    'background' : 'rgba(1,1,1,0.65)'
                                }
                            }
                }
            });
        });