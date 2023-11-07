                            <div class="bloc__image">
                                <div class="bloc-picto">
                                        <div class="bloc__image__eye">
                                            <a href="<?php the_permalink(); ?>"><img class="picto-eye" src="<?php echo get_template_directory_uri(); ?>/img/icon_eye.svg" alt="picto oeil"></a>
                                        </div>
                                        <div class="bloc__image__fullscreen">
                                            <a href="#"><img class="picto-fullscreen" src="<?php echo get_template_directory_uri(); ?>/img/icon_fullscreen.svg" alt="picto plein ecran"></a>
                                        </div>
                                        <div class="bloc__image__info">
                                            <p><?php echo get_post_meta( get_the_ID(), 'reference', true );?></p>
                                            <p><?php $categories = get_the_terms(get_the_ID(), 'categorie');
                                                if ($categories && !is_wp_error($categories)) {
                                                    echo implode(', ', wp_list_pluck($categories, 'name'));
                                                }?>
                                            </p>
                                        </div>
                                </div>
                                <?php the_post_thumbnail('large',['class' => 'bloc__image__thumbnail']);?>

                            </div>