<div class="rb-container">
    <div class="rb-row rb-pl-6 rb-align-items-center rb-py-6">
        <div class="rb-col-6">
            <div class="rb-intro-head">
                <div class="rb-image-logo">
                    <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/logo.png'; ?>" alt="logo" />
                </div>

                <span class="rb-heading-label"> Welcome to </span>
                <h1 class="rb-heading"> Rise Blocks </h1>

                <p class="rb-description">Thank you for choosing Rise Block - A Complete Gutenberg Page builder, a gallery of lightweight 
                    gutenberg blocks. With Rise Block, you can easily create a stunning website or a desired blog of your choice with zero knowledge in coding. You just need to add a block in the desired locations and insert the content and customize as per your need.
                </p>

                <div class="rb-btn-wrap with-icon">
                    <a href="https://wpactivethemes.com/downloads/rise-blocks-pro/" target="_blank" class="rb-icon-arrow">Get templates</a>
                </div>
            </div>
        </div>

        <div class="rb-col-6">
            <div class="rb-video-box">
                <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/bg-image.png';?>" alt="video" />
                <img class="rb-girl-img" src="<?php echo self::get_plugin_directory_uri().'/templates/img/small-img.png';?>" alt="video" />
                <img class="rb-dots-img" src="<?php echo self::get_plugin_directory_uri().'/templates/img/dots.png';?>" alt="dots" />

                <a href="#" class="rb-quick-play rb-js-modal-btn" data-video-id="--jwJzZBIUA"> Play Quick Demo </a>
                <a href="#" class="rb-play-btn rb-js-modal-btn"  data-video-id="--jwJzZBIUA">
                    <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/play.png';?>" alt="dots" />
                </a>
            </div>
        </div>
    </div><!-- intro section -->

    <div class="rb-icon-box-section">
        <div class="rb-polygon-img rb-polygon-img-1">
            <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/poly.png';?>" alt="slider" />
        </div>

        <div class="rb-polygon-img rb-polygon-img-2">
            <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/poly2.png';?>" alt="slider" />
        </div>

        <div class="rb-available-blocks-head rb-text-center">
            <h1 class="rb-heading rb-heading-small"> Available Blocks </h1>
            <!-- <p>We have a lot of awesome blocks. But if you're overwhelmed with 
            awesomeness, you can hide some of them.</p> -->
            <p>Each piece is unique and exclusive. It’s easy to create your own custom project.</p>
        </div>  <!-- heading -->

        <div class="rb-row rb-small-row">
            <?php
                $contents = Rise_Blocks_Helper::get_blocks_info();
                foreach( $contents as $block_id => $content ):
                    if( $content[ 'inserter' ] ):
            ?>
                        <div class="rb-col-3">
                            <div class="rb-inner-padding">
                                <div class="rb-available-icon-box-wrap rb-text-center">
                                    <div class="rb-icon-image"><?php self::render_svg( $content[ 'icon' ] ); ?></div>
                                    <h2><?php echo esc_html( $content[ 'title' ] ); ?></h2>
                                    <p class="rb-description rb-icon-description"><?php echo esc_html( $content[ 'description' ] ); ?></p>
                                    <a target="_target" href="https://wpactivethemes.com/">
                                        Explore more...
                                    </a>
                                </div>
                            </div>
                        </div>
            <?php
                endif;
            endforeach;
            ?>    
        </div><!-- icon-box -->
        <div class="rb-first-svg">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path class="rise-shape-fill" opacity="0.33" d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z"></path>
                <!-- <path class="rise-shape-fill" opacity="0.66" d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path> -->
                <path class="rise-shape-fill" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z"></path>
            </svg>
        </div>
    </div>

    <div class="rb-row rb-px-6 rb-py-6 rb-align-items-center change-order">
        <div class="rb-col-6 order-2">
            <div class="rb-image-large">
                <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/drag-drop.png';?>" alt="slider" />
            </div>
        </div>
        <div class="rb-col-6 order-1">
            <div class="rb-intro-head">
                <span class="rb-heading-label"> Recommended </span>
                <h1 class="rb-heading rb-heading-small"> Themes </h1>
                <p class="rb-description rb-recomended-theme-desc">Get our beautiful <span>FREE WordPress theme </span> made especially for Rise blocks, and we highly recommend it.
                </p>
                <div class="rb-btn-wrap with-icon">
                    <a href="https://wordpress.org/themes/author/eaglethemes/" target="_blank" class="rb-icon-dnl"> Download Now </a>
                    &nbsp;
                    <a href="https://www.eaglevisionit.com/downloads/" target="_blank" class="rb-icon-dnl marketplace"> Go To Marketplace </a>
                </div>
            </div>
        </div>
    </div> <!-- recomended theme -->

    <div class="rb-row rb-px-6 rb-py-6 rb-align-items-center">
        <div class="rb-col-6"> 
            <div class="rb-intro-head">
                <span class="rb-heading-label"> Demo Content </span>
                <h1 class="rb-heading rb-heading-small"> How To Import Demo Templates? </h1>
                <p class="rb-description rb-recomended-theme-desc">Importing a demo site and customizing it is a great way to save your development time. The demo sites can be exported and imported from the editor after installing Rise Blocks.
                </p>               

                <div class="rb-btn-wrap">
                    <a href="#" target="_blank" class="rb-icon rb-js-modal-btn" data-video-id="Hwljubang2M"> Watch Video <span class="dashicons dashicons-visibility"></span></a>
                </div>
            </div>
        </div>
        <div class="rb-col-6">
            <div class="rb-image-large">
                <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/import.png';?>" alt="slider" />
            </div>
        </div>       
    </div> <!-- rate our work-->

    <div class="rb-row rb-px-6 rb-py-6 rb-align-items-center change-order">
        <div class="rb-col-6">
            <div class="rb-image-large">
                <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/rate.png';?>" alt="slider" />
            </div>
        </div>       
        <div class="rb-col-6">
            <div class="rb-intro-head">
                <h1 class="rb-heading rb-heading-small"> Rate Our Work </h1>
                <p class="rb-description rb-recomended-theme-desc">We have a lot of awesome blocks. If you love our work please motivate us by giving 5 start rating
                </p>

                <div class="rb-rate-us">
                    <img src="<?php echo self::get_plugin_directory_uri().'/templates/img/star.jpg';?>" alt="stars" />
                </div>

                <div class="rb-btn-wrap with-icon">
                    <a href="https://wordpress.org/support/plugin/rise-blocks/reviews/#new-post" target="_blank" class="rb-icon-fav"> Rate Now </a>
                </div>
            </div>
        </div>        
    </div> <!-- rate our work-->
</div>

