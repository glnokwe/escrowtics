<?php
 /**
 * Reload Ticket Chat
 * @since 1.0.0
 * @package Escrowtics
 */

$img_exts = ['jpg', 'jpeg', 'png', 'webp'];

ob_start(); // Start output buffering
?>
<div class="p-5 messages text-dark">
    <ul>
        <?php foreach ($ticket_meta as $meta) : ?>
            <?php if ($meta['author'] === 'User') : ?>
                <?php 
                $user_img = escrot_single_user_data('user_image', 'username', $data['user']);
                $user_name = esc_html($data['user']);
                ?>
                <li class="sent">
                    <?php echo escrot_image($user_img, '50', 'escrot-rounded'); ?>
                    <p style="font-size: 13px !important;">
                        <span class="small text-gray">
                            <i class="fa fa-user"></i> <?php echo $user_name; ?>
                        </span><br><br>
                        <?php if ($meta['meta_type'] === 'File') : ?>
                            <?php 
                            $file_name = basename($meta['meta_value']);
                            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            ?>
                            <?php if (in_array($file_ext, $img_exts, true)) : ?>
                                <img class="escrot-img-preview" src="<?php echo esc_url($meta['meta_value']); ?>" alt="<?php echo esc_attr($file_name); ?>"/><br>
                                <span>
                                    <a href="<?php echo esc_url($meta['meta_value']); ?>" target="_blank">View image</a>
                                </span>
                            <?php elseif ($file_ext === 'pdf') : ?>
                                <a href="<?php echo esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?php echo escrot_image(ESCROT_PLUGIN_URL . 'assets/img/pdf-file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?php echo escrot_image(ESCROT_PLUGIN_URL . 'assets/img/file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php echo esc_html($meta['meta_value']); ?>
                        <?php endif; ?>
                        <br><br>
                        <span style="color: #87a1ac !important;" class="small">
                            <i class="fa fa-clock"></i> <?php echo esc_html($meta['creation_date']); ?>
                        </span>
                    </p>
                </li>
            <?php else : ?>
                <li class="replies">
                    <?php echo escrot_image(ESCROT_PLUGIN_URL . 'assets/img/escrowtics.png', '50', 'escrot-rounded'); ?>
                    <p style="font-size: 13px !important;">
                        <span class="small text-gray float-right">
                            <i class="fa fa-user"></i> Admin
                        </span><br><br>
                        <?php if ($meta['meta_type'] === 'File') : ?>
                            <?php 
                            $file_name = basename($meta['meta_value']);
                            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            ?>
                            <?php if (in_array($file_ext, $img_exts, true)) : ?>
                                <img class="escrot-img-preview" src="<?php echo esc_url($meta['meta_value']); ?>" alt="<?php echo esc_attr($file_name); ?>"/><br>
                                <span>
                                    <a href="<?php echo esc_url($meta['meta_value']); ?>" target="_blank">View image</a>
                                </span>
                            <?php elseif ($file_ext === 'pdf') : ?>
                                <a href="<?php echo esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?php echo escrot_image(ESCROT_PLUGIN_URL . 'assets/img/pdf-file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?php echo escrot_image(ESCROT_PLUGIN_URL . 'assets/img/file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php echo esc_html($meta['meta_value']); ?>
                        <?php endif; ?>
                        <br><br>
                        <span style="color: #87a1ac !important;" class="small">
                            <i class="fa fa-clock"></i> <?php echo esc_html($meta['creation_date']); ?>
                        </span>
                    </p>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php
$output = ob_get_clean(); // Get and clean the buffered output
return $output;
