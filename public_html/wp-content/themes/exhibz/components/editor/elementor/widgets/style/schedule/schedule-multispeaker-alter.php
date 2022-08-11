<section class="ts-schedule ts-schedule-alt">
   <div class="container">
      <div class="row">
         <!-- col end-->
         <div class="col-lg-12 text-center wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="500ms">
            <div class="ts-schedule-nav mb-70">
               <ul class="nav nav-tabs" role="tablist">
                  <?php                 extract([
                     'number' => $schedule_day_limit,
                     'order' => $schedule_order,
                     'class' => '',
                  ]);

                  global $post;
                  $multiple_speaker = [];
                  $args = array(
                     'post_type'             => 'ts-schedule',
                     'suppress_filters' => false,
                     'posts_per_page'          => esc_attr($number),
                     'order'                   => $order,
                  );

                  if(isset($schedule_term_id) && $schedule_term_id !=''){
                     $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'ts-schedule_cat',
                            'field' => 'term_id',
                            'terms' => $schedule_term_id
                             ),
                     );
                  };
                  
                  $i = 1;
                  $posts = get_posts($args);
                  foreach ($posts as $postnav) {
                     setup_postdata($postnav);
                  ?>
                     <?php if ($i == 1) { ?>
                        <li class="nav-item">
                           <a class="active" title="<?php echo get_the_title($postnav->ID) ?>" href="<?php echo esc_attr("#date" . $i); ?>" role="tab" data-toggle="tab">
                              <h3><?php echo get_the_title($postnav->ID) ?></h3>
                              <?php $schedule_day_v = fw_get_db_post_option($postnav->ID, 'schedule_day');
                              if (!empty($schedule_day_v)) {  ?>
                                 <h3><?php echo fw_get_db_post_option($postnav->ID, 'schedule_day'); ?></h3>
                              <?php } ?>
                           </a>
                        </li>
                     <?php } else { ?>
                        <li class="nav-item">
                           <a title="<?php echo get_the_title($postnav->ID) ?>" href="<?php echo esc_attr("#date" . $i); ?>" role="tab" data-toggle="tab">
                              <h3><?php echo get_the_title($postnav->ID) ?></h3>

                              <?php $schedule_day_v = fw_get_db_post_option($postnav->ID, 'schedule_day');
                              if (!empty($schedule_day_v)) {  ?>
                                 <h3><?php echo fw_get_db_post_option($postnav->ID, 'schedule_day'); ?></h3>
                              <?php } ?>
                           </a>
                        </li>
                     <?php  } ?>
                  <?php $i++;
                  }
                  wp_reset_postdata(); ?>
               </ul>
               <!-- Tab panes -->
            </div>
         </div>
         <!-- col end-->
      </div>
      <!-- row end-->
      <div class="row">
         <div class="col-lg-12">
            <div class="tab-content schedule-tabs">
               <?php              $j = 1;
               foreach ($posts as $post) {
                  setup_postdata($post);
                  $schedule_list = fw_get_db_post_option($post->ID)["exhibz_schedule_pop_up"];
               ?>
                  <?php if ($j == 1) { ?>
                     <div role="tabpanel" class="tab-pane active" id="<?php echo esc_attr("date" . $j); ?>">
                        <?php foreach ($schedule_list as $key => $schedule) { ?>
                           <?php

                           if ($key == $schedule_limit) {
                              break;
                           }

                           $speaker_one = '';
                           $speaker_two = '';
                           $speaker_three = '';

                           $speaker_id_one = '';
                           $speaker_id_two = '';
                           $speaker_id_three = '';

                           $schedule_speaker_multi = [];

                           $q = [];
                           $speaker_title = [];
                           $speaker_id = [];
                           $multiple_speaker = [];

                           if (array_key_exists("multi_speaker_choose", $schedule)) {
                              if (array_key_exists("style", $schedule["multi_speaker_choose"])) {
                                 $schedule_speaker_check = $schedule["multi_speaker_choose"];
                                 $schedule_speaker = $schedule_speaker_check["yes"]["multi_speakers"];
                                 if ($schedule_speaker_check["style"] == "yes") { //multi speaker style 
                                    $schedule_speaker_multi = $schedule_speaker_check["yes"]['multi_speakers'];

                                    // var_dump($schedule_speaker_multi);
                                    foreach ($schedule_speaker_multi as $sp_key => $speaker) {
                                       $multiple_speaker[] = exhibz_meta_option($speaker, "exhibs_photo");
                                       $single_sp = get_post($speaker);
                                       $speaker_id[] = $single_sp->ID;
                                       $speaker_title[] = $single_sp->post_title;
                                
                                    }
                                    // var_dump($multiple_speaker);

                                    // get speaker name
                                    $args = [
                                       'post_type'      => 'ts-speaker',
                                       'posts_per_page' => 10,
                                       'post__in'  => $schedule_speaker_multi,
                                    ];

                                    $q = get_posts($args, ARRAY_A);
                                 } else { //single speaker  

                                    if (is_string($schedule["speakers"]) && $schedule["speakers"] != '') {
                                       $multiple_speaker[] = exhibz_meta_option($schedule["speakers"], "exhibs_photo");
                                       if ($schedule["speakers"] != '' && $schedule["speakers"] > 0) {

                                          $q = get_post($schedule["speakers"]);
                                   
                                          $speaker_id[] = $q->ID;
                                          $speaker_title[] = $q->post_title;
                                       }
                                    } // single speaker
                                 }
                              }
                           } else {

                              if (is_string($schedule["speakers"]) && $schedule["speakers"] != '') {
                                 $multiple_speaker[] = exhibz_meta_option($schedule["speakers"], "exhibs_photo");
                                 if ($schedule["speakers"] != '' && $schedule["speakers"] > 0) {
                                    $q = get_post($schedule["speakers"]);
                                    // $speaker_one = $q->post_title;
                                    // $speaker_id_one = $q->ID;
                                    $speaker_id[] = $q->ID;
                                    $speaker_title[] = $q->post_title;
                                 }
                              } // single speaker

                           }
                           ?>
                           <div class="schedule-listing multi-schedule-list row">
                              <div class="col-lg-3">
                              <?php if($schedule["schedule_time"]): ?> 
                                 <div class="schedule-slot-time">
                                    <span> <?php echo esc_html($schedule["schedule_time"]); ?> </span>
                                 </div>
                              <?php endif; ?> 
                              </div>
                              <div class="col-lg-5">
                                 <div class="schedule-slot-info">
                                    <div class="schedule-slot-info-content">

                                       <h3 class="schedule-slot-title">
                                          <?php echo esc_html($schedule["schedule_title"]); ?>
                                          <!-- <strong>@ Fredric Martinsson </strong> -->
                                       </h3>
                                       <p>
                                          <?php echo exhibz_kses($schedule["schedule_note"]); ?>
                                       </p>
                                       </div>
                                       <!--Info content end -->
                                    </div>
                              </div>
                              <!-- Slot info end -->
                             <div class="col-lg-4">
                              <?php if (count($multiple_speaker)) : ?>
                                       <div class="<?php echo count($multiple_speaker) == 1 ? 'single-speaker-2' : 'multi-speaker-2' ?>">
                                          <?php foreach ($multiple_speaker as $key => $value) { ?>
                                             <div class="speaker-content">
                                                <?php $incremented_key = $key + 1; ?>
                                                <?php if (isset($value['attachment_id'])) : ?>
                                                   <a rel="noreferrer" href="<?php echo esc_url(get_the_permalink($speaker_id[$key])); ?>">
                                                      <img class="schedule-slot-speakers <?php echo esc_attr("speaker-img-" . $incremented_key); ?>" src="<?php echo wp_get_attachment_url($value["attachment_id"], 'thumbnail'); ?>" title="<?php echo esc_attr($speaker_title[$key]); ?>" alt="<?php echo esc_attr("speaker-" . $incremented_key); ?>"> </a>
                                                <?php endif; ?>
                                                <p class="schedule-speaker <?php echo esc_attr("speaker-" . $key); ?>">
                                                   <?php echo exhibz_kses($speaker_title[$key]); ?>
                                                </p>
                                             </div>
                                          <?php } ?>
                                       </div>
                                    <?php elseif ($schedule["speakers"] == '') : ?>
                                       <div class="single-speaker"></div>
                                    <?php endif; ?>
                                 <!-- .multispeaker end --> 
                             </div>
                           </div>
                        <?php    } // end loop schedule list 
                        ?>
                        <!--schedule-listing end -->
                     </div>
                  <?php } else { //active 
                  ?>
                     <div role="tabpanel" class="tab-pane" id="<?php echo esc_attr("date" . $j); ?>">
                        <?php foreach ($schedule_list as $key => $schedule) { ?>
                           <?php

                           if ($key == $schedule_limit) {
                              break;
                           }

                           $speaker_one = '';
                           $speaker_two = '';
                           $speaker_three = '';

                           $speaker_id_one = '';
                           $speaker_id_two = '';
                           $speaker_id_three = '';

                           $schedule_speaker_multi = [];

                           $q = [];
                           $speaker_title = [];
                           $speaker_id = [];
                           $multiple_speaker = [];

                           if (array_key_exists("multi_speaker_choose", $schedule)) {
                              if (array_key_exists("style", $schedule["multi_speaker_choose"])) {
                                 $schedule_speaker_check = $schedule["multi_speaker_choose"];
                                 $schedule_speaker = $schedule_speaker_check["yes"]["multi_speakers"];
                                 if ($schedule_speaker_check["style"] == "yes") { //multi speaker style 
                                    $schedule_speaker_multi = $schedule_speaker_check["yes"]['multi_speakers'];
                                    foreach ($schedule_speaker_multi as $sp_key => $speaker) {
                                       $multiple_speaker[] = exhibz_meta_option($speaker, "exhibs_photo");
                                       $single_sp = get_post($speaker);
                                       $speaker_id[] = $single_sp->ID;
                                       $speaker_title[] = $single_sp->post_title;
                                    }
                                 } else { //single speaker  

                                    if (is_string($schedule["speakers"]) && $schedule["speakers"] != '') {
                                       $multiple_speaker[] = exhibz_meta_option($schedule["speakers"], "exhibs_photo");
                                       if ($schedule["speakers"] != '' && $schedule["speakers"] > 0) {
                                          $q = get_post($schedule["speakers"]);
                                          $speaker_id[] = $q->ID;
                                          $speaker_title[] = $q->post_title;
                                       }
                                    } // single speaker
                                 }
                              }
                           } else {

                              if (is_string($schedule["speakers"]) && $schedule["speakers"] != '') {
                                 $multiple_speaker[] = exhibz_meta_option($schedule["speakers"], "exhibs_photo");
                                 if ($schedule["speakers"] != '' && $schedule["speakers"] > 0) {
                                    $q = get_post($schedule["speakers"]);
                                    $speaker_id[] = $q->ID;
                                    $speaker_title[] = $q->post_title;
                                 }
                              } // single speaker

                           }



                           ?>
                           <div class="schedule-listing multi-schedule-list row">
                              <div class="col-lg-3">
                                 <div class="schedule-slot-time">
                                    <span> <?php echo esc_html($schedule["schedule_time"]); ?> </span>
                                 </div>
                              </div>
                               <!--  col end -->
                             <div class="col-lg-5">
                                 <div class="schedule-slot-info">
                                 
                                    <div class="schedule-slot-info-content">
                                        <h3 class="schedule-slot-title">
                                             <?php echo esc_html($schedule["schedule_title"]); ?>
                                             <!-- <strong>@ Fredric Martinsson </strong> -->
                                          </h3>
                                          <p>
                                             <?php echo exhibz_kses($schedule["schedule_note"]); ?>
                                          </p>
                                       </div>
                                       <!--Info content end -->
                                    </div>
                                    <!-- Slot info end -->
                             </div>
                              <!--  col end -->
                              <div class="col-lg-4">
                                 <?php if (count($multiple_speaker)) : ?>
                                       <div class="<?php echo count($multiple_speaker) == 1 ? 'single-speaker-2' : 'multi-speaker-2' ?>">
                                          <?php foreach ($multiple_speaker as $key => $value) { ?>
                                             <div class="speaker-content">
                                                <?php $incremented_key = $key + 1; 
                                                if (isset($value['attachment_id'])) : ?>
                                                <a rel="noreferrer" href="<?php echo esc_url(get_the_permalink($speaker_id[$key])); ?>"> <img class="schedule-slot-speakers <?php echo esc_attr("speaker-img-" . $incremented_key); ?>" src="<?php echo wp_get_attachment_url($value["attachment_id"], 'thumbnail'); ?>" title="<?php echo esc_attr($speaker_title[$key]); ?>" alt="<?php echo esc_attr("speaker-" . $incremented_key); ?>"> </a>
                                                <?php endif; ?>
                                                <p class="schedule-speaker <?php echo esc_attr("speaker-" . $key); ?>">
                                                   <?php echo exhibz_kses($speaker_title[$key]); ?>
                                                </p>
                                             </div>
                                          <?php } ?>
                                       </div>
                                    <?php elseif ($schedule["speakers"] == '') : ?>
                                       <div class="single-speaker"></div>
                                    <?php endif; ?>
                              </div>
                               <!--  col end -->
                           </div>
                        <?php $multiple_speaker = array();
                           $q = '';
                        } // end loop schedule list 
                        ?>
                        <!--schedule-listing end -->
                     </div>
                  <?php } //end else  
                  ?>
               <?php                 $j++;
               }
               wp_reset_postdata(); ?>
            </div>
         </div>
      </div>
   </div>
   <!-- container end-->
</section>