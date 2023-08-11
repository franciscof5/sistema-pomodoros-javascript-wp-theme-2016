<?php
/**
* Template Name: Statistics Full Width Page (no sidebar)
 */
wp_enqueue_script('jquery');
wp_enqueue_script('jsapi', 'https://www.google.com/jsapi', 1 );
get_header(); ?>

	<section id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">
			<span><a href="https://portfolio.franciscomat.com/">Grid</a> | <a href="https://portfolio.franciscomat.com/stats/">Stats</a> | <a href="https://portfolio.franciscomat.com/timeline/">Timeline</a> | <a href="https://portfolio.franciscomat.com/list/">List</a> | <a href="https://portfolio.franciscomat.com/category/product-type/logo/">Logos</a> | <a href="https://www.franciscomat.com/blog/2018/06/14/github-portfolio-updated/">Github</a> | <a href="https://www.franciscomat.com/software/">Software</a></span>
			<?php 
					
					    global $wpdb;

    // get total post
    $totalPosts = wp_count_posts();
    $totalPostsArray = (array)$totalPosts;
    unset($totalPostsArray['auto-draft']);
    unset($totalPostsArray['inherit']);
    unset($totalPostsArray['trash']);
    unset($totalPostsArray['draft']);
    unset($totalPostsArray['review']);
    $countPosts = array_sum($totalPostsArray);
    
    // Get years that have posts and get comments count per year
    $years = $wpdb->get_results("SELECT YEAR(post_date) AS year FROM " . $wpdb->prefix . "posts 
            WHERE post_type = 'post' AND post_status = 'publish' 
            GROUP BY year DESC");
    
    // find year wise and month wise posts
    foreach($years as $k => $year){
        
        // year wise
        $yearWisePosts = $wpdb->get_results("
            SELECT YEAR(post_date) as post_year, COUNT(ID) as post_count 
                FROM " . $wpdb->prefix . "posts
                WHERE YEAR(post_date) =  '" . $year->year . "' AND post_type = 'post'  AND post_status = 'publish' 
                GROUP BY post_year
                ORDER BY post_date ASC"
        );
        if(!empty($yearWisePosts[0]->post_year)){
            $yearWiseArray[$yearWisePosts[0]->post_year] = $yearWisePosts[0]->post_count;
        }
        
        // month wise
        $monthWisePosts = $wpdb->get_results("
            SELECT MONTH(post_date) as post_month, COUNT(ID) as post_count 
                FROM " . $wpdb->prefix . "posts
                WHERE YEAR(post_date) =  '" . $year->year . "' AND post_type = 'post'
                GROUP BY post_month
                ORDER BY post_date ASC"
            );
        
        foreach($monthWisePosts as $mk => $post){
            $monthWiseArray[$year->year][$post->post_month] = $post->post_count;
        }
        $qvarEn="
            SELECT YEAR(post_date) as post_year, COUNT(ID) as post_count 
                FROM " . $wpdb->prefix . "posts

                LEFT JOIN  $wpdb->term_relationships  as t
                            ON ID = t.object_id

                WHERE YEAR(post_date) =  '" . $year->year . "' AND post_type = 'post'  AND post_status = 'publish' 

                AND t.term_taxonomy_id = 58

                GROUP BY post_year
                ORDER BY post_date ASC";
        $qvarCl="
            SELECT YEAR(post_date) as post_year, COUNT(ID) as post_count 
                FROM " . $wpdb->prefix . "posts

                LEFT JOIN  $wpdb->term_relationships  as t
                            ON ID = t.object_id

                WHERE YEAR(post_date) =  '" . $year->year . "' AND post_type = 'post'  AND post_status = 'publish' 

                AND t.term_taxonomy_id = 45

                GROUP BY post_year
                ORDER BY post_date ASC";

        $qvarPa="
            SELECT YEAR(post_date) as post_year, COUNT(ID) as post_count 
                FROM " . $wpdb->prefix . "posts

                LEFT JOIN  $wpdb->term_relationships  as t
                            ON ID = t.object_id

                WHERE YEAR(post_date) =  '" . $year->year . "' AND post_type = 'post'  AND post_status = 'publish' 

                AND t.term_taxonomy_id = 79

                GROUP BY post_year
                ORDER BY post_date ASC";

        $qvarSt="
            SELECT YEAR(post_date) as post_year, COUNT(ID) as post_count 
                FROM " . $wpdb->prefix . "posts

                LEFT JOIN  $wpdb->term_relationships  as t
                            ON ID = t.object_id

                WHERE YEAR(post_date) =  '" . $year->year . "' AND post_type = 'post'  AND post_status = 'publish' 

                AND t.term_taxonomy_id = 76

                GROUP BY post_year
                ORDER BY post_date ASC";
        $entrereneuByYearWisePosts = $wpdb->get_results($qvarEn);
        $clietByYearWisePosts = $wpdb->get_results($qvarCl);
        $partnerByYearWisePosts = $wpdb->get_results($qvarPa);
        $studyByYearWisePosts = $wpdb->get_results($qvarSt);
        #var_dump($year->year);die;
        if(!empty($entrereneuByYearWisePosts[0]->post_year)){
            $entrereneuByWiseArray[$entrereneuByYearWisePosts[0]->post_year] = $entrereneuByYearWisePosts[0]->post_count;
        } else {
            $entrereneuByWiseArray[$year->year]=0;
        }
        #
        if(!empty($clietByYearWisePosts[0]->post_year)){
            $clientByWiseArray[$clietByYearWisePosts[0]->post_year] = $clietByYearWisePosts[0]->post_count;
        } else {
            $clientByWiseArray[$year->year]=0;
        }
        #
        if(!empty($partnerByYearWisePosts[0]->post_year)){
            $partnerByWiseArray[$partnerByYearWisePosts[0]->post_year] = $partnerByYearWisePosts[0]->post_count;
        } else {
            $partnerByWiseArray[$year->year]=0;
        }
        #
        if(!empty($studyByYearWisePosts[0]->post_year)){
            $studyByWiseArray[$studyByYearWisePosts[0]->post_year] = $studyByYearWisePosts[0]->post_count;
        } else {
            $studyByWiseArray[$year->year]=0;
        }
    }
    #var_dump($clientByWiseArray);die;
    // make the string of month wise comments according to chart's requirements
   foreach($monthWiseArray as $y => $arr){
       $test_arr = array();
       for($i = 1; $i<=12; $i++){
           $test_arr[$i] = isset($arr[$i]) ? $arr[$i] : 0;
       }
       $monthsArray[$y] = implode(",", $test_arr);
   }
    
    // most commented posts
    /*$mostCommentedPosts = $wpdb->get_results("SELECT comment_count, ID, post_title, post_author, post_date
        FROM $wpdb->posts wposts, $wpdb->comments wcomments
        WHERE wposts.ID = wcomments.comment_post_ID
        AND wposts.post_status='publish'
        AND wcomments.comment_approved='1'
        GROUP BY wposts.ID
        ORDER BY comment_count DESC
        LIMIT 0 ,  5
    ");
    
    
    $longestPosts = $wpdb->get_results("SELECT ID,post_title,post_date,LENGTH(post_content) - LENGTH(REPLACE(post_content,' ',''))+1 AS post_length 
            FROM $wpdb->posts 
            WHERE post_status = 'publish' AND post_type = 'post'
            GROUP BY ID
            ORDER BY post_length DESC 
            LIMIT 5");

    $shortestPosts = $wpdb->get_results("SELECT ID,post_title,post_date,LENGTH(post_content) - LENGTH(REPLACE(post_content,' ',''))+1 AS post_length 
            FROM $wpdb->posts 
            WHERE post_status = 'publish' AND post_type = 'post'
            GROUP BY ID
            ORDER BY post_length 
            LIMIT 5");
    */
    ?>

    <div class="wrap">
        <div class="stat-charts-main" style="width: 100%;">
            <!--div class="chartBox" style="display: none;">
                <div id="totalPostsChart"></div>
            </div>
            <div class="chartBox" style="display: none;">
                <div id="mostCommentsChart"></div>
            </div-->
            <hr style="clear:both">
            <div class="">
                <div id="byYearChart" style="width: 100%;height: 400px;"></div>
            </div>
            <p><strong>NOTES</strong>: understanding productivity. <strong>1998-2002</strong>: losted work, many ppt animations and HTML studies, The Sims 1 textures and objects. <strong>2002-2005</strong>: high school consuming a lot of time. <strong>2004</strong>: first time half-time employee, many one weekend works. <strong>2005</strong>: first time fired, forced to entrepreneur. Abandonated educational projects for focusing in Flash games lauching. <strong>2006</strong>: pre-college course consumes 90% of time. <strong>2007-2010</strong>: college start, many non-computer activities like jr company and sports, few academic associations jobs. <strong>2008-2009</strong>: first home-office part/time job. <strong>2010</strong>: losted recurrent client to focus on conclusion course work and write. <strong>2011-2012</strong>: half time entrepreneur/freelancer, failure in both. <strong>2013</strong>: full-time employee, few bigger/complex projects, almost stopped entrepreneur. First time rich with gorgeous girlfriend and total family support. Suffered to stop drink alcohol for gain focus. <strong>2014-2016</strong>: Academic master course full-dedication, again almost no time for side jobs or entrepreneur, but miraculously keep receiving propostals. Worked during vacations, weekends and holidays, got many clients frustred by interruptions. <strong>2016</strong>: Jobs for selective processes, desperate try to reestablishment of IT career because lost of scholarship, failure to get a job, became poor. After difficulty months got failure in MsC final exam, decided to full-time entrepreneur, official F5 Sites shy restarted. Struggling to get income. <strong>2017</strong>: first time full-time entrepreneur, restarting old projects almost from scratch, a lot of personal problems and ultra-low budgets situations keeps delaying every launch schedule try, poorest period for me and Brazilian economy. Sold personal stuff to live. Started many video productions, more than 50 videos published, 3 YouuTbe channels started side along IT projects. <strong>2018</strong>: Ready launch base almost ready for growth. Forced part-time freelance for paying bills, after sold almost all personal stuff just to visit potential new costumers in an delicated risk game, no money and 5 years girlfriend couldnt take it, gone. Discredited by family and friends. After 2 years Pomodoros.com.br is finally stable again. First good freelancer job after 3 years, completes 27 months of full-time jobs search without success, decides to have a break. Life stress peak, years without holidays or paid rest. After 13 years of first try, finally official Portfolio launched, tons of old projects recovered made possible a clear career review.</p>
            <!--div class="chartBox" style="display: none;">
                <div id="longestPostsChart"></div>
            </div>
            <div class="chartBox" style="display: none;">
                <div id="shortestPostsChart"></div>
            </div>
            <div class="chartBoxLarge" style="display: none;">
                <div id="monthWiseChart"></div>
            </div>
       
            <div class="chartBox" style="display: none;">
                <div id="parentChildChart"></div>
            </div>
            <div class="chartBox" style="display: none;">
                <div id="usedUnusedChart"></div>
            </div-->
            <hr style="clear:both">
            <div class="">
                <div id="mostUsedChart" style="width: 100%;height: 400px;"></div>
            </div>

            <hr style="clear:both">
            <div class="">
                <div id="lessUsedChart"></div>
            </div>
            <h3>Disaggregated Product Owner Stats:</h3>
            <hr style="clear:both">
            <div class="">
                <div id="entrepreneurByYear"></div>
            </div>

            <hr style="clear:both">
            <div class="">
                <div id="clientByYearDiv"></div>
            </div>
            
            <hr style="clear:both">
            <div class="">
                <div id="partnerByYearDiv"></div>
            </div>

            <hr style="clear:both">
            <div class="">
                <div id="studyByYearDiv"></div>
            </div>
            <p><strong>NOTES</strong>: What I have studed. <strong>2004</strong>: Flash. <strong>2005</strong>: 3D skeleton and animation rendering. 3D Max. <strong>2008</strong>: JavaScript Mootools. <strong>2009</strong>: WordPress theme development. <strong>2011</strong>: JavaScript jQuery/AJAX. <strong>2013</strong>: Bootstrap. <strong>2014</strong>: Laravel PHP. <strong>2015</strong>: Android Studio <strong>2016</strong>: Djikistra PHP, WordPress (selective processes job). <strong>2017</strong>: JavaScript: React, Codeignite, NodeJS. Video editing: openshot, OBS. <strong>2018</strong>: Timber, docker (selective processes job). </p>
        </div>
    </div>
<?php 

// get total category
    $totalCategory = wp_count_terms('category');
    
    // get used and unused category
    $unusedCategory = $wpdb->get_results("SELECT name, slug FROM  ". $wpdb->prefix . "terms 
        WHERE term_id IN (SELECT term_id  FROM  ". $wpdb->prefix . "term_taxonomy  WHERE taxonomy = 'category'  AND count = 0 ) ");
    $usedCategory = $totalCategory - count($unusedCategory);
    
    // get parent and child category
    $totalParentCategory = count(get_categories('parent=0&hide_empty=0'));
    $totalChildCategory = $totalCategory - $totalParentCategory;
    
    // find most and less used category
    $mostArgs=array('orderby' => 'count','order' => 'DESC','hide_empty' => 0, 'parent' => 37, 'post_status'=>'publish');
    $mostUsedcategories=get_categories($mostArgs);
    /*$mostUsedcategories=get_terms( 
   'category', 
   array('orderby' => 'count','order' => 'DESC','hide_empty' => 0, 'child_of'=>37, 'parent' => 0)
);*/
    $mostArgs2=array('orderby' => 'count','order' => 'DESC','hide_empty' => 0, 'parent' => 75);
    $mostUsedcategories2=get_categories($mostArgs2);

    $lessArgs=array('orderby' => 'count','order' => 'ASC','hide_empty' => 0,'number' => 5);
    $lessUsedcategories=get_categories($lessArgs);

#var_dump($mostUsedcategories);die; ?>
    <?php #include_once('wp-show-stats-sidebar.php'); ?>

    <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                
                // total posts chart
                <?php /*if($countPosts > 0): ?>
                    var postdata = google.visualization.arrayToDataTable([
                        ["Status", "Number of posts", {role: "style"}],
                        ["Private", <?php echo $totalPosts->private; ?>, "#000000"],
                        ["Pending", <?php echo $totalPosts->pending; ?>, "#0f0f0f"],
                        ["Draft", <?php echo $totalPosts->draft; ?>, "#0000ff"],
                        ["Published", <?php echo $totalPosts->publish; ?>, "#00ff00"],
                        ["Trash", <?php echo $totalPosts->trash; ?>, "#ff0000"],
                        ["Future", <?php echo $totalPosts->future; ?>, "#e0440e"],
                    ]);
                    var postview = new google.visualization.DataView(postdata);
                    postview.setColumns([0, 1,2]);
                    var postoptions = {
                        title: "Posts by status (Total: <?php echo $countPosts; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var postchart = new google.visualization.ColumnChart(document.getElementById("totalPostsChart"));
                    postchart.draw(postview, postoptions);
                <?php else: ?>
                    document.getElementById('totalPostsChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Total/Status Wise Post Stats' because there are no posts found.</span>";
                <?php endif;*/ ?> 
                
                // most commented posts
                <?php /*if(count($mostCommentedPosts) > 0): ?>
                    var mostcommentsdata = google.visualization.arrayToDataTable([
                        ["Comments", "Number of comments", {role: "style"}],
                        <?php $i=0; foreach($mostCommentedPosts as $k => $post): $i++; ?>
                            ["<?php echo substr($post->post_title,0,10); ?>", <?php echo $post->comment_count; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var mostcommentsview = new google.visualization.DataView(mostcommentsdata);
                    mostcommentsview.setColumns([0, 1,2]);
                    var mostcommentsoptions = {
                        title: "5 most commented posts",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var mostcommentsChart = new google.visualization.ColumnChart(document.getElementById("mostCommentsChart"));
                    mostcommentsChart.draw(mostcommentsview, mostcommentsoptions);
                <?php else: ?>
                    document.getElementById('mostCommentsChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Most Commented Posts Stats' because there are no posts found.</span>";
                <?php endif; */?>
                
                
                // year wise post chart
                <?php if(count($yearWiseArray) > 0): ?>
                    var yearwisedata = google.visualization.arrayToDataTable([
                        ["Year", "Number of posts", {role: "style"}],
                        <?php $i=0; foreach($yearWiseArray as $k => $val): $i++; ?>
                            ["<?php echo $k; ?>", <?php echo $val; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var yearwiseview = new google.visualization.DataView(yearwisedata);
                    yearwiseview.setColumns([0, 1,2]);
                    var yearwiseoptions = {
                        title: "Jobs by year (Total: <?php echo $countPosts; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var yearwiseChart = new google.visualization.ColumnChart(document.getElementById("byYearChart"));
                    yearwiseChart.draw(yearwiseview, yearwiseoptions);
                <?php else: ?>
                    document.getElementById('byYearChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Posts By Year Stats' because there are no posts found.</span>";
                <?php endif; ?>
                
                    var entrepreneurByYeardata = google.visualization.arrayToDataTable([
                        ["Year", "Number of posts", {role: "style"}],
                        <?php $sum=0;$i=0; foreach($entrereneuByWiseArray as $k => $val): $i++; ?>
                            ["<?php echo $k; ?>", <?php echo $val; $sum+=$val;?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var entrepreneurByYearView = new google.visualization.DataView(entrepreneurByYeardata);
                    entrepreneurByYearView.setColumns([0, 1,2]);
                    var entrepreneurByYearoptions = {
                        title: "Entrepreneur Jobs by year (Total: <?php echo $sum; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var entrepreneurByYearChart = new google.visualization.ColumnChart(document.getElementById("entrepreneurByYear"));
                    entrepreneurByYearChart.draw(entrepreneurByYearView, entrepreneurByYearoptions);





                    var clientByYeardata = google.visualization.arrayToDataTable([
                        ["Year", "Number of posts", {role: "style"}],
                        <?php $sum=0;$i=0; foreach($clientByWiseArray as $k => $val): $i++; ?>
                            ["<?php echo $k; ?>", <?php echo $val; $sum+=$val;?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var clientByYearView = new google.visualization.DataView(clientByYeardata);
                    clientByYearView.setColumns([0, 1,2]);
                    var clientByYearoptions = {
                        title: "Client Jobs by year (Total: <?php echo $sum; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var clientByYearChart = new google.visualization.ColumnChart(document.getElementById("clientByYearDiv"));
                    clientByYearChart.draw(clientByYearView, clientByYearoptions);




                    var partnerByYeardata = google.visualization.arrayToDataTable([
                        ["Year", "Number of posts", {role: "style"}],
                        <?php $sum=0;$i=0; foreach($partnerByWiseArray as $k => $val): $i++; ?>
                            ["<?php echo $k; ?>", <?php echo $val;$sum+=$val; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var partnerByYearView = new google.visualization.DataView(partnerByYeardata);
                    partnerByYearView.setColumns([0, 1,2]);
                    var partnerByYearoptions = {
                        title: "Partner Jobs by year (Total: <?php echo $sum; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var partnerByYearChart = new google.visualization.ColumnChart(document.getElementById("partnerByYearDiv"));
                    partnerByYearChart.draw(partnerByYearView, partnerByYearoptions);




                    var studyByYeardata = google.visualization.arrayToDataTable([
                        ["Year", "Number of posts", {role: "style"}],
                        <?php $sum=0;$i=0; foreach($studyByWiseArray as $k => $val): $i++; ?>
                            ["<?php echo $k; ?>", <?php echo $val;$sum+=$val; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var studyByYearView = new google.visualization.DataView(studyByYeardata);
                    studyByYearView.setColumns([0, 1,2]);
                    var studyByYearoptions = {
                        title: "Study Jobs by year (Total: <?php echo $sum; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var studyByYearChart = new google.visualization.ColumnChart(document.getElementById("studyByYearDiv"));
                    studyByYearChart.draw(studyByYearView, studyByYearoptions);
                // monthwise posts chart
                <?php /*if(count($monthsArray) > 0): ?>
                    var monthwisedata = google.visualization.arrayToDataTable([
                        ['Month', 'Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec', { role: 'annotation' } ],
                        <?php foreach($monthsArray as $k => $data): ?>
                            ['<?php echo $k; ?>',<?php echo $data; ?>,''],
                        <?php endforeach; ?>
                    ]);

                      var monthwiseoptions = {
                        width: 1015,
                        height: 500,
                        title: "Month wise posts",
                        legend: { position: 'top', maxLines: 3 },
                        bar: { groupWidth: '55%' },
                        isStacked: true,
                      };
                    var monthwiseview = new google.visualization.DataView(monthwisedata);
                    monthwiseview.setColumns([0,1,2,3,4,5,6,7,8,9,10,11,12]);
                    var monthwiseChart = new google.visualization.ColumnChart(document.getElementById("monthWiseChart"));
                    monthwiseChart.draw(monthwiseview, monthwiseoptions);
                <?php else: ?>
                    document.getElementById('monthWiseChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Posts By Months Stats' because there are no posts found.</span>";
                <?php endif; */?>
                
                // Author wise posts
               
               
               
                // longest posts
                <?php /*if(count($longestPosts) > 0): ?>
                    var longestdata = google.visualization.arrayToDataTable([
                        ["Post", "Length (No. of words)", {role: "style"}],
                        <?php $i=0; foreach($longestPosts as $k => $post): $i++; ?>
                            ["<?php echo $post->post_title;; ?>", <?php echo $post->post_length; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var longestview = new google.visualization.DataView(longestdata);
                    longestview.setColumns([0, 1,2]);
                    var longestoptions = {
                        title: "5 longest posts",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var longestChart = new google.visualization.ColumnChart(document.getElementById("longestPostsChart"));
                    longestChart.draw(longestview, longestoptions);
                <?php else: ?>
                    document.getElementById('longestPostsChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Longest Posts Stats' because there are no posts found.</span>";
                <?php endif; */?>
                
                // shortest posts
                <?php /*if(count($shortestPosts) > 0): ?>
                    /*var shortestdata = google.visualization.arrayToDataTable([
                        ["Post", "Length (No. of words)", {role: "style"}],
                        <?php $i=0; foreach($shortestPosts as $k => $post): $i++; ?>
                            ["<?php echo $post->post_title;; ?>", <?php echo $post->post_length; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var shortestview = new google.visualization.DataView(shortestdata);
                    shortestview.setColumns([0, 1,2]);
                    var shortestoptions = {
                        title: "5 shortest posts",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    /*var shortestChart = new google.visualization.ColumnChart(document.getElementById("shortestPostsChart"));
                    shortestChart.draw(shortestview, shortestoptions);
                <?php else: ?>
                    document.getElementById('shortestPostsChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Shortest Posts Stats' because there are no posts found.</span>";
                <?php endif; */?> 
                
            }
        </script>
        
        <hr>

        <?php
        
    
?>

    <div class="wrap">
        <!--h2>WP Show Stats - Category Statistics</h2-->
        
    </div>

    <?php #include_once('wp-show-stats-sidebar.php'); ?>

        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart2);
            function drawChart2() {
                
                
                // chart for child/parent category
                <?php if($totalCategory > 0): ?>
                    var data = google.visualization.arrayToDataTable([
                        ["Category", "Count", {role: "style"}],
                        ["Parent", <?php echo $totalParentCategory; ?>, "#0000ff"],
                        ["Child", <?php echo $totalChildCategory; ?>, "#00ff00"],
                    ]);
                    var view = new google.visualization.DataView(data);
                    view.setColumns([0, 1, 2]);
                    /*view.setColumns([0, 1,
                        {calc: "stringify",
                            sourceColumn: 0,
                            type: "string",
                            role: "annotation"},
                        2]);*/
                    var options = {
                        title: "Parent and child categories (Total: <?php echo $totalCategory; ?>)",
                        bar: {groupWidth: "95%"},
                        legend: {position: "none"},
                    };
                    /*var chart = new google.visualization.ColumnChart(document.getElementById("parentChildChart"));
                    chart.draw(view, options);*/
                <?php else: ?>
                    document.getElementById('parentChildChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Parent Child Category Stats' because there are no categories found.</span>";
                <?php endif; ?>
                
                // chart for used/unused categories
                <?php if($totalCategory > 0): ?>
                    var usedcategorydata = google.visualization.arrayToDataTable([
                        ["Category", "Count", {role: "style"}],
                        ["Used",<?php echo $usedCategory; ?>, "#0000ff"],
                        ["Unused",<?php echo count($unusedCategory); ?>, "#00ff00"],
                    ]);
                    var usedcategoryview = new google.visualization.DataView(usedcategorydata);
                    usedcategoryview.setColumns([0, 1, 2]);
                    var usedcategoryoptions = {
                        title: "Used/Unused categories (Total: <?php echo $totalCategory; ?>)",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    /*var usedcategorychart = new google.visualization.ColumnChart(document.getElementById("usedUnusedChart"));
                    usedcategorychart.draw(usedcategoryview, usedcategoryoptions);*/
                <?php else: ?>
                    document.getElementById('usedUnusedChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Used/Unused Category Stats' because there are no categories found.</span>";
                <?php endif; ?>   
                
                
                // chart for most used categories
                <?php if($totalCategory > 0): ?>
                    var mostuseddata = google.visualization.arrayToDataTable([
                        ["Category", "Used in number of posts", {role: "style"}],
                        <?php $i=0; foreach($mostUsedcategories as $k => $val): $i++; ?>
                            ["<?php echo $val->name; ?>", <?php echo $val->category_count; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var mostusedview = new google.visualization.DataView(mostuseddata);
                    mostusedview.setColumns([0, 1, 2]);
                    var mostusedoptions = {
                        /*width: 1015,
                        height: 500,*/
                        title: "Categories by Technology",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var mostusedchart = new google.visualization.ColumnChart(document.getElementById("mostUsedChart"));
                    mostusedchart.draw(mostusedview, mostusedoptions);
                <?php else: ?>
                    document.getElementById('mostUsedChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Most Used Category Stats' because there are no categories found.</span>";
                <?php endif; ?> 
                
                
                // chart for less used categories
                <?php if($totalCategory > 0): ?>
                    var lessuseddata = google.visualization.arrayToDataTable([
                        ["Category", "Used in number of posts", {role: "style"}],
                        <?php $i=0; foreach($mostUsedcategories2 as $k => $val): $i++; ?>
                            ["<?php echo $val->name; ?>", <?php echo $val->category_count; ?>, "<?php echo $i%2==0 ? "#00ff00" : "0000ff"; ?>"],
                        <?php endforeach; ?>
                    ]);
                    var lessusedview = new google.visualization.DataView(lessuseddata);
                    lessusedview.setColumns([0, 1, 2]);
                    var lessusedoptions = {
                        /*width: 1015,
                        height: 500,*/
                        title: "Categories by Product Owner",
                        bar: {groupWidth: "70%"},
                        legend: {position: "none"},
                    };
                    var lessusedchart = new google.visualization.ColumnChart(document.getElementById("lessUsedChart"));
                    lessusedchart.draw(lessusedview, lessusedoptions);
                <?php else: ?>
                    document.getElementById('lessUsedChart').innerHTML = "<span class='nothingtodo'>There is nothing to show here for 'Less Used Category Stats' because there are no categories found.</span>";
                <?php endif; ?> 
                
                
            }
        </script>

					<?php #the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
					<?php #wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
