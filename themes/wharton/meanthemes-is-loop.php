<?php
rewind_posts();
if (have_posts()) :
while (have_posts()) : the_post();
if(!get_post_format()) {
   get_template_part('format', 'standard');
} else {
   get_template_part('format', get_post_format());
}
endwhile;
endif;
?>