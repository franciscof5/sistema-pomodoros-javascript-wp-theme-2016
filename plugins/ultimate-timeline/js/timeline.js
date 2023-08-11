// Timeline JS

(function($) {
    $(document).ready(function() {
        
        // Timeline LoadMore Function
        var timeline       = $('.ut-timeline'),
            loadPosts      = timeline.data('loadposts');
            shown          = loadPosts,
            loadmore       = loadPosts,
            loadMethod     = timeline.data('loadmethod'),
            listItem       = timeline.find('li.ut-timeline-list-item'),
            listCount      = listItem.length,
            timelineFooter = timeline.find('.ut-timeline-footer-wrap'),
            moreButton     = timeline.find('.timeline-load-more'); 

        // SHOW   
        timeline.find('li.ut-timeline-list-item:lt('+shown+')').fadeIn(); 

        moreButton.on('click', showPosts);
        moreButton.appear();

        if(loadMethod == 'scroll') {
            moreButton.on('appear', showPosts);
        }

        function showPosts() {
            show = timeline.find('li.ut-timeline-list-item:visible').size() + loadmore;
            
            if(listCount >= show) {
                $(this).closest('.ut-timeline').find('li.ut-timeline-list-item:lt('+show+')').fadeIn();
            } else {
                listItem.fadeIn();
                timelineFooter.fadeIn();
                moreButton.hide();
            }
        }

        // Timeline Responsive
        var mediaQuery = 500,
            responsiveClass = 'timeline-responsive';

        responsiveTimeline();
        $(window).on('resize', responsiveTimeline);

        function responsiveTimeline() {
            timeline.each(function() {
                $this = $(this);
                $this.removeClass(responsiveClass);
                if($this.outerWidth() <= mediaQuery) {
                    $this.addClass(responsiveClass);
                }
            }); 
        }

        // EXPANDER
        var titleCount    = timeline.data('titlecount');
        var contentCount = timeline.data('contentcount');

        // Content
        $('.ut-timeline-text').expander({
            slicePoint: contentCount
        });

        // Title
        $('.ut-timeline-title').expander({
            slicePoint: titleCount,
            expandText: ''
        });

    }); 
})(jQuery);